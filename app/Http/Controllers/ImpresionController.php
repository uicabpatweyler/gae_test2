<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Config\Categoria;
use App\Models\Config\Ciclo;
use App\Models\Config\Escuela;
use App\Models\Config\Grado;
use App\Models\Inscripcion;
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

  public function historialDePagos1()
  {
      return view('impresiones.historialdepagos.index');
  }

  public function historialDePagos2(Alumno $alumno)
  {
      $rows =Inscripcion::where('alumno_id', $alumno->id)
          ->where('pago_id', '<>',0)
          ->join('escuelas', 'inscripciones.escuela_id','=','escuelas.id')
          ->join('ciclos', 'inscripciones.ciclo_id','=', 'ciclos.id')
          ->join('grados', 'inscripciones.grado_id', '=', 'grados.id')
          ->join('grupos', 'inscripciones.grupo_id', '=' , 'grupos.id')
          ->select('inscripciones.id','inscripciones.escuela_id','inscripciones.ciclo_id','inscripciones.grado_id')
          ->addSelect('inscripciones.grupo_id', 'inscripciones.infoalumno_id','inscripciones.pago_id')
          ->addSelect('escuelas.nombre as escuela','ciclos.periodo', 'grados.nombre as grado', 'grupos.nombre as grupo')
          ->orderBy('ciclos.periodo', 'desc')
          ->get();
      return view('impresiones.historialdepagos.index2',[
          'alumno' => $alumno,
          'rows' => $rows
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
