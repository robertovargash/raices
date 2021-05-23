<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ofertamercancia extends Model
{
    protected $fillable = [
        'oferta_id','mercancia_id','cantidad'
     ];

     public function oferta(){
         return $this->belongsTo(Oferta::class);
     }

     public function mercancia(){
        return $this->belongsTo(Mercancia::class);
    }
}
