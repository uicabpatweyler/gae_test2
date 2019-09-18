<?php

namespace App\Http\Controllers;

use App\Models\Config\Categoria;
use App\Models\Config\Ciclo;
use App\Models\Config\Escuela;
use App\Models\Config\Grado;
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

  public function listadoInscripciones(){
      return view('impresiones.reportes.inscripcion.index');
  }

  public function inscripcionesGradoGrupo(){
    return view('impresiones.reportes.inscripcionescuelaciclo.index',[
      'escuelas' => Escuela::with('nivel')->get(),
      'ciclos' => Ciclo::orderBy('periodo','desc')->get()
    ]);
  }

  public function kardexProductos(){
      return view('impresiones.reportes.kardex.index',[
        'escuelas' => Escuela::with('nivel')->get(),
        'ciclos' => Ciclo::orderBy('periodo','desc')->get(),
        'categorias' => Categoria::where('parent_id', '=', 0)->get()
      ]);
  }

  public function listaVentasPordia(){
    return view('impresiones.reportes.ventaspordia.index');
  }

  public function listasDeAsistencia(){
      return view('impresiones.listadeasistencia.create',[
        'escuelas' => Escuela::with('nivel')->get(),
        'ciclos' => Ciclo::orderBy('periodo','desc')->get()
      ]);
  }

  public function indexAlumnosDeudores()
  {
    return view('impresiones.reportes.alumnosdeudores.index',[
      'escuelas' => Escuela::with('nivel')->get(),
      'ciclos' => Ciclo::orderBy('periodo','desc')->get(),
      'grados' => Grado::all()
    ]);
  }
}
