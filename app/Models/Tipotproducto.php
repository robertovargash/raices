<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipotproducto extends Model
{
    protected $fillable = [
        'tipo'
    ];

    public function tproductos(){
        return $this->hasMany(Tproducto::class);
    }
}
