<?php

namespace App\Http\Controllers;

use App\Models\Facturaelemento;
use App\Models\Factura;
use Illuminate\Http\Request;

class FacturaelementoController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:gestion_facturas', ['only' => ['store','editar','eliminar']]);
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
        $elemento = Facturaelemento::create($request->all());
        $factura = Factura::find($elemento->factura_id);

        return redirect()->route('facturas.edit',$factura)->with('success','Elemento insertado!!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Facturaelemento  $facturaelemento
     * @return \Illuminate\Http\Response
     */
    public function show(Facturaelemento $facturaelemento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Facturaelemento  $facturaelemento
     * @return \Illuminate\Http\Response
     */
    public function edit(Facturaelemento $facturaelemento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Facturaelemento  $facturaelemento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Facturaelemento $facturaelemento)
    {
        //
    }

    public function editar(Request $request)
    {
        $elemento = Facturaelemento::find($request->id);
        $elemento->update($request->all());
        $factura = Factura::find($elemento->factura_id);
        return redirect()->route('facturas.edit', $factura)->with('success','elemento modificado!!!.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Solicitudproducto  $solicitudproducto
     * @return \Illuminate\Http\Response
     */
    public function eliminar(Request $request)
    {
        $elemento = Facturaelemento::find($request->id);
        $factura = Factura::find($elemento->factura_id);
        $elemento->delete();

        return redirect()->route('facturas.edit', $factura)->with('success','Elemento eliminado!!!.');
    }
}
