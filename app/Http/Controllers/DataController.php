<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Config\Categoria;
use App\Models\Config\Cuota;
use App\Models\Config\Escuela;
use App\Models\Config\Ciclo;
use App\Models\Config\Grupo;
use App\Models\Inscripcion;
use App\Models\Producto;
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

  //resincripciones.index
  public function alumnos(){
    $alumnos = Alumno::orderBy('apellido1','asc')->get();
    return DataTables::of($alumnos)
      ->addColumn('select', function($alumno){
        $urlAlumno = route('reinscripcion.selectciclo', $alumno->id);
        return view('reinscripciones._btnSelectAlumno', compact('urlAlumno'));
      })
      ->make(true);
  }

  /*inscripciones.index*/
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

  /*alumnos.index*/
  public function indexAlumnos(){
    $alumnos = Alumno::orderBy('apellido1','asc')->get();
    return DataTables::of($alumnos)
      ->addColumn('actions', function ($tutor) {
        $showUrl = route('alumnos.show', ['id' => $tutor->id]);
        $editUrl = route('alumnos.edit', ['id' => $tutor->id]);
        $deleteUrl = route('alumnos.destroy', ['id' => $tutor->id]);
        return view('_formActions', compact('showUrl', 'editUrl', 'deleteUrl'));
      })
      ->make(true);
  }

  /*impresiones.hojainscripcion.index*/
  /*pagos.colegiatura.index (realizar pago)*/
  public function alumnosEscuelaCiclo($escuela,$ciclo){
    $rows = DB::table('alumnos')
      ->join('inscripciones', 'alumnos.id','=', 'inscripciones.alumno_id')
      ->join('escuelas', 'inscripciones.escuela_id','=','escuelas.id')
      ->join('ciclos', 'inscripciones.ciclo_id','=','ciclos.id')
      ->join('grados','inscripciones.grado_id','=','grados.id')
      ->join('grupos','inscripciones.grupo_id','=','grupos.id')
      ->select('inscripciones.id as inscripcion_id', 'inscripciones.escuela_id', 'inscripciones.ciclo_id')
      ->addSelect('inscripciones.grado_id', 'inscripciones.grupo_id', 'inscripciones.infoalumno_id')
      ->addSelect('inscripciones.alumno_id', 'inscripciones.pago_id')
      ->addSelect('inscripciones.baja_id', 'inscripciones.becario_id','inscripciones.fecha')
      ->addSelect('escuelas.nombre as escuela', 'ciclos.periodo')
      ->addSelect('grados.nombre as grado', 'grupos.nombre as grupo')
      ->addSelect( 'alumnos.nombre1','alumnos.nombre2','alumnos.apellido1', 'alumnos.apellido2')
      ->where('inscripciones.escuela_id','=', $escuela)
      ->where('inscripciones.ciclo_id','=', $ciclo)
      ->orderBy('inscripciones.pago_id', 'asc')
      ->get();
    return DataTables::of($rows)
      ->addColumn('ciclo_enroll', function($row){
        $cicloEnroll = $row->periodo;
        $groupEnroll = null;
        $urlHoja     = null;
        $urlRecibo   = null;
        $urlPago     = null;
        return view('_columnsDT',[
          'cicloEnroll' => $cicloEnroll,
          'groupEnroll' => $groupEnroll,
          'urlHoja'     => $urlHoja,
          'urlRecibo'   => $urlRecibo,
          'urlPago'     => $urlPago,
          'urlShowToCancel' => null
        ]);
      })
      ->addColumn('group_enroll', function($row){
        $cicloEnroll = null;
        $groupEnroll = $row->grupo;
        $urlHoja     = null;
        $urlRecibo   = null;
        $urlPago     = null;
        return view('_columnsDT',[
          'cicloEnroll' => $cicloEnroll,
          'groupEnroll' => $groupEnroll,
          'urlHoja'     => $urlHoja,
          'urlRecibo'   => $urlRecibo,
          'urlPago'     => $urlPago,
          'urlShowToCancel' => null
        ]);
      })
      ->addColumn('sheet_enroll', function($row){
        $cicloEnroll = null;
        $groupEnroll = null;
        $urlHoja     = route('print.hoja.inscripcion', $row->inscripcion_id);
        $urlRecibo   = null;
        $urlPago     = null;
        return view('_columnsDT',[
          'cicloEnroll' => $cicloEnroll,
          'groupEnroll' => $groupEnroll,
          'urlHoja'     => $urlHoja,
          'urlRecibo'   => $urlRecibo,
          'urlPago'     => $urlPago,
          'urlShowToCancel' => null
        ]);
      })
      ->addColumn('receipt_enroll', function($row){
        $cicloEnroll = null;
        $groupEnroll = null;
        $urlHoja     = null;
        $urlRecibo   = route('print.recibo.inscripcion', ['pago' => $row->pago_id, 'inscripcion' =>$row->inscripcion_id ]);
        $urlPago     = null;
        return view('_columnsDT',[
          'cicloEnroll' => $cicloEnroll,
          'groupEnroll' => $groupEnroll,
          'urlHoja'     => $urlHoja,
          'urlRecibo'   => $urlRecibo,
          'urlPago'     => $urlPago,
          'urlShowToCancel' => null
        ]);
      })
      ->addColumn('pago_colegiatura', function($row){
        $cicloEnroll = null;
        $groupEnroll = null;
        $urlHoja     = null;
        $urlRecibo   = null;
        $urlPago = route('pagocolegiaturas.create',['inscripcion' => $row->inscripcion_id]);
        return view('_columnsDT',[
          'cicloEnroll' => $cicloEnroll,
          'groupEnroll' => $groupEnroll,
          'urlHoja'     => $urlHoja,
          'urlRecibo'   => $urlRecibo,
          'urlPago'     => $urlPago,
          'urlShowToCancel' => null
        ]);
      })
      ->make(true);
  }

  /*impresiones.recibocolegiatura.index*/
  /*pagos.colegiatura.index (cancelar pago)*/
  public function colegiaturasPorFecha($fecha){
    $rows = DB::table('alumnos')
      ->join('pago_colegiaturas', 'alumnos.id','=', 'pago_colegiaturas.alumno_id')
      ->join('escuelas', 'pago_colegiaturas.escuela_id','=','escuelas.id')
      ->join('ciclos', 'pago_colegiaturas.ciclo_id','=','ciclos.id')
      ->join('grados','pago_colegiaturas.grado_id','=','grados.id')
      ->join('grupos','pago_colegiaturas.grupo_id','=','grupos.id')
      ->select('pago_colegiaturas.id', 'pago_colegiaturas.fecha_pago', 'pago_colegiaturas.pago_cancelado')
      ->addSelect('pago_colegiaturas.cantidad_recibida_mxn', 'pago_colegiaturas.folio_recibo')
      ->addSelect( 'alumnos.nombre1','alumnos.nombre2','alumnos.apellido1', 'alumnos.apellido2')
      ->addSelect('escuelas.nombre as escuela', 'ciclos.periodo')
      ->addSelect('grados.nombre as grado', 'grupos.nombre as grupo')
      ->whereDate('fecha_pago', $fecha)
      ->orderBy('pago_colegiaturas.folio_recibo', 'asc')
      ->get();

    return DataTables::of($rows)
      ->addColumn('ciclo_enroll', function($row){
        $cicloEnroll = $row->periodo;
        $groupEnroll = null;
        $urlHoja     = null;
        $urlRecibo   = null;
        $urlPago     = null;
        $urlShowToCancel = null;
        return view('_columnsDT',[
          'cicloEnroll' => $cicloEnroll,
          'groupEnroll' => $groupEnroll,
          'urlHoja'     => $urlHoja,
          'urlRecibo'   => $urlRecibo,
          'urlPago'     => $urlPago,
          'urlShowToCancel' => $urlShowToCancel
        ]);
      })
      ->addColumn('importe', function ($row) {
        return '$ ' . number_format($row->cantidad_recibida_mxn, 2, '.', ',');
      })
      ->addColumn('group_enroll', function($row){
        $cicloEnroll = null;
        $groupEnroll = $row->grupo;
        $urlHoja     = null;
        $urlRecibo   = null;
        $urlPago     = null;
        $urlShowToCancel = null;
        return view('_columnsDT',[
          'cicloEnroll' => $cicloEnroll,
          'groupEnroll' => $groupEnroll,
          'urlHoja'     => $urlHoja,
          'urlRecibo'   => $urlRecibo,
          'urlPago'     => $urlPago,
          'urlShowToCancel' => $urlShowToCancel
        ]);
      })
      ->addColumn('recibo_colegiatura', function($row){
        $cicloEnroll = null;
        $groupEnroll = null;
        $urlHoja     = null;
        $urlRecibo   = route('print.recibo.colegiatura',['pago' => $row->id]);
        $urlPago     = null;
        $urlShowToCancel = null;
        return view('_columnsDT',[
          'cicloEnroll' => $cicloEnroll,
          'groupEnroll' => $groupEnroll,
          'urlHoja'     => $urlHoja,
          'urlRecibo'   => $urlRecibo,
          'urlPago'     => $urlPago,
          'urlShowToCancel' => $urlShowToCancel
        ]);
      })
      ->addColumn('showpaytocancel', function($row){
        $cicloEnroll = null;
        $groupEnroll = null;
        $urlHoja     = null;
        $urlRecibo   = null;
        $urlPago     = null;
        if($row->pago_cancelado){
          $urlShowToCancel = null;
        }else{
          $urlShowToCancel = route('pagocolegiaturas.showpaytocancel',['id' => $row->id]);
        }

        return view('_columnsDT',[
          'cicloEnroll' => $cicloEnroll,
          'groupEnroll' => $groupEnroll,
          'urlHoja'     => $urlHoja,
          'urlRecibo'   => $urlRecibo,
          'urlPago'     => $urlPago,
          'urlShowToCancel' => $urlShowToCancel
        ]);
      })
      ->make(true);
  }

  public function inscripcionesPorFecha($fecha){
    $rows = DB::table('alumnos')
      ->join('pago_inscripciones', 'alumnos.id','=', 'pago_inscripciones.alumno_id')
      ->join('escuelas', 'pago_inscripciones.escuela_id','=','escuelas.id')
      ->join('ciclos', 'pago_inscripciones.ciclo_id','=','ciclos.id')
      ->join('grados','pago_inscripciones.grado_id','=','grados.id')
      ->join('grupos','pago_inscripciones.grupo_id','=','grupos.id')
      ->select('pago_inscripciones.id', 'pago_inscripciones.inscripcion_id', 'pago_inscripciones.folio_recibo')
      ->addSelect('pago_inscripciones.importe_cuota','pago_inscripciones.porcentaje_descuento')
      ->addSelect('pago_inscripciones.cantidad_recibida_mxn','pago_inscripciones.pago_cancelado')
      ->addSelect('pago_inscripciones.fecha_cancelacion', 'pago_inscripciones.fecha')
      ->addSelect( 'alumnos.nombre1','alumnos.nombre2','alumnos.apellido1', 'alumnos.apellido2')
      ->addSelect('escuelas.nombre as escuela', 'ciclos.periodo')
      ->addSelect('grados.nombre as grado', 'grupos.nombre as grupo')
      ->whereDate('fecha', $fecha)
      ->orderBy('pago_inscripciones.folio_recibo', 'asc')
      ->get();

    return DataTables::of($rows)
      ->addColumn('ciclo', function($row){
        return $row->periodo;
      })
      ->addColumn('cuota', function($row){
       return '$ '.number_format($row->importe_cuota,2,'.',',');
      })
      ->addColumn('nombregrupo', function($row){
        return $row->grupo;
      })
      ->make(true);
  }

  public function categorias()
  {
    $categorias = Categoria::all();
    return DataTables::of($categorias)
      ->addColumn('actions', function ($categoria) {
        $showUrl = route('categorias.show', ['id' => $categoria->id]);
        $editUrl = route('categorias.edit', ['id' => $categoria->id]);
        $deleteUrl = route('categorias.destroy', ['id' => $categoria->id]);
        return view('_formActions', compact('showUrl', 'editUrl', 'deleteUrl'));
      })
      ->make(true);
  }

  /* Select para mostrar las subcategorias de los productos*/
  public function selectChilds($parent_id)
  {
    /*Relacion ESCUELA:GRADOS: 1:M*/
    $childs = Categoria::find($parent_id)->childs()
      ->select(['id as value', 'nombre as text'])->get()->toArray();

    array_unshift($childs, ['value' => '', 'text' => '']);

    return $childs;
  }

  public function dtProductos(){
    $escuela = 1;
    $ciclo = 2;
    $categoria = 1;
    $subcategoria = 3;

    $productos = DB::table('productos')
      ->join('ciclos','productos.ciclo_id','=','ciclos.id')
      ->select('productos.*','ciclos.periodo')
      ->where([
      ['escuela_id', '=', $escuela],
      ['ciclo_id', '=', $ciclo],
      ['categoria_id', '=', $categoria],
      ['subcategoria_id', '=', $subcategoria]
    ])->get();
    return DataTables::of($productos)
      ->addColumn('actions', function ($producto) {
        $showUrl = route('productos.show', ['id' => $producto->id]);
        $editUrl = route('productos.edit', ['id' => $producto->id]);
        $deleteUrl = route('productos.destroy', ['id' => $producto->id]);
        return view('_formActions', compact('showUrl', 'editUrl', 'deleteUrl'));
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
