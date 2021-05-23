<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tproducto extends Model
{
    protected $fillable = [
        'nombre','descripcion','tipotproducto_id', 'valorbruto','preciomanoobra','disponible','disponiblemprima'
    ];

    public function materiaprimas(){
        return $this->hasMany(Materiaprima::class);
    }

    public function tipotproducto(){
        return $this->belongsTo(Tipotproducto::class);
    }

    public function solicitudproductos(){
        return $this->hasMany(Solicitudproducto::class);
    }

    public function ordentrabajos(){
        return $this->hasMany(Ordentrabajo::class);
    }

    public function ofertaproductos(){
        return $this->hasMany(Ofertaproducto::class);
    }
}
