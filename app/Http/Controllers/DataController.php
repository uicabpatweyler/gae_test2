<?php

namespace App\Http\Controllers;

use App\Models\Config\Cuota;
use App\Models\Config\Escuela;
use App\Models\Config\Ciclo;
use App\Models\Config\Grupo;
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
}
