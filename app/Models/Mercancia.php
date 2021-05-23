<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mercancia extends Model
{
    //segun el curso, esto es para los elementos que debo controlar a llenar,
    //para no insertar elementos desde la aplicacion que no se deban insertar

    protected $fillable = [
       'clasificacion_id','ficuenta_id','fisubcuenta_id','fiinfracuenta_id','codigo', 'nombremercancia', 'descripcion', 'um','cantidad', 'precio'
    ];

    //aqui se establecen las relaciones del ORM Eloquent
    //en las clases (model) de almacen y clasificacion, hay un "hasMany()"
    //que establece que estas clases tienen varios 'Mercancias'
    public function almacen(){
        return $this->belongsTo(Almacen::class);
    }

    public function clasificacion(){
        return $this->belongsTo(Clasificacion::class);
    }

    public function ficuenta(){
        return $this->belongsTo(Ficuenta::class);
    }

    public function fisubcuenta(){
        return $this->belongsTo(Fisubcuenta::class);
    }

    public function fiinfracuenta(){
        return $this->belongsTo(Fiinfracuenta::class);
    }

    public function valeitems()
    {
        return $this->hasMany(Valeitem::class);
    }

    public function almacenmercancias()
    {
        return $this->hasMany(Almacenmercancia::class);
    }

    public function recepcionmercancias()
    {
        return $this->hasMany(Recepcionmercancia::class);
    }

    public function materiaprimas()
    {
        return $this->hasMany(Materiaprima::class);
    }

    public function ofertamercancias(){
        return $this->hasMany(Ofertamercancia::class);
    }
}
