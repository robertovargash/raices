<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fianalisis extends Model
{
    protected $fillable = [
        'fisubcuenta_id','numero', 'descripcion'
    ];

    public function misubcuenta(){
        return $this->belongsTo(Fisubcuenta::class);
    }

    // public function analisiss(){
    //     return $this->hasMany(Fianalisis::class);
    // }
}
