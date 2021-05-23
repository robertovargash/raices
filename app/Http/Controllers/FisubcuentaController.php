<?php

namespace App\Http\Controllers;

use App\Models\Fianalisis;
use App\Models\Fisubcuenta;
use App\Models\Ficuenta;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;

class FisubcuentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:gestion_cuentas', ['only' => ['store','edit','update','destroy','get_by_cuenta']]);
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
        $subcuenta = Fisubcuenta::create($request->all());

        return redirect()->route('ficuentas.edit',$subcuenta->ficuenta)->with('success','Subcuenta insertada.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fisubcuenta  $fisubcuenta
     * @return \Illuminate\Http\Response
     */
    public function show(Fisubcuenta $fisubcuenta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fisubcuenta  $fisubcuenta
     * @return \Illuminate\Http\Response
     */
    public function edit(Fisubcuenta $fisubcuenta)
    {
        $title = "Editando de cuenta";
        return view('fisubcuentas.edit',compact('fisubcuenta','title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fisubcuenta  $fisubcuenta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fisubcuenta $fisubcuenta)
    {
        $fisubcuenta->update($request->all());
        $ficuenta = $fisubcuenta->ficuenta;
        return redirect()->route('ficuentas.edit', $ficuenta)
                        ->with('success','Subcuenta modificada.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fisubcuenta  $fisubcuenta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $fisubcuenta_id=$request->input('id');
        $fisubcuenta = Fisubcuenta::find($fisubcuenta_id);
        $ficuenta = Ficuenta::find($fisubcuenta->ficuenta_id);
        $fisubcuenta->delete();

        return redirect()->route('ficuentas.edit',$ficuenta)
                        ->with('success','Subcuenta eliminada');
    }

    public function get_by_cuenta(Request $request){

        $data = Fisubcuenta::where('fisubcuentas.ficuenta_id','=',$request->ficuenta_id)->get();
        return response()->json($data, 200);
    }
}
