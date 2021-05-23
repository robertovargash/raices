<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ficuenta extends Model
{

    protected $fillable = [
        'numero', 'descripcion','clasificadorcuenta_id'
    ];

    public function fisubcuentas(){
        return $this->hasMany(Fisubcuenta::class);
    }

    public function clasificadorcuenta(){
        return $this->belongsTo(Clasificadorcuenta::class);
    }

    public function mercancias(){
        return $this->hasMany(Mercancia::class);
    }
}
