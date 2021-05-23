<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use App\Models\Proveedorcuenta;
use Illuminate\Http\Request;

class ProveedorcuentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:gestion_proveedor', ['only' => ['store','editar','destroy']]);
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
        $cuenta = Proveedorcuenta::create($request->all());
        $proveedor = Proveedor::find($cuenta->proveedor_id);

        return redirect()->route('proveedors.edit',$proveedor)->with('success','Cuenta insertada');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proveedorcuenta  $proveedorcuenta
     * @return \Illuminate\Http\Response
     */
    public function show(Proveedorcuenta $proveedorcuenta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Proveedorcuenta  $proveedorcuenta
     * @return \Illuminate\Http\Response
     */
    public function edit(Proveedorcuenta $proveedorcuenta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Proveedorcuenta  $proveedorcuenta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proveedorcuenta $proveedorcuenta)
    {
        //
    }

    public function editar(Request $request)
    {
        $cuenta = Proveedorcuenta::find($request->id);
        $cuenta->update($request->all());
        $proveedor = Proveedor::find($cuenta->proveedor_id);
        return redirect()->route('proveedors.edit', $proveedor)->with('success','Cuenta modificada!!!.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proveedorcuenta  $proveedorcuenta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $cuenta_id=$request->input('id');
        $cuenta = Proveedorcuenta::find($cuenta_id);
        $proveedor = Proveedor::find($cuenta->proveedor_id);
        $cuenta->delete();

        return redirect()->route('proveedors.edit', $proveedor)->with('success','Cuenta eliminada!!!.');
    }
}
