<?php

namespace App\Http\Controllers;

use App\Models\Ofertaproducto;
use App\Models\Oferta;
use App\Models\Ofertamercancia;
use Illuminate\Http\Request;

class OfertaproductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:gestion_oferta', ['only' => ['store','editar','destroy']]);
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
        $ofertaproducto = Ofertaproducto::create($request->all());
        $oferta = Oferta::find($ofertaproducto->oferta_id);
        foreach ($ofertaproducto->tproducto->materiaprimas as $key => $materiaprima) {
            $ofertamercancia = Ofertamercancia::where('oferta_id', $oferta->id)->where('mercancia_id', $materiaprima->mercancia_id)->first();
            $ofertamercancia->cantidad =  $ofertamercancia->cantidad - ($materiaprima->cantidadnecesaria * $ofertaproducto->cantidad);
            $ofertamercancia->save();
        }
        return redirect()->route('ofertas.edit',$oferta)->with('success','Producto insertado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ofertaproducto  $ofertaproducto
     * @return \Illuminate\Http\Response
     */
    public function show(Ofertaproducto $ofertaproducto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ofertaproducto  $ofertaproducto
     * @return \Illuminate\Http\Response
     */
    public function edit(Ofertaproducto $ofertaproducto)
    {

    }

    public function editar(Request $request)
    {
        $ofertaproducto = Ofertaproducto::find($request->id);
        $oferta = Oferta::find($ofertaproducto->oferta_id);
        //primero devuelvo
        foreach ($ofertaproducto->tproducto->materiaprimas as $key => $materiaprima) {
            $ofertamercancia = Ofertamercancia::where('oferta_id', $oferta->id)->where('mercancia_id', $materiaprima->mercancia_id)->first();
            $ofertamercancia->cantidad =  $ofertamercancia->cantidad + ($materiaprima->cantidadnecesaria * $ofertaproducto->cantidad);
            $ofertamercancia->save();
        }
        $ofertaproducto->update($request->all());
        //despues descuento
        foreach ($ofertaproducto->tproducto->materiaprimas as $key => $materiaprima) {
            $ofertamercancia = Ofertamercancia::where('oferta_id', $oferta->id)->where('mercancia_id', $materiaprima->mercancia_id)->first();
            $ofertamercancia->cantidad =  $ofertamercancia->cantidad - ($materiaprima->cantidadnecesaria * $ofertaproducto->cantidad);
            $ofertamercancia->save();
        }
        return redirect()->route('ofertas.edit', $oferta)->with('success','Producto modificado!!!.');


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ofertaproducto  $ofertaproducto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ofertaproducto $ofertaproducto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ofertaproducto  $ofertaproducto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ofertaproducto_id=$request->input('id');
        $ofertaproducto = Ofertaproducto::find($ofertaproducto_id);
        $oferta = Oferta::find($ofertaproducto->oferta_id);


        foreach ($ofertaproducto->tproducto->materiaprimas as $key => $materiaprima) {
            $ofertamercancia = Ofertamercancia::where('oferta_id', $oferta->id)->where('mercancia_id', $materiaprima->mercancia_id)->first();
            $ofertamercancia->cantidad =  $ofertamercancia->cantidad + ($materiaprima->cantidadnecesaria * $ofertaproducto->cantidad);
            $ofertamercancia->save();
        }
        $ofertaproducto->delete();
        return redirect()->route('ofertas.edit',$oferta)->with('success','Producto eliminado');
    }
}
