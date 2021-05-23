<?php

namespace App\Http\Controllers;

use App\Models\Ordentrabajo;
use App\Models\Otsolicitude;
use App\Models\Solicitude;
use Illuminate\Http\Request;

class OtsolicitudeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:gestion_ot', ['only' => ['terminar']]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Otsolicitude  $otsolicitude
     * @return \Illuminate\Http\Response
     */
    public function show(Otsolicitude $otsolicitude)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Otsolicitude  $otsolicitude
     * @return \Illuminate\Http\Response
     */
    public function edit(Otsolicitude $otsolicitude)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Otsolicitude  $otsolicitude
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Otsolicitude $otsolicitude)
    {
        //
    }

    public function terminar(Request $request)
    {
        $otsolicitude = Otsolicitude::find($request->id);

        $solicitude = Solicitude::find($otsolicitude->solicitude_id);
        // dd($otsolicitude);
        if ($otsolicitude->terminado == 0) {
            $otsolicitude->terminado = 1;
            foreach ($solicitude->solicitudproductos as $key => $solicitudproducto) {
                if ($solicitudproducto->tproducto_id == $otsolicitude->ordentrabajo->tproducto_id) {
                    $solicitudproducto->terminado = 1;
                    $solicitudproducto->save();
                }
            }
            $finished = true;
            foreach ($solicitude->solicitudproductos as $key => $solicitudproducto) {
                if ($solicitudproducto->terminado != 1) {
                    $finished = false;
                }
            }
            if ($finished) {
                $solicitude->estado = 2;//Marco la solicitud como terminada
                $solicitude->save();
            }
            $otsolicitude->save();
            $ordentrabajo = Ordentrabajo::find($otsolicitude->ordentrabajo_id);
            $finishedot = true;
            foreach ($ordentrabajo->otsolicitudes as $key => $temp_otsolicitude) {
                if ($temp_otsolicitude->terminado != 1) {
                    $finishedot = false;
                }
            }
            if ($finishedot) {
                $ordentrabajo->estado = 2;//Marco la OT como terminada
                $ordentrabajo->save();
                return redirect()->route('ordentrabajos.index')->with('success','Producto de la(s) solicitud(es) marcado(s) como terminado(s).');
            }
            return redirect()->route('ordentrabajos.edit',$otsolicitude->ordentrabajo)->with('success','Producto de la(s) solicitud(es) marcado(s) como terminado(s).');
        }else{
            return redirect()->route('ordentrabajos.edit',$otsolicitude->ordentrabajo)->with('error','Ya está terminado');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Otsolicitude  $otsolicitude
     * @return \Illuminate\Http\Response
     */
    public function destroy(Otsolicitude $otsolicitude)
    {
        //
    }
}
