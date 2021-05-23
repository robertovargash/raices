<?php

namespace App\Http\Controllers;

use App\Models\Cuentasbancariascliente;

use App\Models\Cliente;
use Illuminate\Http\Request;

class CuentasbancariasclienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:gestion_cliente', ['only' => ['store','editar','destroy']]);
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
        $cuenta = Cuentasbancariascliente::create($request->all());
        $cliente = Cliente::find($cuenta->cliente_id);

        return redirect()->route('clientes.edit',$cliente)->with('success','Cuenta insertada');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cuentasbancariascliente  $cuentasbancariascliente
     * @return \Illuminate\Http\Response
     */
    public function show(Cuentasbancariascliente $cuentasbancariascliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cuentasbancariascliente  $cuentasbancariascliente
     * @return \Illuminate\Http\Response
     */
    public function edit(Cuentasbancariascliente $cuentasbancariascliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cuentasbancariascliente  $cuentasbancariascliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cuentasbancariascliente $cuentasbancariascliente)
    {
        //
    }

    public function editar(Request $request)
    {
        $cuenta = Cuentasbancariascliente::find($request->id);
        $cuenta->update($request->all());
        $cliente = Cliente::find($cuenta->cliente_id);
        return redirect()->route('clientes.edit', $cliente)->with('success','Cuenta modificada!!!.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cuentasbancariascliente  $cuentasbancariascliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $cuenta_id=$request->input('id');
        $cuenta = Cuentasbancariascliente::find($cuenta_id);
        $cliente = cliente::find($cuenta->cliente_id);
        $cuenta->delete();

        return redirect()->route('clientes.edit', $cliente)->with('success','Cuenta eliminada!!!.');
    }
}
