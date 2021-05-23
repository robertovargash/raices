<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    protected $fillable = [
        'almacen', 'descripcion'
    ];

    public function almacenmercancias(){
        return $this->hasMany(Almacenmercancia::class);
    }

    public function vales(){
        $this->fillable;
        return $this->hasMany(Vale::class);

    }

    public function recepciones(){
        return $this->hasMany(Recepcion::class);
    }
}
