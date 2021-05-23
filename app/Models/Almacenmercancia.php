<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacenmercancia extends Model
{
    protected $fillable = [
        'almacen_id', 'mercancia_id','cantidad'
    ];

    public function almacen(){
        return $this->belongsTo(Almacen::class);
    }

    public function mercancia(){
        return $this->belongsTo(Mercancia::class);
    }
}
