<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ofertaproducto extends Model
{
    protected $fillable = [
        'oferta_id','tproducto_id','cantidad'
     ];

     public function oferta(){
         return $this->belongsTo(Oferta::class);
     }

     public function tproducto(){
        return $this->belongsTo(Tproducto::class);
    }
}
