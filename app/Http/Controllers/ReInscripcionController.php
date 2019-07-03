<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\InformacionAlumno;
use App\Models\Inscripcion;

class ReInscripcionController extends Controller
{
  public function index()
  {
    return view('reinscripciones.index');
  }
  public function selectCiclo(Alumno $alumno){
    $rows =Inscripcion::where('alumno_id', $alumno->id)
      ->join('escuelas', 'inscripciones.escuela_id','=','escuelas.id')
      ->join('ciclos', 'inscripciones.ciclo_id','=', 'ciclos.id')
      ->join('grados', 'inscripciones.grado_id', '=', 'grados.id')
      ->join('grupos', 'inscripciones.grupo_id', '=' , 'grupos.id')
      ->select('inscripciones.id','inscripciones.escuela_id','inscripciones.ciclo_id','inscripciones.grado_id')
      ->addSelect('inscripciones.grupo_id', 'inscripciones.infoalumno_id')
      ->addSelect('escuelas.nombre as escuela','ciclos.periodo', 'grados.nombre as grado', 'grupos.nombre as grupo')
      ->get();

    return view('reinscripciones.selectciclo', [
      'rows' => $rows,
      'alumno' => $alumno
    ]);
  }

  public function createInfoAlumno(Alumno $alumno, InformacionAlumno $informacionAlumno){
    return dd($informacionAlumno);
  }
}
