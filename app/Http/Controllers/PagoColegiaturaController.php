<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Config\Ciclo;
use App\Models\Config\Cuota;
use App\Models\Config\Escuela;
use App\Models\Config\MesDePago;
use App\Models\DetallePagoColegiatura;
use App\Models\Inscripcion;
use App\Models\Config\Grupo;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
      'rows' => $arrayMeses
    ]);
    //return response()->json(['inscripcion' => $inscripcion, 'arrayMeses' => $arrayMeses]);
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
