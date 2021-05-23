<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clasificacion extends Model
{
    protected $fillable = [
        'clasificacion', 'detalle'
    ];

    public function mercancias(){
        return $this->hasMany(Mercancia::class);
    }
}
