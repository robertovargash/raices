<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $fillable = [
        'nombre','siglas','direccion','reeup','nit','telefono'
    ];

    public function proveedorcuentas(){
        return $this->hasMany(Proveedorcuenta::class);
    }
}
