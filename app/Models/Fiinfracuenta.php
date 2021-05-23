<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fiinfracuenta extends Model
{
    protected $fillable = [
        'fisubcuenta_id','numero', 'descripcion'
    ];

    public function fisubcuenta(){
        return $this->belongsTo(Fisubcuenta::class);
    }

    public function mercancias(){
        return $this->hasMany(Mercancia::class);
    }

}
