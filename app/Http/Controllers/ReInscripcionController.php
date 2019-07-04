<?php

namespace App\Http\Controllers;

use App\Http\Requests\InfoAlumnoRequest;
use App\Models\Alumno;
use App\Models\InformacionAlumno;
use App\Models\Inscripcion;
use Illuminate\Support\Facades\DB;

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
      ->orderBy('ciclos.periodo', 'desc')
      ->get();

    return view('reinscripciones.selectciclo', [
      'rows' => $rows,
      'alumno' => $alumno
    ]);
  }

  public function createInfoAlumno(Alumno $alumno, InformacionAlumno $informacionAlumno){
    return view('reinscripciones.create',[
      'alumno' => $alumno,
      'info'   => $informacionAlumno,
      'estados'=> DB::table('estados')->select('id', 'estado_nombre')->get()
    ]);
  }

  public function storeInfoAlumno(InfoAlumnoRequest $request){
    $infoAlumno = tap(new InformacionAlumno($request->all()))->save();
    return response()
      ->json([
        'message'  => 'Los datos se han guardado correctamente',
        'location' => route('tutores.index')
      ]);
  }

}
