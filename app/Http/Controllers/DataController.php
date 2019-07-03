<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Config\Cuota;
use App\Models\Config\Escuela;
use App\Models\Config\Ciclo;
use App\Models\Config\Grupo;
use App\Models\InformacionAlumno;
use App\Models\Inscripcion;
use App\Models\Tutor;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DataController extends Controller
{

  public function escuelas()
  {
    $escuelas = Escuela::with('nivel')->orderBy('created_at', 'desc')->get();
    return DataTables::of($escuelas)
      ->addColumn('actions', function ($escuela) {
        $showUrl = route('escuelas.show', ['id' => $escuela->id]);
        $editUrl = route('escuelas.edit', ['id' => $escuela->id]);
        $deleteUrl = route('escuelas.destroy', ['id' => $escuela->id]);
        return view('_formActions', compact('showUrl', 'editUrl', 'deleteUrl'));
      })
      ->make(true);
  }

  public function ciclos()
  {
    $ciclos = Ciclo::orderBy('periodo', 'desc')->get();
    return DataTables::of($ciclos)
      ->addColumn('actions', function ($ciclo) {
        $showUrl = route('ciclos.show', ['id' => $ciclo->id]);
        $editUrl = route('ciclos.edit', ['id' => $ciclo->id]);
        $deleteUrl = route('ciclos.destroy', ['id' => $ciclo->id]);
        return view('_formActions', compact('showUrl', 'editUrl', 'deleteUrl'));
      })
      ->make(true);
  }

  public function grados($escuela)
  {
    /* Relacion ESCUELA:GRADOS 1:M*/
    $grados = Escuela::find($escuela)->grados()
      ->orderBy('id', 'asc')
      ->get();
    return DataTables::of($grados)
      ->addColumn('actions', function ($grado) {
        $showUrl = route('grados.show', ['id' => $grado->id]);
        $editUrl = route('grados.edit', ['id' => $grado->id]);
        $deleteUrl = route('grados.destroy', ['id' => $grado->id]);
        return view('_formActions', compact('showUrl', 'editUrl', 'deleteUrl'));
      })
      ->make(true);
  }

  /*
   * Relacion ESCUELA:GRUPOS 1:M
   * Relacion CICLO:GRUPOS 1:M
   * Relacion GRADO:GRUPOS
   */
  public function grupos($escuela, $grado, $ciclo)
  {
    $grupos = Grupo::with('grado')
      ->where('escuela_id', $escuela)
      ->where('ciclo_id', $ciclo)
      ->where('grado_id', $grado)
      ->get();
    return DataTables::of($grupos)
      ->addColumn('actions', function ($grupo) {
        $showUrl = route('grupos.show', ['id' => $grupo->id]);
        $editUrl = route('grupos.edit', ['id' => $grupo->id]);
        $deleteUrl = route('grupos.destroy', ['id' => $grupo->id]);
        return view('_formActions', compact('showUrl', 'editUrl', 'deleteUrl'));
      })
      ->addColumn('cuotains', function ($grupo) {
        $cuotai = $grupo->cuotainscripcion_id === 0 ? 0 : Cuota::find($grupo->cuotainscripcion_id)->cantidad;
        return '$ ' . number_format($cuotai, 2, '.', ',');
      })
      ->addColumn('cuotacol', function ($grupo) {
        $cuotac = $grupo->cuotacolegiatura_id === 0 ? 0 : Cuota::find($grupo->cuotacolegiatura_id)->cantidad;
        return '$ ' . number_format($cuotac, 2, '.', ',');
      })
      ->make(true);
  }

  public function gruposInscripcion($escuela, $grado, $ciclo){
    $grupos = Grupo::with('grado')
      ->where('escuela_id','=',$escuela)
      ->where('ciclo_id','=',$ciclo)
      ->where('grado_id','=',$grado)
      ->orderBy('nombre','asc')
      ->get();

    return Datatables::of($grupos)
      ->addColumn('inscritos', function($grupo) {
        return  Inscripcion::where('grupo_id',$grupo->id)->count();
      })
      ->addColumn('cuotains', function ($grupo) {
        $cuotai = $grupo->cuotainscripcion_id === 0 ? 0 : Cuota::find($grupo->cuotainscripcion_id)->cantidad;
        return '$ ' . number_format($cuotai, 2, '.', ',');
      })
      ->addColumn('details', function($grupo){
        $detalles  = $grupo->escuela_id;
        $detalles .= '-'.$grupo->ciclo_id;
        $detalles .= '-'.$grupo->grado_id;
        $detalles .= '-'.$grupo->id;
        $detalles .= '-'.$grupo->nombre;
        return view('inscripciones._btnAsignGrupo', compact('detalles'));
      })
      ->make(true);

  }

  /* Select de los grados para la creacion de un nuevo grupo*/
  public function selectGradosEscuela($escuela)
  {
    /*Relacion ESCUELA:GRADOS: 1:M*/
    $grados = Escuela::find($escuela)->grados()
      ->select(['id as value', DB::raw("CONCAT(nombre,' ',abreviacion)  AS text")])->get()->toArray();

    array_unshift($grados, ['value' => '', 'text' => '[Elegir grado]']);

    return $grados;
  }

  public function selectCuotas($escuela, $ciclo, $tipo)
  {
    $cuotas = Cuota::select([
      'id as value', DB::raw("CONCAT(nombre,' ',cantidad)  AS text")
    ])
      ->where('escuela_id', $escuela)
      ->where('ciclo_id', $ciclo)
      ->where('tipo', $tipo)->get()->toArray();

    array_unshift($cuotas, ['value' => '', 'text' => '[Elegir cuota]']);

    return $cuotas;
  }

  /* Select de las delegaciones*/
  public function selectDelegaciones($estado){
    $delegaciones = DB::table('delegaciones')
      ->where('estado_id',$estado)
      ->select('delegacion_clave as value', 'delegacion_nombre as text')
      ->orderBy('delegacion_nombre', 'asc')
      ->get()
      ->toArray();

    array_unshift($delegaciones, ['value' => '', 'text' => 'Seleccione...']);

    return $delegaciones;
  }

  /* Select de las colonias*/
  public function selectColonias($estado, $delegacion){
    $colonias = DB::table('codigospostales')
      ->where('estado_id',$estado)
      ->where('delegacion_id',$delegacion)
      ->select('id as value', 'cp_asentamiento as text')
      ->orderBy('cp_asentamiento', 'asc')
      ->get()
      ->toArray();

    array_unshift($colonias, ['value' => '', 'text' => 'Seleccione...']);

    return $colonias;
  }

  /*Obtener los detalles de la colonia elegida*/
  public function colonia($colonia){
    $detalles = DB::table('codigospostales')->find($colonia);

    return response()
      ->json([
        'localidad'        => $detalles->cp_ciudad,
        'tipo'             => $detalles->cp_tipoasentamiento,
        'asentamiento'     => $detalles->cp_asentamiento,
        'codigo'           => $detalles->cp_codigo
      ]);
  }

  public function cuotas($escuela, $ciclo, $tipo)
  {
    /* Relacion ESCUELA:CUOTAS (1:M). Tipo cuota: 1=Inscripcion 2=Colegiatura*/
    $cuotas = Escuela::find($escuela)->cuotas()
      ->where('ciclo_id', $ciclo)
      ->where('tipo', $tipo);
    return DataTables::of($cuotas)
      ->addColumn('actions', function ($cuota) {
        $showUrl = route('cuotas.show', ['id' => $cuota->id]);
        $editUrl = route('cuotas.edit', ['id' => $cuota->id]);
        $deleteUrl = route('cuotas.destroy', ['id' => $cuota->id]);
        return view('_formActions', compact('showUrl', 'editUrl', 'deleteUrl'));
      })
      ->addColumn('apply', function($cuota){
        $applyUrl = route('show.apply.pay',['id' => $cuota->id]);
        return view('cuotas.btnApplyPay',compact('applyUrl'));
      })
      ->make(true);
  }

  public function tutores(){
    $tutores = Tutor::orderBy('nombre', 'asc')->get();
    return DataTables::of($tutores)
      ->addColumn('actions', function ($tutor) {
        $showUrl = route('tutores.show', ['id' => $tutor->id]);
        $editUrl = route('tutores.edit', ['id' => $tutor->id]);
        $deleteUrl = route('tutores.destroy', ['id' => $tutor->id]);
        return view('_formActions', compact('showUrl', 'editUrl', 'deleteUrl'));
      })
      ->addColumn('asignar', function($tutor){
        $url = route('tutor.elegir.alumno', ['tutor' => $tutor->id]);
        return view('tutores._btnAsignar', compact('url'));
      })
      ->make(true);
  }

  public function alumnos(){
    $alumnos = Alumno::orderBy('apellido1','asc')->get();
    return DataTables::of($alumnos)
      ->addColumn('select', function($alumno){
        $urlAlumno = route('reinscripcion.selectciclo', $alumno->id);
        return view('reinscripciones._btnSelectAlumno', compact('urlAlumno'));
      })
      ->make(true);
  }

  public function infoAlumnos(){
    $infoAlumnos = DB::table('alumnos')
      ->join('informacion_alumnos', 'alumnos.id','=', 'informacion_alumnos.alumno_id')
      ->select('informacion_alumnos.id as infoalumno_id', 'informacion_alumnos.tutor_id')
      ->addselect('alumnos.id as alumno_id','alumnos.nombre1', 'alumnos.nombre2', 'alumnos.apellido1', 'alumnos.apellido2')
      ->where('informacion_alumnos.escuela_id', '=', 0)
      ->where('informacion_alumnos.ciclo_id', '=', 0)
      ->orderBy('informacion_alumnos.created_at', 'desc')
      ->get();
    return DataTables::of($infoAlumnos)
      ->addColumn('enroll', function($infoAlumno){
        $createUrl =  $infoAlumno->tutor_id!==0 ? route('inscripcion.create',$infoAlumno->infoalumno_id) : null;
        return view('inscripciones._btnEnroll', compact('createUrl'));
      })
      ->addColumn('tutor', function($infoAlumno){
        $tutorUrl = $infoAlumno->tutor_id===0 ? route('tutores.index') : null;
        return view('inscripciones._btnAsignTutor', compact('tutorUrl'));
      })
      ->make(true);
  }
}
/*
 * https://www.php.net/manual/es/language.operators.comparison.php
 * Si se compara un número con un string o la comparación implica strings numéricos,
 * entonces cada string es convertido en un número y la comparación realizada numéricamente.
 * Estas reglas también se aplican a la sentencia switch.
 * La conversión de tipo no tiene lugar cuando la comparación
 * es === o !== ya que esto involucra comparar el tipo así como el valor.
 */