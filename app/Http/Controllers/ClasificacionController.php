<?php

namespace App\Http\Controllers;

use App\Models\Clasificacion;
use App\Models\Mercancia;
use App\Models\Producto;
use Illuminate\Http\Request;

class ClasificacionController extends Controller
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
        $clasificaciones = Clasificacion::all();
        //$clasificaciones  = Clasificacion::get();

        $title = "Listado de clasificaciones";
        return view('clasificacions.index', compact('clasificaciones','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Creando clasificaciones";
        return view('clasificacions.create',compact('title'));
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
            'clasificacion' => 'required',
            'detalle',
        ]);

        Clasificacion::create($request->all());

        return redirect()->route('clasificacions.index')
                        ->with('success','Clasificación insertada');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Clasificacion  $clasificacion
     * @return \Illuminate\Http\Response
     */
    public function show(Clasificacion $clasificacion)
    {
        $title = "Detalles de clasificación";
        return view('clasificacions.show',compact('clasificacion','title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Clasificacion  $clasificacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Clasificacion $clasificacion)
    {
        $title = "Editando clasificación";
        return view('clasificacions.edit',compact('clasificacion','title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Clasificacion  $clasificacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Clasificacion $clasificacion)
    {
        $request->validate([
            'clasificacion' => 'required',
            'detalle'
        ]);

        $clasificacion->update($request->all());

        return redirect()->route('clasificacions.index')
                        ->with('success','Clasificación modificada.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Clasificacion  $clasificacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $clasificacion_id=$request->input('id');
        $clasificacion = Clasificacion::find($clasificacion_id);
        $clasificacion->delete();

        return redirect()->route('clasificacions.index')
                        ->with('success','Clasificación eliminada');
    }
}
