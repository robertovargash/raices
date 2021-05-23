<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clasificadorcuenta extends Model
{
    protected $fillable = [
        'clasificacion'
    ];

    public function ficuentas(){
        return $this->hasMany(Ficuenta::class);
    }
}
