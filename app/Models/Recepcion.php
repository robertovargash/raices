<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recepcion extends Model
{
    protected $fillable = [
        'almacen_id','numero', 'observaciones', 'p_recibe', 'p_entrega', 'p_autoriza','fecha', 'activo','factura','proveedor'
     ];
 
     //aqui se establecen las relaciones del ORM Eloquent
     //en las clases (model) de almacen y clasificacion, hay un "hasMany()"
     //que establece que estas clases tienen varios 'Productos'
     public function almacen(){
         return $this->belongsTo(Almacen::class);
     }
 
     public function recepcionmercancias(){
         return $this->hasMany(Recepcionmercancia::class);
     }
}
