<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otsolicitude extends Model
{
    protected $fillable = [
        'ordentrabajo_id','solicitude_id', 'cantidad','terminado'
     ];
 
     //aqui se establecen las relaciones del ORM Eloquent
     //en las clases (model) de almacen y clasificacion, hay un "hasMany()"
     //que establece que estas clases tienen varios 'Productos'
     public function solicitude(){
         return $this->belongsTo(Solicitude::class);
     }
 
     public function ordentrabajo(){
         return $this->belongsTo(Ordentrabajo::class);
     }

     
}
