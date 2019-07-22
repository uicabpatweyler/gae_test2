<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Config\Ciclo;
use App\Models\Config\Cuota;
use App\Models\Config\Escuela;
use App\Models\Config\Grado;
use App\Models\Config\MesDePago;
use App\Models\DetallePagoColegiatura;
use App\Models\Inscripcion;
use App\Models\Config\Grupo;
use App\Models\PagoColegiatura;
use App\Models\SerieFolio;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PagoColegiaturaController extends Controller
{
  /**
   * Mostrar el listado de alumnos disponibles por escuela y ciclo
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('pagos.colegiatura.index',[
      'escuelas' => Escuela::with('nivel')->get(),
      'ciclos' => Ciclo::orderBy('periodo','desc')->get()
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create(Inscripcion $inscripcion)
  {

    $grupo = Grupo::find($inscripcion->grupo_id);
    $cuota = Cuota::find($grupo->cuotacolegiatura_id);
    $meses = MesDePago::where('cuota_id',$cuota->id)->orderBy('orden', 'asc')->get();
    $arrayMeses=[];

    foreach ($meses as $mesdepago){
      $detallePago = DetallePagoColegiatura::where('escuela_id',$inscripcion->escuela_id)
        ->where('ciclo_id', $inscripcion->ciclo_id)
        ->where('alumno_id', $inscripcion->alumno_id)
        ->where('nombre_mes', $mesdepago->mes)
        ->where('pago_cancelado', false)
        ->get();
      if(!$detallePago->count()){
        $diffInDays = Carbon::now()->diffInDays($mesdepago->fecha2,false);
        $arrayMeses[]=[
          'orden' => $mesdepago->orden,
          'nombreMes' => $mesdepago->mes,
          'recargo' => $diffInDays < 0 ? $mesdepago->recargo : 0,
          'descuento' => $mesdepago->descuento,
          'cuota' => $cuota->cantidad
        ];
      }
    }
    return view('pagos.colegiatura.create', [
      'inscripcion' => $inscripcion,
      'escuela' => Escuela::find($inscripcion->escuela_id),
      'ciclo' => Ciclo::find($inscripcion->ciclo_id),
      'grado' => Grado::find($inscripcion->grado_id),
      'grupo' => $grupo,
      'alumno' => Alumno::find($inscripcion->alumno_id),
      'rows' => $arrayMeses,
      'recibo' => SerieFolio::where('tipo',2)->first(),
      'fecha' => Carbon::now()->format('d-m-Y')
    ]);
  }

  public function store(Request $request){
    $rowPago = tap(new PagoColegiatura([
      'escuela_id'            => $request->get('escuela_id'),
      'ciclo_id'              => $request->get('ciclo_id'),
      'alumno_id'             => $request->get('alumno_id'),
      'grupo_id'              => $request->get('grupo_id'),
      'grado_id'              => $request->get('grado_id'),
      'user_created'          => $request->get('user_created'),
      'serie_recibo'          => $request->get('serie_recibo'),
      'folio_recibo'          => $request->get('folio_recibo'),
      'fecha_pago'            => $request->get('fecha_pago'),
      'cancelado_por'         => 0,
      'moneda'                => 'MXN',
      'cantidad_recibida_mxn' => $request->get('cantidad_recibida_mxn'),
      'cantidad_recibida_usd' => 0,
      'usd_tipodecambio'      => 0,
      'forma_de_pago'         => '01'
    ]))->save();

    $rows = json_decode($request->get('rows_detallepago'), true);

    foreach ($rows as $row){
      tap(new DetallePagoColegiatura([
        'pago_id'              => $rowPago->id,
        'escuela_id'           => $request->get('escuela_id'),
        'ciclo_id'             => $request->get('ciclo_id'),
        'alumno_id'            => $request->get('alumno_id'),
        'grupo_id'             => $request->get('grupo_id'),
        'grado_id'             => $request->get('grado_id'),
        'orden_mes'            => $row['orden'],
        'nombre_mes'           => $row['mes'],
        'cantidad_concepto'    => 1,
        'importe_colegiatura'  => $row['cuota'],
        'porcentaje_recargo'   => $row['recargo'],
        'recargo_pesos'        => $row['cuota'] * ($row['recargo']/100),
        'porcentaje_descuento' => $row['descuento'],
        'descuento_pesos'      => $row['cuota'] * ($row['descuento']/100),
        'fecha_pago'           => $request->get('fecha_pago'),
        'pago_cancelado'       => 0
      ]))->save();
    }

    $folio = SerieFolio::where('tipo',2)->first();
    $folio->increment('folio');

    return response()
      ->json([
        'message'  => 'El pago se guardo correctamente con el folio '.$request->get('folio_recibo'),
        'urlRecibo' => route('print.recibo.colegiatura',['pago' => $rowPago->id])
      ]);
  }

  public function showPayToCancel(PagoColegiatura $pagoColegiatura){
    return view('pagos.colegiatura.cancel',[
      'pago' => $pagoColegiatura
    ]);
  }

  public function cancelarPagoColegiatura(Request $request, PagoColegiatura $pagoColegiatura){
    $pagoColegiatura->pago_cancelado = true;
    $pagoColegiatura->fecha_cancelacion = $request->get('fecha_cancelacion');
    $pagoColegiatura->cancelado_por = $request->get('cancelado_por');
    $pagoColegiatura->motivo_cancelacion = $request->get('motivo_cancelacion');
    $pagoColegiatura->save();

    DetallePagoColegiatura::where('pago_id', $pagoColegiatura->id)
      ->update(['pago_cancelado' => true]);

    return response()
      ->json([
        'message'  => 'El pago con el folio '.$pagoColegiatura->folio_recibo.' se cancelo correctamente',
        'location' => route('pagocolegiaturas.index')
      ]);
  }

  public function alumnosDeudores(){
    $meses = MesDePago::where('cuota_id',2)->orderBy('orden', 'asc')->get();
    $alumnos = Alumno::all();
    $deudores=[];

    foreach ($alumnos as $alumno){
      $count=0;
      $aux=[];
      foreach ($meses as $mes){
        $rows = DB::table('detalle_pago_colegiaturas')
          ->where('alumno_id', '=', $alumno->id)
          ->where('nombre_mes','=', $mes->mes)
          ->where('pago_cancelado','=',0)
          ->get();
        if(!$rows->count()) {
          ++$count;
          $aux[]=[
            'mes' => $mes->mes
          ];
        }
      }
      if($count!==0){
        $deudores[]=[
          'alumno_id' => $alumno->id,
          'nombre' => $alumno->full_name,
          'faltante' => $aux
        ];
      }
    }

    return response()
      ->json([
        'data' => $deudores
      ]);
  }
}
/*
DELETE FROM `pago_colegiaturas` WHERE `pago_colegiaturas`.`id` = 1889;
DELETE FROM `detalle_pago_colegiaturas` WHERE `detalle_pago_colegiaturas`.`pago_id` = 1889;

ALTER TABLE `pago_colegiaturas` AUTO_INCREMENT = 1889;
ALTER TABLE `detalle_pago_colegiaturas` AUTO_INCREMENT = 2461;

UPDATE `series_folios` SET `folio` = '1889', `created_at` = NULL WHERE `series_folios`.`id` = 3;
*/