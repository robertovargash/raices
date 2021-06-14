<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitude extends Model
{
    protected $casts = [
        'pagada' => 'boolean'
    ];
    protected $fillable = [
        'numero','cliente','telefono', 'fechasolicitud', 'fechaentrega','descripcion','estado','pagada','alpedido'
     ];

     public function solicitudproductos(){
         return $this->hasMany(Solicitudproducto::class);
     }

     public function otsolicitudes()
     {
         return $this->hasMany(Otsolicitude::class);
     }

     public function solicitudmateriasprimas()
     {
         return $this->hasMany(Solicitudmateriasprima::class);
     }
}
