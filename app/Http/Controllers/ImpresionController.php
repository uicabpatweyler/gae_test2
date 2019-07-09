<?php

namespace App\Http\Controllers;

use App\Models\Config\Ciclo;
use App\Models\Config\Escuela;
use Illuminate\Http\Request;

class ImpresionController extends Controller
{
    public function reciboHojaInscripcion(){
      return view('impresiones.recibohoja.index',[
        'escuelas' => Escuela::with('nivel')->get(),
        'ciclos' => Ciclo::orderBy('periodo','desc')->get()
      ]);
    }
}
