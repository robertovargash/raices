<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeUserController extends Controller
{
    public function index($name, $user = null){
        if ($user) {
            return "hola tu nombre es {$name} y tu usuario es {$user}";
        }else {        
            return "hola tu nombre es {$name} sin usuario";
        }
    }
}
