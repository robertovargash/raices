<?php

namespace App\Http\Controllers;

use App\Models\Valeitem;
use App\Models\Almacenmercancia;
use App\Models\Vale;
use App\Models\Almacen;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;

class ValeitemController extends Controller
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
        $this->middleware('permission:gestion_vale', ['only' => ['store','editar','destroy']]);
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
        $valeitem = Valeitem::create($request->all());
        $vale = Vale::find($valeitem->vale_id);
        $talmacenmercancia = Almacenmercancia::where('almacenmercancias.almacen_id','=',$vale->almacen_id)->where('almacenmercancias.mercancia_id','=',$valeitem->mercancia_id)->first();
        $almacenmercancia = Almacenmercancia::find($talmacenmercancia->id);
        $almacenmercancia->cantidad = $almacenmercancia->cantidad - $valeitem->cantidad;
        $almacenmercancia->save();

        // return redirect()->route('vales.edit',$vale)->with('success','Elemento insertado');

        $url = URL::route('vales.edit',$vale) . '#cardMercancias';
        return Redirect::to($url)->with('success','Mercancía insertada!!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Valeitem  $valeItem
     * @return \Illuminate\Http\Response
     */
    public function show(Valeitem $valeitem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Valeitem  $valeItem
     * @return \Illuminate\Http\Response
     */
    public function edit(Valeitem $valeitem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Valeitem  $valeItem
     * @return \Illuminate\Http\Response
     */
    public function editar(Request $request)
    {
        $valeitem = Valeitem::find($request->id);
        $vale = Vale::find($valeitem->vale_id);
        //primero devuelvo
        $almacenmercancia = Almacenmercancia::where('almacenmercancias.almacen_id','=',$vale->almacen_id)->where('almacenmercancias.mercancia_id','=',$valeitem->mercancia_id)->first();
        $almacenmercancia->cantidad = $almacenmercancia->cantidad + $valeitem->cantidad;
        $almacenmercancia->save();
        $valeitem->update($request->all());
        $almacenmercancia = Almacenmercancia::where('almacenmercancias.almacen_id','=',$vale->almacen_id)->where('almacenmercancias.mercancia_id','=',$valeitem->mercancia_id)->first();
        $almacenmercancia->cantidad = $almacenmercancia->cantidad - $valeitem->cantidad;
        $almacenmercancia->save();
        // return redirect()->route('vales.edit', $vale)->with('success','Producto modificado!!!.');
        $url = URL::route('vales.edit',$vale) . '#cardMercancias';
        return Redirect::to($url)->with('success','Mercancía modificada!!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Valeitem  $valeItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $valeitem_id=$request->input('id');
        $valeitem = Valeitem::find($valeitem_id);
        //Si elimino del vale, devuelvo la cantidad tomada.
        $talmacenmercancia = Almacenmercancia::where('almacenmercancias.mercancia_id','=',$valeitem->mercancia_id)->first();
        $almacenmercancia = Almacenmercancia::find($talmacenmercancia->id);
        $almacenmercancia->cantidad = $almacenmercancia->cantidad + $valeitem->cantidad;
        $almacenmercancia->save();

        $vale = Vale::find($valeitem->vale_id);
        $valeitem->delete();

        // return redirect()->route('vales.edit',$vale)->with('success','Elemento eliminado');
        $url = URL::route('vales.edit',$vale) . '#cardMercancias';
        return Redirect::to($url)->with('success','Mercancía eliminada!!!');
    }
}
