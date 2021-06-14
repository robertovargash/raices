<?php

namespace App\Http\Controllers;

use App\Models\Chart;
use App\Models\Oferta;
use App\Models\Ordentrabajo;
use App\Models\Proveedor;
use App\Models\Solicitude;
use App\Models\Tproducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
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



        // $meses = array("En","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
        // $fecha = Carbon::parse($grupoMes);
        // $mes = $meses[($fecha->format('n')) - 1];
        // $inputs['Fecha'] = $fecha->format('d') . ' de ' . $mes . ' de ' . $fecha->format('Y');
        // Generate random colours for the groups
        // for ($i=0; $i<=count($groups); $i++) {
        //             $colours[] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
        //         }
        // Prepare the data for returning with the view
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


         return view('welcome',compact('title','count_tproductos','count_sol_proceso','count_sol_terminadas','count_OT_proceso','proveedor','chartsemana','chartmes','lastseven'));

    }
}
