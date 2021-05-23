<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facturaelemento extends Model
{
    protected $fillable = [
        'factura_id','descripcion', 'um','cantidad','precio','tipo'
    ];

    public function factura(){
        return $this->belongsTo(Factura::class);
    }
}
