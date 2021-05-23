<?php

namespace App\Http\Controllers;

use App\Models\Ordentrabajo;
use App\Models\Proveedor;
use App\Models\Solicitude;
use App\Models\Tproducto;
use Illuminate\Http\Request;

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
         $count_tproductos = Tproducto::where('tproductos.disponible',1)->count();
         $count_sol_proceso = Solicitude::where('solicitudes.estado','=',1)->get()->count();
         $count_sol_terminadas = Solicitude::where('solicitudes.estado','=',2)->get()->count();
         $count_OT_proceso = Ordentrabajo::where('ordentrabajos.estado','=',1)->get()->count();
         $proveedor = Proveedor::first();
         return view('welcome',compact('title','count_tproductos','count_sol_proceso','count_sol_terminadas','count_OT_proceso','proveedor'));

    }
}
