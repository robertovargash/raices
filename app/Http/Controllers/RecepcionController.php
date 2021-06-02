<?php

namespace App\Http\Controllers;
use App\Http\Controllers\DB;
use App\Models\Almacen;
use App\Models\Almacenmercancia;
use App\Models\Mercancia;
use App\Models\Recepcion;
use App\Models\Proveedor;
use App\Models\Recepcionmercancia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;

class RecepcionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:gestion_recepcion', ['only' => ['store','edit','show','update','cancelar']]);
        $this->middleware('permission:firma_recepcion', ['only' => ['firmar']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $recepcionNueva = Recepcion::create($request->all());
        $recepcionNueva->numero = Recepcion::count();
        $recepcionNueva->fecha = now();
        $recepcionNueva->save();
        return redirect()->route('recepcions.edit',$recepcionNueva)->with('success','Recepción insertada.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recepcion  $recepcion
     * @return \Illuminate\Http\Response
     */
    public function show(Recepcion $recepcion)
    {
        $mercancias = Mercancia::all();
        $title = "Mostrando recepción";
        return view('recepciones.show',compact('title','recepcion','mercancias'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Recepcion  $recepcion
     * @return \Illuminate\Http\Response
     */
    public function edit(Recepcion $recepcion)
    {
        if ($recepcion->activo == 0) {
            //se buscan los productos que tenga la recepcion
            $recepmercancias = Recepcionmercancia::select('mercancia_id')->where('recepcionmercancias.recepcion_id','=',$recepcion->id)->get();
            //Se buscan los productos del codificador producto
            $mercancias = Mercancia::all();
            //aqui se buscan los productos que esten en 'productos' pero no en la recepcion, con diff
            $mercancias = $mercancias->diff(Mercancia::whereIn('id', $recepmercancias)->get());
            $title = "Editando recepción";
            return view('recepciones.edit',compact('title','recepcion','mercancias'));
        }else{
            return back()->with('warning','No se puede, no está en proceso');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Recepcion  $recepcion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recepcion $recepcion)
    {
        $recepcion->update($request->all());

        $almacen = $recepcion->almacen;
        $url = URL::route('almacens.edit',$almacen) . '#cardRecepciones';
        return Redirect::to($url)->with('success','Recepción modificada.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recepcion  $recepcion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

    }

    public function cancelar(Request $request)
    {
        $recepcion_id=$request->input('id');
        $recepcion = Recepcion::find($recepcion_id);
        $almacen = Almacen::find($recepcion->almacen_id);
        if ($recepcion->activo == 0) {
            $recepcion->activo = 2;//En ves de eliminar, cancelo
            $recepcion->save();
            $url = URL::route('almacens.edit',$almacen) . '#cardRecepciones';
            return Redirect::to($url)->with('success','Recepción cancelada');
        }else{
            $url = URL::route('almacens.edit',$almacen) . '#cardRecepciones';
            return Redirect::to($url)->with('error','No se pudo cancelar, no esta en proceso');
        }
    }

    public function imprimir(Recepcion $recepcion)
    {
        //este funciona bien, pero solo en chrome
        $title = "IRM ".$recepcion->id;
        // return view('vales.valepdf',compact('title','vale','mercancias'));
        $importetotal = 0;
        $proveedor = Proveedor::first();
        foreach ($recepcion->recepcionmercancias as $key => $item) {
            foreach ($recepcion->almacen->almacenmercancias as $key => $mercancia) {
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
        ])->loadView('recepciones.pdf', compact('title','recepcion','proveedor','importetotal'));
    	 return $pdf->setPaper('chart','landscape')->stream('IRM'.$recepcion->id.'.pdf');
    }

    public function firmar(Request $request)
    {
        $recepcion_id=$request->input('id');
        $recepcion = Recepcion::find($recepcion_id);
        $almacen = Almacen::find($recepcion->almacen_id);
        if ($recepcion->activo == 0) {
            $recepcion->activo = 1;//Lo firmo
            $recepcion->p_autoriza = Auth::user()->name;
            //al firmar la recepcion se pasan las mercancias de la recepcion
            //para el almacen, tabla almacenmercancias
            //y se actualiza el precio en el codificador mercancia
            foreach ($recepcion->recepcionmercancias as $recepcionmercancia) {
                $almacenmercancia = Almacenmercancia::where('almacenmercancias.mercancia_id','=',$recepcionmercancia->mercancia_id)->where('almacenmercancias.almacen_id','=',$almacen->id)->first();
                $precio1 = $almacenmercancia->precio;
                $cantidad1 = $almacenmercancia->cantidad;
                //Esto comentado estaba, pero tuve que cambiar el diseño
                //Pues los precios deben ser generales,
                $almacenmercancia->cantidad = $almacenmercancia->cantidad + $recepcionmercancia->cantidad;
                $mercancia = Mercancia::find($almacenmercancia->mercancia_id);
                $precio1 = $mercancia->precio;
                $mercancia->precio = (($precio1*$cantidad1) +  ($recepcionmercancia->precio*$recepcionmercancia->cantidad))/($cantidad1 + $recepcionmercancia->cantidad);
                $almacenmercancia->save();
                $mercancia->save();
            }
            $recepcion->save();
            $url = URL::route('almacens.edit',$almacen) . '#cardRecepciones';
            return Redirect::to($url)->with('success','Recepción firmada');
        }else{
            $url = URL::route('almacens.edit',$almacen) . '#cardRecepciones';
            return Redirect::to($url)->with('error','No se pudo firmar, no esta en proceso');
        }
    }
}
