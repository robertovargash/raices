<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedorcuenta extends Model
{
    protected $fillable = [
        'banco','sucursal','cuenta','moneda','proveedor_id'
    ];

    public function proveedor(){
        return $this->belongsTo(Proveedor::class);
    }
}
