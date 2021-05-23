<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $fillable = [
        'numero','proveedor_id','cliente_id', 'estado','fecha','elabora','entrega','recibe','transporta','tci','tchapa','descripcion'
    ];

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }

    public function facturaelementos(){
        return $this->hasMany(Facturaelemento::class);
    }
}
