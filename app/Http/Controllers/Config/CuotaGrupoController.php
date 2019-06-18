<?php

namespace App\Http\Controllers\Config;

use App\Models\Config\Ciclo;
use App\Models\Config\Cuota;
use App\Models\Config\Escuela;
use App\Models\Config\Grupo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CuotaGrupoController extends Controller
{
  public function show(Cuota $cuota){
    return view('cuotagrupo.show', [
      'escuela' => Escuela::find($cuota->escuela_id),
      'ciclo'   => Ciclo::find($cuota->ciclo_id),
      'cuota'   => $cuota,
      'grados'  => Escuela::find($cuota->escuela_id)->grados()->get()
    ]);
  }

  public function cuotaGrupo(Cuota $cuota, Request $request)
  {
    if($cuota->tipo === 1){
      Grupo::where('escuela_id',$cuota->escuela_id)
        ->where('ciclo_id', $cuota->ciclo_id)
        ->where('grado_id', $request->get('grado_id'))
        ->update(['cuotainscripcion_id' => $cuota->id]);
    }
    else{
      Grupo::where('escuela_id',$cuota->escuela_id)
        ->where('ciclo_id', $cuota->ciclo_id)
        ->where('grado_id', $request->get('grado_id'))
        ->update(['cuotacolegiatura_id' => $cuota->id]);
    }

    return response()
      ->json([
        'message'  => 'La cuota de pago se aplico de manera correcta',
        'location' => ''
      ]);

  }

}
