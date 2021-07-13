<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\Chart;
use App\Models\Mercancia;
use App\Models\Oferta;
use App\Models\Ordentrabajo;
use App\Models\Proveedor;
use App\Models\Solicitude;
use App\Models\Tproducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Barryvdh\DomPDF\Facade as PDF;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    function __construct()
    {
        //  $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
        //  $this->middleware('permission:role-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:role-delete', ['only' => ['destroy']]);+
        // $this->middleware('permission:gestion_vale', ['only' => ['store','edit','update','show','cancelar']]);
        // $this->middleware('permission:firma_vale', ['only' => ['firmar']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
         $title = "Proyecto Raíces";
         $oferta = Oferta::where('ofertas.estado','=',1)->first();

         $count_tproductos = $oferta->ofertaproductos->count();
         $count_sol_proceso = Solicitude::where('solicitudes.estado','=',1)->get()->count();
         $count_sol_terminadas = Solicitude::where('solicitudes.estado','=',2)->get()->count();
         $count_OT_proceso = Ordentrabajo::where('ordentrabajos.estado','=',1)->get()->count();
         $proveedor = Proveedor::first();
         $count_mercancias = Mercancia::all()->count();

         $groups = DB::table('solicitudes')
                  ->select(DB::raw("DATE_FORMAT(solicitudes.fechaentrega,'%d/%m/%y') as fechaentrega"), DB::raw('sum(solicitudproductos.precio * solicitudproductos.cantidad) as total'))
                  ->join('solicitudproductos', 'solicitudes.id', '=', 'solicitudproductos.solicitude_id')
                  ->join('tproductos', 'tproductos.id', '=', 'solicitudproductos.tproducto_id')
                  ->groupBy('fechaentrega')
                  ->orderBy('fechaentrega')
                   ->take(7)
                   ->where('solicitudes.estado','=',3)
                  ->pluck('total', 'fechaentrega')->all();


        $grupoMes = DB::table('solicitudes')
                  ->select(DB::raw("DATE_FORMAT(solicitudes.fechaentrega,'%m/%y') as fecha"), DB::raw('sum(solicitudproductos.precio * solicitudproductos.cantidad) as total'))
                  ->join('solicitudproductos', 'solicitudes.id', '=', 'solicitudproductos.solicitude_id')
                   ->groupBy('fecha')
                //    ->orderBy('fechaentrega')
                   ->where('solicitudes.estado','=',3)
                  ->pluck('total', 'fecha')->all();

        $chartsemana = new Chart();
        $chartsemana->labels = (array_keys($groups));
        $chartsemana->dataset = (array_values($groups));

        $chartmes = new Chart();
        $chartmes->labels = (array_keys($grupoMes));
        $chartmes->dataset = (array_values($grupoMes));
        // $chart->colours = $colours;

        $lastseven = DB::table('solicitudes')
        ->select(DB::raw('sum(tproductos.valorbruto * solicitudproductos.cantidad) as total'))
        ->join('solicitudproductos', 'solicitudes.id', '=', 'solicitudproductos.solicitude_id')
        ->join('tproductos', 'tproductos.id', '=', 'solicitudproductos.tproducto_id')
         ->take(7)
         ->where('solicitudes.estado','=',3)
        ->pluck('total')->all();


         return view('welcome',compact('title', 'count_mercancias','count_tproductos','count_sol_proceso','count_sol_terminadas','count_OT_proceso','proveedor','chartsemana','chartmes','lastseven'));

    }

    public function existenciapdf(){

        $title = "Existencia en almacenes";
        $almacenes = Almacen::all();
        $proveedor = Proveedor::first();
        $pdf = PDF::setOptions([
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ])->loadView('almacens.existenciapdf', compact('title','almacenes','proveedor'));
    	 return $pdf->setPaper('chart','landscape')->stream('Existencia_en_almacenes.pdf');
    }
}
