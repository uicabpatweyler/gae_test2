<?php

namespace App\Http\Controllers\Config;

use App\Models\Config\Ciclo;
use App\Models\Config\Cuota;
use App\Models\Config\Escuela;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CuotaGrupoController extends Controller
{
    public function updateCuotaGrupo(Cuota $cuota){
      return view('cuotagrupo.show',[
        'escuela' => Escuela::find($cuota->escuela_id),
        'ciclo' => Ciclo::find($cuota->ciclo_id),
        'cuota'  => $cuota
      ]);
    }

    public function test(Request $request){
      foreach ($request->get('grados') as $key => $value) {
        echo $value . "<br />";
      }
      return dd($request->all());
    }
}
