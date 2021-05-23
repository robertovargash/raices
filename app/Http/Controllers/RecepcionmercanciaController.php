<?php

namespace App\Http\Controllers;

use App\Models\Almacenmercancia;
use App\Models\Mercancia;
use App\Models\Producto;
use App\Models\Recepcion;
use App\Models\Recepcionmercancia;
use Illuminate\Http\Request;

class RecepcionmercanciaController extends Controller
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
        $this->middleware('permission:gestion_recepcion', ['only' => ['store','update','destroy']]);
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
        $recepmercancia = Recepcionmercancia::create($request->all());
        $recepcion = Recepcion::find($recepmercancia->recepcion_id);
        return redirect()->route('recepcions.edit',$recepcion)->with('success','Elemento insertado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recepcionproducto  $recepcionproducto
     * @return \Illuminate\Http\Response
     */
    public function show(Recepcionmercancia $recepcionmercancia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Recepcionproducto  $recepcionproducto
     * @return \Illuminate\Http\Response
     */
    public function edit(Recepcionmercancia $recepcionproducto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Recepcionproducto  $recepcionproducto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $recepcionmercancia = Recepcionmercancia::find($request->id);
        $recepcionmercancia->cantidad = $request->cantidad;
        $recepcionmercancia->precio = $request->precio;
        $recepcionmercancia->save();

        return redirect()->route('recepcions.edit',$recepcionmercancia->recepcion)->with('success','Elemento modificado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recepcionproducto  $recepcionproducto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $recepcionproducto_id=$request->input('id');
        $recepmercancia = Recepcionmercancia::find($recepcionproducto_id);
        $recepcion = Recepcion::find($recepmercancia->recepcion_id);
        $recepmercancia->delete();

        return redirect()->route('recepcions.edit',$recepcion)->with('success','Elemento eliminado.');
    }
}
