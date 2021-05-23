<?php

namespace App\Http\Controllers;

use App\Models\Fiinfracuenta;
use App\Models\Fisubcuenta;
use Illuminate\Http\Request;

class FiinfracuentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:gestion_cuentas', ['only' => ['store','destroy','eliminar','get_by_subcuenta']]);
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
        $fiinfracuenta = Fiinfracuenta::create($request->all());

        return redirect()->route('fisubcuentas.edit',$fiinfracuenta->fisubcuenta)->with('success','Análisis insertado');;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fiinfracuenta  $fiinfracuenta
     * @return \Illuminate\Http\Response
     */
    public function show(Fiinfracuenta $fiinfracuenta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fiinfracuenta  $fiinfracuenta
     * @return \Illuminate\Http\Response
     */
    public function edit(Fiinfracuenta $fiinfracuenta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fiinfracuenta  $fiinfracuenta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fiinfracuenta $fiinfracuenta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fiinfracuenta  $fiinfracuenta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $fiinfracuenta_id=$request->input('id');
        $fiinfracuenta = Fiinfracuenta::find($fiinfracuenta_id);
        $fisubcuenta = $fiinfracuenta->fisubcuenta;
        $fiinfracuenta->delete();

        return redirect()->route('fisubcuentas.edit',$fisubcuenta)
                        ->with('success','Análisis eliminado');
    }

    public function eliminar(Request $request)
    {
        $fiinfracuenta_id=$request->input('id');
        $fiinfracuenta = Fiinfracuenta::find($fiinfracuenta_id);
        $fisubcuenta = Fisubcuenta::find($fiinfracuenta->fisubcuenta_id);
        $fiinfracuenta->delete();

        return redirect()->route('fisubcuentas.edit',$fisubcuenta)
                         ->with('success','Análisis eliminado');
    }

    public function get_by_subcuenta(Request $request){

        $data = Fiinfracuenta::where('fiinfracuentas.fisubcuenta_id','=',$request->fisubcuenta_id)->get();
        return response()->json($data, 200);
    }
}
