<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fisubcuenta extends Model
{
    protected $fillable = [
        'ficuenta_id','numero', 'descripcion'
    ];

    public function ficuenta(){
        return $this->belongsTo(Ficuenta::class);
    }

    public function fiinfracuentas(){
        return $this->hasMany(Fiinfracuenta::class);
    }

    public function mercancias(){
        return $this->hasMany(Mercancia::class);
    }
}
