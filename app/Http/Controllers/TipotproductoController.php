<?php

namespace App\Http\Controllers;

use App\Models\Tipotproducto;
use Illuminate\Http\Request;

class TipotproductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:gestion_clasificadores', ['only' => ['index','store','edit','update','destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Tipos de productos";
        $tiposproductos = Tipotproducto::all();
        return view('tipotproductos.index', compact('tiposproductos','title'));
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
        Tipotproducto::create($request->all());

        return redirect()->route('tipotproductos.index')
                        ->with('success','Tipo producto insertado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tipotproducto  $tipotproducto
     * @return \Illuminate\Http\Response
     */
    public function show(Tipotproducto $tipotproducto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tipotproducto  $tipotproducto
     * @return \Illuminate\Http\Response
     */
    public function edit(Tipotproducto $tipotproducto)
    {
        $title = "Editando el tipo de producto";
        return view('tipotproductos.edit',compact('tipotproducto','title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tipotproducto  $tipotproducto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tipotproducto $tipotproducto)
    {
        $tipotproducto->update($request->all());

        return redirect()->route('tipotproductos.index')
                        ->with('success','Tipo producto modificado!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tipotproducto  $tipotproducto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $tipo_id=$request->input('id');
        $tipo = Tipotproducto::find($tipo_id);
        $tipo->delete();

        return redirect()->route('tipotproductos.index')
                        ->with('success','Tipo producto eliminado!!');
    }
}
