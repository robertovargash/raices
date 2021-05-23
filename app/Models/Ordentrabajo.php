<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordentrabajo extends Model
{
    protected $fillable = [
        'tproducto_id','numero','estado', 'observaciones','fecha','cantidad','tecnico','operario'
     ];

    public function otsolicitudes(){
        return $this->hasMany(Otsolicitude::class);
    }

    public function tproducto(){
        return $this->belongsTo(Tproducto::class);
    }

    public function vale(){
        return $this->hasOne(Vale::class);
    }
}
