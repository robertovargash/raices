<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vale extends Model
{
    protected $fillable = [
        'almacen_id','numero','observaciones', 'p_solicita', 'p_entrega','p_autoriza', 'fecha', 'activo','tipovale','ordentrabajo_id'
    ];

    //aqui se establecen las relaciones del ORM Eloquent
    //en las clases (model) de almacen y clasificacion, hay un "hasMany()"
    //que establece que estas clases tienen varios 'Vales'
    public function almacen(){
        return $this->belongsTo(Almacen::class);
    }
    public function valeitems(){
        return $this->hasMany(Valeitem::class);
    }

    public function mercancias(){
        return $this->hasManyThrough(Mercancia::class, Valeitem::class);
    }

    public function ordentrabajo(){
        return $this->belongsTo(Ordentrabajo::class);
    }
}
