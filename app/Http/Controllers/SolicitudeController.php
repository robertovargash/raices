<?php

namespace App\Http\Controllers;

use App\Models\Solicitude;
use App\Models\Solicitudproducto;
use App\Models\Tproducto;
use App\Models\Materiaprima;
use App\Models\Almacenmercancia;
use App\Models\Cliente;
use App\Models\Otsolicitude;
use App\Models\Ordentrabajo;
use App\Models\Oferta;
use App\Models\Ofertaproducto;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SolicitudeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:gestion_solicitud', ['only' => ['index','store','edit','update','show','destroy','cancelar','confirmar','entregar']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $solicitudes = Solicitude::all();
        $clientes = Cliente::all();
        $title = "Solicitudes";
        $tomorrow = Carbon::tomorrow()->format('Y-m-d');
        return view('solicitudes.index', compact('solicitudes','title','clientes','tomorrow'));
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
        $solicitude = Solicitude::create($request->all());
        return redirect()->route('solicitudes.edit',$solicitude)->with('success', 'Solicitud insertada!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Solicitude  $solicitude
     * @return \Illuminate\Http\Response
     */
    public function show(Solicitude $solicitude)
    {
        $solicitudproductos = Solicitudproducto::all();
        $title = "Datos de solicitud";
        $qr = "No. Solicitud : ".$solicitude->id."\nCliente: ".$solicitude->cliente."\nTelefono: ".$solicitude->telefono.
        "\nA entregar: ".date('d/m/Y', strtotime($solicitude->fechasolicitud))."\nDescripcion: ".$solicitude->descripcion;
        $productos = " \nProductos: ";
        // dd($solicitude->solicitudproductos);
        $acobrar = 0;
        foreach ($solicitude->solicitudproductos as $key => $producto) {
            $acobrar += $producto->tproducto->valorbruto * $producto->cantidad;
            $productos .= "\n".$producto->tproducto->nombre. " Cantidad: ". $producto->cantidad;
        }
        $qr .= "\nCosto: $".$acobrar;
        // $qrcobro = "{\"id_transaccion\":9204129971832722, \"importe\":0.01,\"moneda\":\"CUP\"}";
        $qrcobro = "TRANSFERMOVIL_ETECSA,TRANSFERENCIA,9204129971832722,59012830,";
        $qr .= $productos;


        return view('solicitudes.show',compact('title','solicitude','solicitudproductos','qr','qrcobro','acobrar'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Solicitude  $solicitude
     * @return \Illuminate\Http\Response
     */
    public function edit(Solicitude $solicitude)
    {
        if ($solicitude->estado == 0) {
            //se buscan los productos que tenga la recepcion
            $tproductos = Tproducto::join('ofertaproductos','ofertaproductos.tproducto_id','tproductos.id')
                            ->join('ofertas','ofertas.id','ofertaproductos.oferta_id')->where('ofertas.estado',1)->select("tproductos.*","ofertaproductos.cantidad")->get();
            //Valido llevo para la vista la cantidad ofertada, la vista se encarga de validar que no pasen mas
            foreach ($tproductos as $tproducto) {
                if (Solicitudproducto::where('solicitudproductos.solicitude_id','=',$solicitude->id)->where('solicitudproductos.tproducto_id','=',$tproducto->id)->count() > 0) {
                    $sproduct = Solicitudproducto::where('solicitudproductos.solicitude_id','=',$solicitude->id)->where('solicitudproductos.tproducto_id','=',$tproducto->id)->first();
                    $tproducto->existe = 1;
                    $cantidadd = $tproducto->cantidad + $sproduct->cantidad;
                    $tproducto->cantidadd = bcdiv($cantidadd, '1', 0);
                }else{
                    $tproducto->existe = 0;
                    $cantidadd = $tproducto->cantidad;
                    $tproducto->cantidadd = bcdiv($cantidadd, '1', 0);
                }

            }
            $title = "Editando solicitud";
            return view('solicitudes.edit',compact('title','solicitude','tproductos'));
        }else {
            return redirect()->route('solicitudes.index')->with('error','La solicitud no se puede modificar, no está en proceso');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Solicitude  $solicitude
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Solicitude $solicitude)
    {
        $solicitude->update($request->all());
        return redirect()->route('solicitudes.index')->with('success','Solicitud modificada!!.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

    }

    public function cancelar(Request $request)
    {
        $solicitud_id=$request->input('id');
        $solicitude = Solicitude::find($solicitud_id);
        if ($solicitude->estado == 0) {
            $solicitude->estado = 4;

            foreach ($solicitude->solicitudproductos as $solicitudproducto) {
                //si se elimina el producto de la solicitud, se va a la orden y se decrementa la cantidad.
                $otss = Ordentrabajo::where('ordentrabajos.tproducto_id','=',$solicitudproducto->tproducto_id)->get();
                foreach ($otss as $ot) {
                    foreach ($solicitude->otsolicitudes as $otsolicitudei) {
                        if ($otsolicitudei->ordentrabajo_id == $ot->id) {
                            $otsolicitude = $otsolicitudei;
                            if ($otsolicitude) {
                                $ot->cantidad =  $ot->cantidad - $solicitudproducto->cantidad;//descuento de la OT la cantidad q tiene este producto en la solicitud
                                $ot->save();
                                $otsolicitude->delete();//elimino de la OT la solicitud
                            }
                        break;
                        }
                    }
                }

                //Este bloque es para devolver a la oferta la cantidad
                $oferta = Oferta::where('estado',1)->first();
                $ofertaproducto = Ofertaproducto::where('ofertaproductos.oferta_id',$oferta->id)->where('ofertaproductos.tproducto_id',$solicitudproducto->tproducto_id)->first();
                $ofertaproducto->cantidad = $ofertaproducto->cantidad +  $solicitudproducto->cantidad;
                $ofertaproducto->save();
            }
            $solicitude->save();
            return redirect()->route('solicitudes.index')->with('success','Solicitud cancelada');
        }else {
            return redirect()->route('solicitudes.index')->with('error','No se puede cancelar, no esta en proceso');
        }

    }
    public function confirmar(Request $request)
    {
        $solicitud_id=$request->input('id');
        $solicitude = Solicitude::find($solicitud_id);
        if ($solicitude->estado == 0) {
            $solicitude->estado = 1;
            foreach ($solicitude->solicitudproductos as $key => $solicitudproducto) {
                $otss = Ordentrabajo::where('ordentrabajos.tproducto_id','=',$solicitudproducto->tproducto_id)->get();
                $ot = $otss->where('estado',0)->first();
                //busco una OT de ese producto que este en proceso (estado = 0)
                if ($ot) {//si existe una, se incrementa la cantidad del producto
                    $ot->cantidad = $ot->cantidad + $solicitudproducto->cantidad;
                    $ot->save();
                }else{//si no, se crea una nueva OT, donde la cantidad es la cantidad del producto de la solicitud
                    $ot = new Ordentrabajo();
                    $ot->tproducto_id = $solicitudproducto->tproducto_id;
                    $ot->estado = 0;
                    $ot->observaciones = "Sin detalles";
                    $ot->fecha = now();
                    $ot->tecnico ="Sin definir";
                    $ot->operario = "Sin definir";
                    $ot->cantidad = $solicitudproducto->cantidad;
                    $ot->save();
                }
                //Se crea el campo Ot solicitud,
                //donde se enlaza la solicitud a la OT
                //Recordad que la OT es por productos.
                $otsolicitude = new Otsolicitude;
                $otsolicitude->ordentrabajo_id = $ot->id;
                $otsolicitude->solicitude_id = $solicitude->id;
                $otsolicitude->cantidad = $solicitudproducto->cantidad;
                $otsolicitude->terminado = 0;
                $otsolicitude->save();
            }
            $solicitude->save();
            return redirect()->route('solicitudes.index')->with('success','Solicitud confirmada');
        }else {
            return redirect()->route('solicitudes.index')->with('error','No se puede confirmar, no esta en proceso');
        }
    }
    public function entregar(Request $request)
    {
        $solicitud_id=$request->input('id');
        $solicitude = Solicitude::findOrFail($solicitud_id);
        if ($solicitude->estado == 2) {
            $solicitude->estado = 3;
            $solicitude->save();
            return redirect()->route('solicitudes.index')->with('success','Solicitud entregada');
        }else{
            return redirect()->route('solicitudes.index')->with('success','No se puede entregar, no esta terminada');
        }
    }
}
