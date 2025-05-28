<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
  // aqui vamos colocar todas as funções que precisamos
   public function error(){
        return response()->view('fallback.fallback', [], 404);
    }
}
