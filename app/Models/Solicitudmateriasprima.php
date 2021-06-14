<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitudmateriasprima extends Model
{
    protected $fillable = [
        'solicitude_id','mercancia_id','solicitudproducto_id', 'cantidad'
     ];

     public function solicitude(){
         return $this->belongsTo(Solicitude::class);
     }
     public function mercancia(){
        return $this->belongsTo(Mercancia::class);
    }
    public function solicitudproducto(){
        return $this->belongsTo(Solicitudproducto::class);
    }
}
