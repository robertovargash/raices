<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\Vale;
use App\Models\Almacenmercancia;
use App\Models\Mercancia;
use App\Models\Ordentrabajo;
use App\Models\Producto;
use App\Models\Recepcion;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class AlmacenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:gestion_almacen', ['only' => ['index','store','edit','show','update']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $almacenes = Almacen::all();

        $title = "Listado de almacenes";
        return view('almacens.index',compact('almacenes','title'));
        // $pdf = PDF::loadView('almacens.index',compact('almacenes'));
        // return $pdf->download('pruebapdf.pdf');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $title = "Creando almacén";
        // return view('almacens.create',compact('title'));
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
            'almacen' => 'required',
            'descripcion',
        ]);

        $almacen = Almacen::create($request->all());
        $mercancias = Mercancia::all();
        //Si creo un almacen, debo ponerle sus mercancias contra las mercancias existentes en el codificador,
        //lo que en cantidad 0
        foreach ($mercancias as $mercancia) {
            Almacenmercancia::create([
                "almacen_id"=>$almacen->id,
                "mercancia_id"=>$mercancia->id,
                "cantidad"=>0,
                "precio"=>0
            ]);
        }

        return redirect()->route('almacens.index')->with('success','Almacén insertado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Almacen  $almacen
     * @return \Illuminate\Http\Response
     */
    public function show(Almacen $almacen)
    {
        $title = "Detalles de almacén";
        return view('almacens.show',compact('almacen','title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Almacen  $almacen
     * @return \Illuminate\Http\Response
     */
    public function edit(Almacen $almacen)
    {
        $title = "Editando almacén";
        //las ordenes de trabajo q esten en proceso
        //Pues las confirma los vales
        $ordentrabajos = Ordentrabajo::where('ordentrabajos.estado',0)->get();
        return view('almacens.edit',compact('almacen','title','ordentrabajos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Almacen  $almacen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Almacen $almacen)
    {
        $request->validate([
            'almacen' => 'required',
            'descripcion' => 'required',
        ]);

        $almacen->update($request->all());

        return redirect()->route('almacens.index')
                        ->with('success','Almacén modificado.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Almacen  $almacen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // $almacen_id=$request->input('id');
        // $almacen = Almacen::find($almacen_id);
        // $almacen->delete();

        // return redirect()->route('almacens.index')
        //                 ->with('success','Almacén eliminado');
    }
}
