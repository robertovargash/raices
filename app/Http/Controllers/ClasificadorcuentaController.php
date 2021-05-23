<?php

namespace App\Http\Controllers;

use App\Models\Clasificadorcuenta;
use Illuminate\Http\Request;

class ClasificadorcuentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:gestion_clasificadores', ['only' => ['index','store','create','edit','update','show','destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clasificaciones = Clasificadorcuenta::all();
        //$clasificaciones  = Clasificacion::get();

        $title = "Listado de clasificadores";
        return view('clasificadorcuentas.index', compact('clasificaciones','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Creando clasificador";
        return view('clasificadorcuentas.create',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'clasificacion' => 'required'
        ],[
            'clasificacion.required' => 'Inserte clasificación'
        ]);

        Clasificadorcuenta::create($request->all());

        return redirect()->route('clasificadorcuentas.index')
                        ->with('success','Clasificador insertado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Clasificadorcuenta  $clasificadorcuenta
     * @return \Illuminate\Http\Response
     */
    public function show(Clasificadorcuenta $clasificadorcuenta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Clasificadorcuenta  $clasificadorcuenta
     * @return \Illuminate\Http\Response
     */
    public function edit(Clasificadorcuenta $clasificadorcuenta)
    {
        $title = "Editando el clasificador";
        return view('clasificadorcuentas.edit',compact('clasificadorcuenta','title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Clasificadorcuenta  $clasificadorcuenta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Clasificadorcuenta $clasificadorcuenta)
    {
        $request->validate([
            'clasificacion' => 'required',
        ],[
            'clasificacion.required' => 'Inserte el clasificador',
        ]);

        $clasificadorcuenta->update($request->all());

        return redirect()->route('clasificadorcuentas.index')
                        ->with('success','clasificador modificado!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Clasificadorcuenta  $clasificadorcuenta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $clasificacion_id=$request->input('id');
        $clasificacion = Clasificadorcuenta::find($clasificacion_id);
        $clasificacion->delete();

        return redirect()->route('clasificadorcuentas.index')
                        ->with('success','Clasificador eliminado!!');
    }
}
