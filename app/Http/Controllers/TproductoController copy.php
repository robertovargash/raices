<?php

namespace App\Http\Controllers;

use App\Models\Materiaprima;
use App\Models\Tproducto;
use App\Models\Almacenmercancia;
use App\Models\Producto;
use App\Models\Tipotproducto;
use Exception;
use Illuminate\Http\Request;

class TproductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:gestion_productos', ['only' => ['index','store','edit','update','show','destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tproductos = Tproducto::all();
        //aqui valido que exista la cantidad suficiente para cada materia primas necesarias
        //Existencia en almacen debe ser mayor o igual que cantidad necesaria del producto

        foreach ($tproductos as $tproducto) {
            $hayDisp = true;
            foreach ($tproducto->materiaprimas as $materiaprima) {
                $almacenmercancia = Almacenmercancia::where('almacenmercancias.mercancia_id','=',$materiaprima->mercancia_id)->first();
                if ($almacenmercancia->cantidad < $materiaprima->cantidadnecesaria) {
                    $tproducto->disponiblemprima = 0;
                    $hayDisp = false;
                }
            }
            if ($hayDisp) {
                $tproducto->disponiblemprima = 1;
            }
            $tproducto->save();
        }

        $tipotproductos = Tipotproducto::all();
        $title = "Listado de productos";
        return view('tproductos.index',compact('tproductos','tipotproductos','title'));
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
        $tproductonuevo = Tproducto::create($request->all());
        return redirect()->route('tproductos.edit',$tproductonuevo)->with('success','Producto insertado');;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tproducto  $tproducto
     * @return \Illuminate\Http\Response
     */
    public function show(Tproducto $tproducto)
    {
        $materiasprimas = Materiaprima::where('materiaprimas.tproducto_id','=',$tproducto->id)->get();
        $title = "Producto";
        return view('tproductos.show',compact('title','tproducto','materiasprimas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tproducto  $tproducto
     * @return \Illuminate\Http\Response
     */
    public function edit(Tproducto $tproducto)
    {
        // try {
            //se buscan las materias primas que tiene el producto, solo el id de la mercancia
            $tipotproductos = Tipotproducto::all();
            $materiasprimas_ids = Materiaprima::select('mercancia_id')->where('materiaprimas.tproducto_id','=',$tproducto->id)->get();
            // $materiasprimas = Materiaprima::where('materiaprimas.tproducto_id','=',$tproducto->id)->get();
            //filtro solo las mercancias tipo materia prima (id = 4)
            //ademas el wherenotIn descarta las mercancias que ya aparecen en el producto
            $mercancias = Almacenmercancia::join('mercancias','mercancias.id','almacenmercancias.mercancia_id')
            ->where("mercancias.clasificacion_id", "=", 4)->wherenotIn('mercancia_id',$materiasprimas_ids)->select("*")->get();
            $title = "Editando producto";
            $valor = $tproducto->preciomanoobra;
            if ($tproducto->materiaprimas) {
                foreach ($tproducto->materiaprimas as $key => $mat) {
                    $valor = $valor + ($mat->cantidadnecesaria * $mat->mercancia->precio);
                }
            }

            return view('tproductos.edit',compact('title','tproducto','mercancias','tipotproductos','valor'));
        // } catch (Exception $ex) {
        //     return redirect()->route('tproductos.index')
        //                 ->with('error',$ex->getMessage());
        // }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tproducto  $tproducto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tproducto $tproducto)
    {

        $tproducto->update($request->all());

        return redirect()->route('tproductos.index')
                        ->with('success','Producto modificado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tproducto  $tproducto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $producto_id=$request->input('id');
        Tproducto::find($producto_id)->delete();

        return redirect()->route('tproductos.index')
                        ->with('success','Producto eliminado');
    }
}
