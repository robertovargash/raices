<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oferta extends Model
{
    protected $fillable = [
        'estado'
     ];

     public function ofertamercancias(){
         return $this->hasMany(Ofertamercancia::class);
     }

     public function ofertaproductos(){
        return $this->hasMany(Ofertaproducto::class);
    }
}
