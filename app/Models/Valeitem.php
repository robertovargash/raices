<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Valeitem extends Model
{
    protected $fillable = [
        'vale_id','mercancia_id','cantidad', 'precio'
    ];

    public function vale(){
        return $this->belongsTo(Vale::class);
    }
     public function mercancia()
     {
         return $this->belongsTo(Mercancia::class);
     }
}
