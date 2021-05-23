<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\Almacenmercancia;
use App\Models\Clasificacion;
use App\Models\Ficuenta;
use App\Models\Fiinfracuenta;
use App\Models\Fisubcuenta;
use App\Models\Mercancia;
use App\Models\Producto;
use Exception;
use Illuminate\Http\Request;

class MercanciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:gestion_mercancia', ['only' => ['index','create','store','show','edit','update','destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $listamercancias = Mercancia::all();
        $title = "Listado de productos";
        $clasificaciones = Clasificacion::all();
        $cuentas = Ficuenta::all();
        // $subcuentas = Fisubcuenta::all();
        // $analisis = Fiinfracuenta::all();
        return view('mercancias.index',compact('listamercancias','title','clasificaciones','cuentas'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $almacenes = Almacen::all();
        $clasificaciones = Clasificacion::all();
        $title = "Creando mercancias";
        return view('mercancias.create')->with('almacenes',$almacenes)->with('clasificaciones',$clasificaciones)->with('title',$title);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $request->validate([
                'clasificacion_id' => 'required',
                'codigo' => 'required',
                'nombremercancia' => 'required',
                'um' => 'required'
            ]);
            $mercancia = Mercancia::create($request->all());
            $almacenes = Almacen::all();
            foreach ($almacenes as $almacen) {
                Almacenmercancia::create([
                    "almacen_id"=>$almacen->id,
                    "mercancia_id"=>$mercancia->id,
                    "cantidad"=>0,
                    "precio"=>0
                ]);
            }
            return redirect()->route('mercancias.index')
                            ->with('success','Mercancía insertada');
        } catch (Exception $th) {
            return redirect()->route('mercancias.index')
                            ->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show(Mercancia $mercancia)
    {
        $title = "Detalles de mercancía";
        return view('mercancias.show',compact('mercancia','title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit(Mercancia $mercancia)
    {
        $almacenes = Almacen::all();
        $clasificaciones = Clasificacion::all();
        $cuentas = Ficuenta::all();
        $title = "Editando mercancía";
        return view('mercancias.edit',compact('almacenes','clasificaciones','mercancia','title','cuentas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mercancia $mercancia)
    {
        try {
            $request->validate([
                'clasificacion_id' => 'required',
                'codigo' => 'required',
                'nombremercancia' => 'required',
                'descripcion',
                'um' => 'required'
            ]);

            $mercancia->update($request->all());

            return redirect()->route('mercancias.index')
                            ->with('success','Mercancía modificada');
        } catch (Exception $th) {
            return redirect()->route('mercancias.index')
                            ->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $mercancia_id=$request->input('id');
            $mercancia = Mercancia::find($mercancia_id);
            $mercancia->delete();

            return redirect()->route('mercancias.index')
                            ->with('success','Mercancía eliminada');
        } catch (Exception $th) {
            return redirect()->route('mercancias.index')
                            ->with('error', $th->getMessage());
        }
    }
}
