<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuentasbancariascliente extends Model
{
    protected $fillable = [
        'banco','sucursal','cuenta','moneda','cliente_id'
    ];

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }
}
