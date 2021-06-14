<?php

namespace App\Http\Controllers;

use App\Models\Solicitudmateriasprima;
use App\Models\Oferta;
use App\Models\Ofertaproducto;
use App\Models\Ofertamercancia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;

class SolicitudmateriasprimaController extends Controller
{
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Solicitudmateriasprima  $solicitudmateriasprima
     * @return \Illuminate\Http\Response
     */
    public function show(Solicitudmateriasprima $solicitudmateriasprima)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Solicitudmateriasprima  $solicitudmateriasprima
     * @return \Illuminate\Http\Response
     */
    public function edit(Solicitudmateriasprima $solicitudmateriasprima)
    {
        //
        
    }

    public function editar(Request $request)
    {
        $solmprima = Solicitudmateriasprima::find($request->id);
        $oferta = Oferta::where('estado',1)->first();
        $ofertamercancia = Ofertamercancia::where('ofertamercancias.oferta_id',$oferta->id)->where('ofertamercancias.mercancia_id',$solmprima->mercancia_id)->first();
        $ofertamercancia->cantidad = $ofertamercancia->cantidad +  $solmprima->cantidad;
        $ofertamercancia->save();

        $solmprima->update($request->all());
        $ofertamercancia = Ofertamercancia::where('ofertamercancias.oferta_id',$oferta->id)->where('ofertamercancias.mercancia_id',$solmprima->mercancia_id)->first();
        $ofertamercancia->cantidad = $ofertamercancia->cantidad - $solmprima->cantidad;
        $ofertamercancia->save();
        $url = URL::route('solicitudproductos.edit',$solmprima->solicitudproducto) . '#cardMercancias';
        return Redirect::to($url)->with('success','Mercancía modificada!!!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Solicitudmateriasprima  $solicitudmateriasprima
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Solicitudmateriasprima $solicitudmateriasprima)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Solicitudmateriasprima  $solicitudmateriasprima
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $solmprima = Solicitudmateriasprima::find($request->id);
        $oferta = Oferta::where('estado',1)->first();
        $ofertamercancia = Ofertamercancia::where('ofertamercancias.oferta_id',$oferta->id)->where('ofertamercancias.mercancia_id',$solmprima->mercancia_id)->first();
        $ofertamercancia->cantidad = $ofertamercancia->cantidad +  $solmprima->cantidad;
        $ofertamercancia->save();
        $solmprima->delete();

        $url = URL::route('solicitudproductos.edit',$solmprima->solicitudproducto) . '#cardMercancias';
        return Redirect::to($url)->with('success','Mercancía eliminada!!!');
    }
}
