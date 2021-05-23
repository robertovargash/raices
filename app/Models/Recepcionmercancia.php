<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recepcionmercancia extends Model
{
    protected $fillable = [
        'recepcion_id','mercancia_id','cantidad', 'precio'
    ];

    public function recepcion(){
        return $this->belongsTo(Recepcion::class);
    }
     public function mercancia()
     {
         return $this->belongsTo(Mercancia::class);
     }
}
