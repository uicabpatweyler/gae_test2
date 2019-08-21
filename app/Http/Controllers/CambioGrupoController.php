<?php

namespace App\Http\Controllers;

use App\Models\Config\Ciclo;
use App\Models\Config\Escuela;
use App\Models\Inscripcion;
use App\Models\Config\Grado;
use Illuminate\Http\Request;

class CambioGrupoController extends Controller
{
    public function index(){
      return view('cambiodegrupo.index',[
        'escuelas' => Escuela::with('nivel')->get(),
        'ciclos' => Ciclo::orderBy('periodo','desc')->get()
      ]);
    }

    public function create(Inscripcion $inscripcion){
      $escuela = $inscripcion->escuela;
      $ciclo = $inscripcion->ciclo;
      $grado = $inscripcion->grado;
      $grados = Grado::where('escuela_id',$inscripcion->escuela_id)->get();
      $grupo = $inscripcion->grupo;
      $alumno = $inscripcion->alumno;
      return view('cambiodegrupo.create',[
        'escuela' => $escuela,
        'ciclo'   => $ciclo,
        'grado'   => $grado,
        'grados' => $grados,
        'grupo'   => $grupo,
        'alumno'  => $alumno,
        'inscripcion' => $inscripcion
      ]);
    }

    public function store(Request $request){
      $inscripcion = Inscripcion::find($request->get('inscripcion_id'));
      $inscripcion->grado_id = $request->get('grado_id');
      $inscripcion->grupo_id = $request->get('grupo_id');
      $inscripcion->save();
      return response()
        ->json([
          'message'  => 'Los datos se han guardado correctamente',
          'location' => route('alumnos.cambiodegrupo.index')
        ]);
    }
}
