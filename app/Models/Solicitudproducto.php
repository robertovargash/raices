<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitudproducto extends Model
{
    protected $fillable = ['solicitude_id','cantidad','precio','tproducto_id','observaciones','terminado'];

    public function solicitude(){
        return $this->belongsTo(Solicitude::class);
    }

    public function tproducto(){
        return $this->belongsTo(Tproducto::class);
    }

    public function solicitudmateriasprimas()
     {
         return $this->hasMany(Solicitudmateriasprima::class);
     }
}
