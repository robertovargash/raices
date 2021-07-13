<?php

namespace App\Http\Controllers;
use App\Models\Almacen;
use App\Models\Almacenmercancia;
use App\Models\Mercancia;
use App\Models\Ordentrabajo;
use App\Models\Otsolicitude;
use App\Models\Proveedor;
use App\Models\Solicitudmateriasprima;
use App\Models\Vale;
use App\Models\Vale_item;
use App\Models\Valeitem;
use App\Models\Valeitem as ModelsValeitem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;


class ValeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        //  $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
        //  $this->middleware('permission:role-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:role-delete', ['only' => ['destroy']]);+
        $this->middleware('permission:gestion_vale', ['only' => ['store','edit','update','show','cancelar']]);
        $this->middleware('permission:firma_vale', ['only' => ['firmar']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valeNuevo = Vale::create($request->all());
        $valeNuevo->numero = Vale::count();
        $valeNuevo->fecha = now();
        $valeNuevo->save();
        if ($valeNuevo->tipovale == 1) {

            $otsolicitudegroup = DB::table('solicitudmateriasprimas')->join('mercancias','mercancias.id','solicitudmateriasprimas.mercancia_id')
            ->join('solicitudes','solicitudes.id','solicitudmateriasprimas.solicitude_id')
            ->join('solicitudproductos','solicitudproductos.id','solicitudmateriasprimas.solicitudproducto_id')
            ->join('tproductos','tproductos.id','solicitudproductos.tproducto_id')
            ->join('otsolicitudes','otsolicitudes.solicitude_id','solicitudes.id')
            ->join('ordentrabajos','ordentrabajos.id','otsolicitudes.ordentrabajo_id')
            ->where('tproductos.id',$valeNuevo->ordentrabajo->tproducto_id)
            ->where('ordentrabajos.id',$valeNuevo->ordentrabajo->id)
            ->groupBy('tproductos.nombre','mercancias.id','mercancias.precio','ordentrabajos.numero')
            ->select(DB::raw('sum(solicitudmateriasprimas.cantidad) as cantidadnecesaria'),'mercancias.id','mercancias.precio')->get();


           foreach ($otsolicitudegroup as $key => $materiaprima) {
                $almacenmercancia = Almacenmercancia::where('almacenmercancias.mercancia_id','=',$materiaprima->id)
                                                    ->where('almacenmercancias.almacen_id','=',$valeNuevo->almacen_id)->first();
                if ($almacenmercancia->cantidad <= $materiaprima->cantidadnecesaria) {
                    Valeitem::create([
                        "vale_id"=>$valeNuevo->id,
                        "mercancia_id"=>$materiaprima->id,
                        //si la cantidad q se necesita es mayor a la existente, se pone la existente
                        "cantidad"=>$almacenmercancia->cantidad,
                        "precio"=>$materiaprima->precio
                    ]);
                    $almacenmercancia->cantidad = 0;
                    $almacenmercancia->save();
                }else {
                    Valeitem::create([
                        "vale_id"=>$valeNuevo->id,
                        "mercancia_id"=>$materiaprima->id,
                        //si no, la cantidad necesaria * la cantidad de productos,
                        //pues una orden trae varios productos
                        "cantidad"=>$materiaprima->cantidadnecesaria,
                        "precio"=>$materiaprima->precio
                    ]);
                    //descuento la cantidad
                    $almacenmercancia->cantidad = $almacenmercancia->cantidad - $materiaprima->cantidadnecesaria;
                    $almacenmercancia->save();
                }
                $ordenTrabajo = Ordentrabajo::find($valeNuevo->ordentrabajo_id);
                $ordenTrabajo->estado = 1;
                $ordenTrabajo->save();
           }
        }
        return redirect()->route('vales.edit',$valeNuevo)->with('success','Vale insertado');;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vale  $vale
     * @return \Illuminate\Http\Response
     */
    public function show(Vale $vale)
    {
        // $mercancias = Mercancia::all();
        $title = "Vale de salida";
        return view('vales.show',compact('title','vale'));
    }

    public function imprimir(Vale $vale)
    {
        //este funciona bien, pero solo en chrome
        $title = "Vale de salida ".$vale->id;
        // return view('vales.valepdf',compact('title','vale','mercancias'));
        $importetotal = 0;
        $proveedor = Proveedor::first();
        foreach ($vale->valeitems as $key => $item) {
            foreach ($vale->almacen->almacenmercancias as $key => $mercancia) {
                if ($mercancia->mercancia_id === $item->mercancia_id) {
                    $item->existencia = $mercancia->cantidad;
                }
            }
            $item->importe = round(($item->precio * $item->cantidad),2);
            $importetotal = $importetotal + round(($item->precio * $item->cantidad),2);
        }
         $pdf = PDF::setOptions([
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ])->loadView('vales.pdf', compact('title','vale','proveedor','importetotal'));
    	 return $pdf->setPaper('chart','landscape')->stream('Vale'.$vale->numero.'.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vale  $vale
     * @return \Illuminate\Http\Response
     */
    public function edit(Vale $vale)
    {
        if ($vale->activo == 0) {
            //se buscan los productos que tenga el vale
            $productoss = Valeitem::select('mercancia_id')->where('valeitems.vale_id','=',$vale->id)->get();
            //Se buscan los productos del almacen
            $mercancias = Almacenmercancia::where('almacenmercancias.almacen_id','=',$vale->almacen->id)->get();
            //aqui se buscan los productos que esten en almacen pero no en el vale, con diff
            // $mercancias = $mercancias->diff(Almacenmercancia::whereIn('mercancia_id', $productoss)->get());
            foreach ($mercancias as $key => $mercancia) {
                if (Valeitem::where('valeitems.vale_id','=',$vale->id)->where('valeitems.mercancia_id','=',$mercancia->id)->count() > 0) {
                    $valeitem = Valeitem::where('valeitems.vale_id','=',$vale->id)->where('valeitems.mercancia_id','=',$mercancia->id)->first();
                    $mercancia->existe = 1;
                }else{
                    $valeitem = Valeitem::where('valeitems.vale_id','=',$vale->almacen_id)->where('valeitems.mercancia_id','=',$mercancia->id)->first();
                    $mercancia->existe = 0;
                }
            }

            $title = "Editando el vale";
            return view('vales.edit',compact('title','vale','mercancias'));
        }else{
            return back()->with('warning','No se puede, no está en proceso');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vale  $vale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vale $vale)
    {
        $vale->update($request->all());

        $almacen = $vale->almacen;
        $url = URL::route('almacens.edit',$almacen) . '#cardVales';
        return Redirect::to($url)->with('success','Vale modificado');
    }


    public function firmar(Request $request, Vale $vale)
    {
        $vale_id=$request->input('id');
        $vale = Vale::find($vale_id);
        $almacen = Almacen::find($vale->almacen_id);
        if ($vale->activo == 0) {
            $vale->activo = 1;
            $vale->p_autoriza = Auth::user()->name;
            $vale->save();
            $url = URL::route('almacens.edit',$almacen) . '#cardVales';
            return Redirect::to($url)->with('success','Vale firmado');
        }else{
            $url = URL::route('almacens.edit',$almacen) . '#cardVales';
            return Redirect::to($url)->with('error','No se puede firmar, no esta en proceso');
        }
    }

    /**
     * Remove the specified resource from storage.
     * No, cancela el vale y devuelve todo.
     *
     * @param  \App\Models\Vale  $vale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

    }

    public function cancelar(Request $request)
    {
        $vale_id=$request->input('id');
        $vale = Vale::find($vale_id);
        $almacen = Almacen::find($vale->almacen_id);
        if ($vale->activo == 0) {
            $vale->activo = 2;
            foreach ($vale->valeitems as $valeitem){//si cancelo, devuelvo todo
                $almacenmercancia = Almacenmercancia::where('almacenmercancias.mercancia_id','=',$valeitem->mercancia_id)->
                                        where('almacenmercancias.almacen_id','=',$vale->almacen_id)->first();
                // $almacenmercancia = Almacenmercancia::find($talmacenmercancia->id);
                $almacenmercancia->cantidad = $almacenmercancia->cantidad + $valeitem->cantidad;
                $almacenmercancia->save();
            }
            $vale->save();
            if ($vale->tipovale == 1) {
                $vale_ordenTrabajo = Ordentrabajo::find($vale->ordentrabajo_id);
                //aqui primero busco una OT que este abierta del producto, para no tener 2 OT del mismo producto abierta.
                //y le mando todas las solicitudes para alla
                $ordenTrabajo = Ordentrabajo::where('ordentrabajos.estado','=',0)
                                ->where('ordentrabajos.tproducto_id','=',$vale_ordenTrabajo->tproducto_id)
                                ->where('ordentrabajos.id','!=',$vale_ordenTrabajo->id)
                                ->first();
                if ($ordenTrabajo) {
                    $ordenTrabajo->cantidad = $ordenTrabajo->cantidad + $vale_ordenTrabajo->cantidad;
                    foreach ($vale_ordenTrabajo->otsolicitudes as $key => $otsolicitud) {
                        //por cada solicitud que tenia esa OT,
                        //creo una nueva con la cantidad original, pero ahora son de la OT abierta
                        Otsolicitude::create([
                            "ordentrabajo_id"=>$ordenTrabajo->id,
                            "solicitude_id"=>$otsolicitud->solicitude_id,
                            "cantidad"=>$otsolicitud->cantidad,
                            "terminado"=>0
                        ]);
                    }
                    $ordenTrabajo->save();
                    $vale_ordenTrabajo->estado = 3;//al final la OT actual la cambio a cancelada
                }else{
                    $vale_ordenTrabajo->estado = 0;//Cambio el estado de la OT a Proceso
                }
                $vale_ordenTrabajo->save();
            }

            $url = URL::route('almacens.edit',$almacen) . '#cardVales';
            return Redirect::to($url)->with('success','Vale cancelado');
        }else{
            $url = URL::route('almacens.edit',$almacen) . '#cardVales';
            return Redirect::to($url)->with('error','No se puede cancelar, no esta en proceso');
        }
    }
}
