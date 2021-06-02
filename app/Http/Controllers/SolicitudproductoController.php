<?php

namespace App\Http\Controllers;

use App\Models\Oferta;
use App\Models\Ofertaproducto;
use App\Models\Ordentrabajo;
use App\Models\Otsolicitude;
use App\Models\Solicitude;
use App\Models\Solicitudproducto;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Http\Request;

class SolicitudproductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:gestion_solicitud', ['only' => ['store','editar','destroy']]);
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
        $solicitudproducto = Solicitudproducto::create($request->all());
        $solicitude = Solicitude::findorFail($solicitudproducto->solicitude_id);
        //Este bloque es para descontar de la oferta la cantidad
        $oferta = Oferta::where('estado',1)->first();
        $ofertaproducto = Ofertaproducto::where('ofertaproductos.oferta_id',$oferta->id)->where('ofertaproductos.tproducto_id',$solicitudproducto->tproducto_id)->first();
        $ofertaproducto->cantidad = $ofertaproducto->cantidad -  $solicitudproducto->cantidad;
        $ofertaproducto->save();
        // return redirect()->route('solicitudes.edit',$solicitude)->with('success','Elemento insertado');
        $url = URL::route('solicitudes.edit',$solicitude) . '#cardProductos';
        return Redirect::to($url)->with('success','Producto insertado!!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Solicitudproducto  $solicitudproducto
     * @return \Illuminate\Http\Response
     */
    public function show(Solicitudproducto $solicitudproducto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Solicitudproducto  $solicitudproducto
     * @return \Illuminate\Http\Response
     */
    public function edit(Solicitudproducto $solicitudproducto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Solicitudproducto  $solicitudproducto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Solicitudproducto $solicitudproducto)
    {
        //
    }

    public function editar(Request $request)
    {
        $solicitudproducto = Solicitudproducto::find($request->id);
        $solicitude = Solicitude::find($solicitudproducto->solicitude_id);

        $oferta = Oferta::where('estado',1)->first();
        $ofertaproducto = Ofertaproducto::where('ofertaproductos.oferta_id',$oferta->id)->where('ofertaproductos.tproducto_id',$solicitudproducto->tproducto_id)->first();
        $ofertaproducto->cantidad = $ofertaproducto->cantidad +  $solicitudproducto->cantidad;
        $ofertaproducto->save();

        $solicitudproducto->update($request->all());
        $ofertaproducto = Ofertaproducto::where('ofertaproductos.oferta_id',$oferta->id)->where('ofertaproductos.tproducto_id',$solicitudproducto->tproducto_id)->first();
        $ofertaproducto->cantidad = $ofertaproducto->cantidad - $solicitudproducto->cantidad;
        $ofertaproducto->save();
        // return redirect()->route('solicitudes.edit', $solicitude)->with('success','Producto modificado!!!');
        $url = URL::route('solicitudes.edit',$solicitude) . '#cardProductos';
        return Redirect::to($url)->with('success','Producto Modificado!!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Solicitudproducto  $solicitudproducto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $solicitudproducto_id = $request->input('id');
        $solicitudproducto = Solicitudproducto::find($solicitudproducto_id);
        $solicitude = Solicitude::find($solicitudproducto->solicitude_id);
        //Este bloque es para devolver a la oferta la cantidad
        $oferta = Oferta::where('estado',1)->first();
        $ofertaproducto = Ofertaproducto::where('ofertaproductos.oferta_id',$oferta->id)->where('ofertaproductos.tproducto_id',$solicitudproducto->tproducto_id)->first();
        $ofertaproducto->cantidad = $ofertaproducto->cantidad + $solicitudproducto->cantidad;
        $ofertaproducto->save();
        $solicitudproducto->delete();
        // return redirect()->route('solicitudes.edit',$solicitude)->with('success','Elemento eliminado.');
        $url = URL::route('solicitudes.edit',$solicitude) . '#cardProductos';
        return Redirect::to($url)->with('success','Producto eliminado!!!');
    }
}
