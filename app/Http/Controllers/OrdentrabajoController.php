<?php

namespace App\Http\Controllers;

use App\Models\Ordentrabajo;
use App\Models\Otsolicitude;
use App\Models\Solicitude;
use App\Models\Vale;
use App\Models\Valeitem;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\Proveedor;
use App\Models\Solicitudmateriasprima;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdentrabajoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:gestion_ot', ['only' => ['index','edit','show','update','cancelar','terminar','pdf']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ordentrabajos = Ordentrabajo::all();
        $title = "Órdenes de trabajos";
        return view('ordentrabajos.index', compact('ordentrabajos','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $ot = Ordentrabajo::create($request->all());
        // return redirect()->route('ordentrabajos.edit',$ot)->with('success', 'Órden insertada!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ordentrabajo  $ordentrabajo
     * @return \Illuminate\Http\Response
     */
    public function show(Ordentrabajo $ordentrabajo)
    {
        $otsolicitudes = Otsolicitude::all();
        $title = "Datos de OT";
        $otsolicitudegroup = DB::table('solicitudmateriasprimas')->join('mercancias','mercancias.id','solicitudmateriasprimas.mercancia_id')
                            ->join('solicitudes','solicitudes.id','solicitudmateriasprimas.solicitude_id')
                            ->join('solicitudproductos','solicitudproductos.id','solicitudmateriasprimas.solicitudproducto_id')
                            ->join('tproductos','tproductos.id','solicitudproductos.tproducto_id')                           
                            ->join('otsolicitudes','otsolicitudes.solicitude_id','solicitudes.id')
                            ->join('ordentrabajos','ordentrabajos.id','otsolicitudes.ordentrabajo_id')
                            ->where('tproductos.id',$ordentrabajo->tproducto_id)
                            ->where('ordentrabajos.id',$ordentrabajo->id)
                            ->groupBy('tproductos.nombre','mercancias.nombremercancia','mercancias.precio','ordentrabajos.numero')
                            ->select(DB::raw('sum(solicitudmateriasprimas.cantidad) as cantidadsumada'),DB::raw('(sum(solicitudmateriasprimas.cantidad) * mercancias.precio) as importe'),'mercancias.nombremercancia','mercancias.precio')->get();
        return view('ordentrabajos.show',compact('title','ordentrabajo','otsolicitudes','otsolicitudegroup'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ordentrabajo  $ordentrabajo
     * @return \Illuminate\Http\Response
     */
    public function edit(Ordentrabajo $ordentrabajo)
    {
        if ( $ordentrabajo->estado == 0 || $ordentrabajo->estado == 1) {
            $title = "Editando OT";
            $otsolicitudegroup = DB::table('solicitudmateriasprimas')->join('mercancias','mercancias.id','solicitudmateriasprimas.mercancia_id')
                            ->join('solicitudes','solicitudes.id','solicitudmateriasprimas.solicitude_id')
                            ->join('solicitudproductos','solicitudproductos.id','solicitudmateriasprimas.solicitudproducto_id')
                            ->join('tproductos','tproductos.id','solicitudproductos.tproducto_id')                           
                            ->join('otsolicitudes','otsolicitudes.solicitude_id','solicitudes.id')
                            ->join('ordentrabajos','ordentrabajos.id','otsolicitudes.ordentrabajo_id')
                            ->where('tproductos.id',$ordentrabajo->tproducto_id)
                            ->where('ordentrabajos.id',$ordentrabajo->id)
                            ->groupBy('tproductos.nombre','mercancias.nombremercancia','mercancias.precio','ordentrabajos.numero')
                            ->select(DB::raw('sum(solicitudmateriasprimas.cantidad) as cantidadsumada'),DB::raw('(sum(solicitudmateriasprimas.cantidad) * mercancias.precio) as importe'),'mercancias.nombremercancia','mercancias.precio')->get();

            // dd($otsolicitudegroup);
            return view('ordentrabajos.edit',compact('ordentrabajo','title','otsolicitudegroup'));
        }else {
            return redirect()->route('ordentrabajos.index')->with('error','La OT no se puede modificar');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ordentrabajo  $ordentrabajo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ordentrabajo $ordentrabajo)
    {
        $ordentrabajo->update($request->all());

        return redirect()->route('ordentrabajos.index')->with('success','Órden modificada!!.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ordentrabajo  $ordentrabajo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

    }

    public function cancelar(Request $request)
    {
        $ot_id=$request->input('id');
        $ot = Ordentrabajo::find($ot_id);
        if ($ot->estado == 0) {
            $ot->estado = 3;
            $ot->save();
            return redirect()->route('ordentrabajos.index')->with('success','OT cancelada');
        }else{
            return redirect()->route('ordentrabajos.index')->with('error','La órden no se puede cancelar, no está en proceso');
        }
    }

    public function terminar(Request $request)
    {
        $ot_id=$request->input('id');
        $ot = Ordentrabajo::find($ot_id);
        if ($ot->estado == 1) {
            $ot->estado = 2;
            $ot->save();
            foreach ($ot->otsolicitudes as $key => $otsolicitude) {
                $solicitude = Solicitude::find($otsolicitude->solicitude_id);
                if ($otsolicitude->terminado == 0) {
                    $otsolicitude->terminado = 1;//Marco como terminados todos los elementos
                    foreach ($solicitude->solicitudproductos as $key => $solicitudproducto) {
                        if ($solicitudproducto->tproducto_id == $otsolicitude->ordentrabajo->tproducto_id) {
                            $solicitudproducto->terminado = 1;
                            $solicitudproducto->save();
                        }
                    }
                    $finished = true;
                    foreach ($solicitude->solicitudproductos as $key => $solicitudproducto) {
                        if ($solicitudproducto->terminado != 1) {
                            $finished = false;
                        }
                    }
                    if ($finished) {//Si todos los elementos de la solicitud estan terminados
                        $solicitude->estado = 2;//Marco la solicitud como terminada
                        $solicitude->save();
                    }
                    $otsolicitude->save();
                }
            }
            return redirect()->route('ordentrabajos.index')->with('success','OT terminada');
        }else{
            return redirect()->route('ordentrabajos.index')->with('error','La órden no se puede terminar, no está en confirmada. Abra un vale para confirmar.');
        }
    }

    public function pdf(Ordentrabajo $ot)
    {
        //este funciona bien, pero solo en chrome
        $title = "OT ".$ot->numero;
        // return view('vales.valepdf',compact('title','vale','mercancias'));
        $proveedor = Proveedor::first();
        $otsolicitudes = Otsolicitude::all();
        $otsolicitudegroup = DB::table('solicitudmateriasprimas')->join('mercancias','mercancias.id','solicitudmateriasprimas.mercancia_id')
                            ->join('solicitudes','solicitudes.id','solicitudmateriasprimas.solicitude_id')
                            ->join('solicitudproductos','solicitudproductos.id','solicitudmateriasprimas.solicitudproducto_id')
                            ->join('tproductos','tproductos.id','solicitudproductos.tproducto_id')                           
                            ->join('otsolicitudes','otsolicitudes.solicitude_id','solicitudes.id')
                            ->join('ordentrabajos','ordentrabajos.id','otsolicitudes.ordentrabajo_id')
                            ->where('tproductos.id',$ot->tproducto_id)
                            ->where('ordentrabajos.id',$ot->id)
                            ->groupBy('tproductos.nombre','mercancias.nombremercancia','mercancias.precio','ordentrabajos.numero')
                            ->select(DB::raw('sum(solicitudmateriasprimas.cantidad) as cantidadsumada'),DB::raw('(sum(solicitudmateriasprimas.cantidad) * mercancias.precio) as importe'),'mercancias.nombremercancia','mercancias.precio')->get();
         $pdf = PDF::setOptions([
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ])->loadView('ordentrabajos.pdf', compact('title','ot','otsolicitudes','proveedor','otsolicitudegroup'));
    	 return $pdf->setPaper('chart','landscape')->stream('OT'.$ot->numero.'.pdf');
    }
}
