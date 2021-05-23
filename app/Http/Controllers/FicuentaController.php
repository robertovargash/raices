<?php

namespace App\Http\Controllers;

use App\Models\Clasificadorcuenta;
use App\Models\Ficuenta;
use Illuminate\Http\Request;

class FicuentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:gestion_cuentas', ['only' => ['index','store','edit','update','destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cuentas = Ficuenta::all();
        $clasificadores = Clasificadorcuenta::all();
        $title = "Listado de cuentas";
        return view('ficuentas.index',compact('cuentas','title','clasificadores'));
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
        Ficuenta::create($request->all());

        return redirect()->route('ficuentas.index')->with('success','Cuenta insertada');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ficuenta  $ficuenta
     * @return \Illuminate\Http\Response
     */
    public function show(Ficuenta $ficuenta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ficuenta  $ficuenta
     * @return \Illuminate\Http\Response
     */
    public function edit(Ficuenta $ficuenta)
    {
        $title = "Editando de cuenta";
        $clasificadores = Clasificadorcuenta::all();
        return view('ficuentas.edit',compact('ficuenta','title','clasificadores'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ficuenta  $ficuenta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ficuenta $ficuenta)
    {
        $ficuenta->update($request->all());

        return redirect()->route('ficuentas.index')
                        ->with('success','Cuenta modificada.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ficuenta  $ficuenta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ficuenta_id=$request->input('id');
        $ficuenta = Ficuenta::find($ficuenta_id);
        $ficuenta->delete();

        return redirect()->route('ficuentas.index')
                        ->with('success','Cuenta eliminada');
    }
}
