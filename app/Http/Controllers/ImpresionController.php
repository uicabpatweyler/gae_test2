<?php

namespace App\Http\Controllers;

use App\Models\Config\Ciclo;
use App\Models\Config\Escuela;
use Illuminate\Http\Request;

class ImpresionController extends Controller
{
    public function hojaInscripcion(){
      return view('impresiones.hojainscripcion.index',[
        'escuelas' => Escuela::with('nivel')->get(),
        'ciclos' => Ciclo::orderBy('periodo','desc')->get()
      ]);
    }

  public function reciboInscripcion(){
    return view('impresiones.reciboinscripcion.index',[
      'escuelas' => Escuela::with('nivel')->get(),
      'ciclos' => Ciclo::orderBy('periodo','desc')->get()
    ]);
  }

  public function reciboColegiatura(){
      return view('impresiones.recibocolegiatura.index');
  }
}
