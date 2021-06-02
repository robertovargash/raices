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
                  ->select('solicitudes.fechaentrega', DB::raw('sum(tproductos.valorbruto * solicitudproductos.cantidad) as total'))
                  ->join('solicitudproductos', 'solicitudes.id', '=', 'solicitudproductos.solicitude_id')
                  ->join('tproductos', 'tproductos.id', '=', 'solicitudproductos.tproducto_id')
                  ->groupBy('fechaentrega')
                  ->orderByDesc('fechaentrega')
                  ->take(7)
                //   ->where('solicitudes.estado','=',3)
                  ->pluck('total', 'fechaentrega')->all();
        // Generate random colours for the groups
        for ($i=0; $i<=count($groups); $i++) {
                    $colours[] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
                }
        // Prepare the data for returning with the view
        $chart = new Chart();
        $chart->labels = (array_keys($groups));
        $chart->dataset = (array_values($groups));
        $chart->colours = $colours;


         return view('welcome',compact('title','count_tproductos','count_sol_proceso','count_sol_terminadas','count_OT_proceso','proveedor','chart'));

    }
}
