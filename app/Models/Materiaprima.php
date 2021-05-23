<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materiaprima extends Model
{
    protected $fillable = [
        'tproducto_id','mercancia_id','cantidadnecesaria'
    ];

    public function tproducto(){
        return $this->belongsTo(Tproducto::class);
    }
     public function mercancia()
     {
         return $this->belongsTo(Mercancia::class);
     }
}
