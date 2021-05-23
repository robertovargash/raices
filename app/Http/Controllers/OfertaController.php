<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\Oferta;
use App\Models\Ofertamercancia;
use App\Models\Ofertaproducto;
use App\Models\Mercancia;
use App\Models\Almacenmercancia;
use App\Models\Tproducto;
use Illuminate\Http\Request;

class OfertaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:gestion_oferta', ['only' => ['index','store','edit','update','recalcular']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ofertas = Oferta::all();

        $title = "Listado de ofertas";
        return view('ofertas.index',compact('ofertas','title'));
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
        $ofertas = Oferta::all();
        foreach ($ofertas as $key => $oferta) {
            if ($oferta->estado == 1) {
                $oferta->estado = 0;
                foreach ($oferta->ofertamercancias as $key => $mercancia) {
                    $mercancia->delete();
                }
                foreach ($oferta->ofertaproductos as $key => $producto) {
                    $producto->delete();
                }
                $oferta->save();
            }
        }
        $oferta = Oferta::create($request->all());
        $mercancias = Mercancia::all();
        //Si creo una oferta, debo ponerle sus mercancias contra las mercancias existentes en el codificador,
        //lo que en cantidad 0
        foreach ($mercancias as $mercancia) {
            Ofertamercancia::create([
                "oferta_id"=>$oferta->id,
                "mercancia_id"=>$mercancia->id,
                "cantidad"=>0
            ]);
        }

        $almacenes = Almacen::all();
        foreach ($almacenes as $key => $almacen) {//por cada almacen que exista
            foreach ($almacen->almacenmercancias as $key => $almacenmercancia) {//por cada mercancia que tenga ese almacen
                foreach ($almacenmercancia->mercancia->ofertamercancias as $key => $ofertamercancia) {
                    // dd($ofertamercancia);
                    if ($ofertamercancia->oferta_id === $oferta->id) {//Sumo las cantidades
                        //O sea, si hay una mercancia X en almacen 1 y la mercancia X en almacen 2, se suman ambar cantidades.
                        $ofertamercancia->cantidad = $ofertamercancia->cantidad + $almacenmercancia->cantidad;
                        $ofertamercancia->save();
                    }
                }
            }
        }

        return redirect()->route('ofertas.edit',$oferta)->with('success','Oferta creada');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Oferta  $oferta
     * @return \Illuminate\Http\Response
     */
    public function show(Oferta $oferta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Oferta  $oferta
     * @return \Illuminate\Http\Response
     */
    public function edit(Oferta $oferta)
    {
        if ($oferta->estado == 1) {//Si la oferta esta abierta...
            $title = "Editando oferta";
            $tproductos_id = Ofertaproducto::select('tproducto_id')->where('ofertaproductos.oferta_id','=',$oferta->id)->get();
            //Se buscan los productos del codificador producto
            $tproductos = Tproducto::all();
            $productos = Tproducto::all();
            //aqui se buscan los productos que esten en 'productos' pero no en la Oferta, con diff
            // $tproductos = $tproductos->diff(Tproducto::whereIn('id', $tproductos_id)->get());

            foreach ($tproductos as $tproducto) {
                $hayDisp = true;
                foreach ($tproducto->materiaprimas as $materiaprima) {
                    $ofertamercancia = Ofertamercancia::where('ofertamercancias.oferta_id','=',$oferta->id)->where('ofertamercancias.mercancia_id','=',$materiaprima->mercancia_id)->first();
                    if ($ofertamercancia->cantidad < $materiaprima->cantidadnecesaria) {
                        $tproducto->disponiblemprima = 0;
                        //Si la existencia es menor a la cantidad necesaria, no esta disponible
                        $hayDisp = false;
                        break;
                    }
                }
                if ($hayDisp) {
                    $tproducto->disponiblemprima = 1;
                    $mprim = $tproducto->materiaprimas->first();
                    if ($mprim) {
                        $oferta_merc = Ofertamercancia::where('ofertamercancias.oferta_id','=',$oferta->id)->where('ofertamercancias.mercancia_id','=',$mprim->mercancia_id)->first();
                        $cantidadd = $oferta_merc->cantidad/$mprim->cantidadnecesaria;
                        foreach ($tproducto->materiaprimas as $materiaprima) {
                            $ofertamercancia = Ofertamercancia::where('ofertamercancias.oferta_id','=',$oferta->id)->where('ofertamercancias.mercancia_id','=',$materiaprima->mercancia_id)->first();
                            $tcantidad = $ofertamercancia->cantidad/$materiaprima->cantidadnecesaria;
                            //Esta condicion es para que coja la cantidad minima segun la disponibilidad de
                            //materias primas
                            if ($tcantidad < $cantidadd) {
                                $cantidadd = $tcantidad;
                            }
                        }
                        //esto es para truncar y quitar el decimal, es la funcion "bcdiv"
                        //creo el atributo temporal "cantidadd" para que aparezca solo en la vista
                        if (Ofertaproducto::where('ofertaproductos.oferta_id','=',$oferta->id)->where('ofertaproductos.tproducto_id','=',$tproducto->id)->count() > 0) {
                            $oferprod = Ofertaproducto::where('ofertaproductos.oferta_id','=',$oferta->id)->where('ofertaproductos.tproducto_id','=',$tproducto->id)->first();
                            $tproducto->existe = 1;
                            $tproducto->cantidadd = bcdiv($cantidadd + $oferprod->cantidad, '1', 0);
                        }else{
                            $tproducto->existe = 0;
                            $tproducto->cantidadd = bcdiv($cantidadd, '1', 0);
                        }

                    }
                }else{
                    //creo el atributo temporal "cantidadd" para que aparezca solo en la vista
                    $tproducto->cantidadd = 0;
                }
            }
            return view('ofertas.edit',compact('oferta','title','tproductos','productos'));
        }else{
            return redirect()->route('ofertas.index')->with('error','La oferta esta cerrada');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Oferta  $oferta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Oferta $oferta)
    {
        $oferta->update($request->all());

        return redirect()->route('ofertas.index')
                        ->with('success','Oferta modificada.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Oferta  $oferta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Oferta $oferta)
    {
        //
    }

    public function recalcular(Oferta $oferta){
        $ofertamercancias = Ofertamercancia::where('ofertamercancias.oferta_id','=',$oferta->id)->get();
        // dd($oferta->id);
        foreach ($ofertamercancias as $key => $ofertamercancia) {
            $almacenes = Almacen::all();
            $ofertamercancia->cantidad = 0;
            foreach ($almacenes as $key => $almacen) {//por cada almacen que exista
                // dd($almacen->almacenmercancias);
                foreach ($almacen->almacenmercancias as $key => $almacenmercancia) {//por cada mercancia que tenga ese almacen
                    if ($ofertamercancia->mercancia_id == $almacenmercancia->mercancia_id) {
                        $ofertamercancia->cantidad = $ofertamercancia->cantidad + $almacenmercancia->cantidad;
                    }
                }
            }
            foreach ($oferta->ofertaproductos as $key => $ofertaproducto) {
                foreach ($ofertaproducto->tproducto->materiaprimas as $key => $materiaprima) {
                    if ($materiaprima->mercancia_id == $ofertamercancia->mercancia_id) {
                        $ofertamercancia->cantidad = $ofertamercancia->cantidad - ($materiaprima->cantidadnecesaria * $ofertaproducto->cantidad);

                    }
                }
            }
            $ofertamercancia->save();
        }

        return redirect()->route('ofertas.index')
                        ->with('success','Oferta recalculada.');
    }
}
