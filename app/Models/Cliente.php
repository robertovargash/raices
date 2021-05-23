<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
        'nombre','siglas','direccion','reeup','nit','telefono'
    ];

    public function cuentasbancariasclientes(){
        return $this->hasMany(Cuentasbancariascliente::class);
    }

    public function facturas(){
        return $this->hasMany(Factura::class);
    }
}
