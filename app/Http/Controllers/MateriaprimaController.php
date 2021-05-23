<?php

namespace App\Http\Controllers;

use App\Models\Materiaprima;
use App\Models\Tproducto;
use Illuminate\Http\Request;

class MateriaprimaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:gestion_producto', ['only' => ['store','editar','destroy']]);
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
        // dd($request);
        $materiaprima = Materiaprima::create($request->all());
        $tproducto = Tproducto::findorFail($materiaprima->tproducto_id);
        return redirect()->route('tproductos.edit',$tproducto)->with('success','Elemento insertado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Materiaprima  $materiaprima
     * @return \Illuminate\Http\Response
     */
    public function show(Materiaprima $materiaprima)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Materiaprima  $materiaprima
     * @return \Illuminate\Http\Response
     */
    public function edit(Materiaprima $materiaprima)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Materiaprima  $materiaprima
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Materiaprima $materiaprima)
    {
        //
    }

    public function editar(Request $request)
    {
        $materiaprima = Materiaprima::find($request->id);

        $materiaprima->update($request->all());
        $tproducto = Tproducto::findorFail($materiaprima->tproducto_id);
        return redirect()->route('tproductos.edit',$tproducto)->with('success','Elemento modificado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Materiaprima  $materiaprima
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $materiaprima_id=$request->input('id');
        $materiaprima = Materiaprima::find($materiaprima_id);
        $tproducto = Tproducto::find($materiaprima->tproducto_id);
        $materiaprima->delete();

        return redirect()->route('tproductos.edit',$tproducto)->with('success','Elemento eliminado');
    }
}
