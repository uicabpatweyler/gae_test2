<?php

namespace App\Http\Controllers;

use App\Models\InformacionAlumno;
use App\Models\InformacionTutor;
use App\Http\Requests\InfoTutorRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InfoTutorController extends Controller
{
    public function createDireccion(InformacionAlumno $informacionAlumno){
      return view('tutores.direccion.create',[
        'info' => $informacionAlumno,
        'estados'=> DB::table('estados')->select('id', 'estado_nombre')->get()
      ]);
    }

  public function storeDireccion(InfoTutorRequest $request){
    $infoTutor = tap(new InformacionTutor($request->all()))->save();
    return response()
      ->json([
        'message'  => 'Los datos se han guardado correctamente',
        'location' => route('tutor.telefonos.create', $infoTutor->id)
      ]);
  }

  public function createTelefonos(InformacionTutor $informacionTutor){
      return view('tutores.telefonos.create',[
        'infoTutor' => $informacionTutor,
        'infoAlumno' => InformacionAlumno::find($informacionTutor->alumno_id)
      ]);
  }

  public function updateTelefonos(Request $request, InformacionTutor $informacionTutor){
    $informacionTutor->update($request->except('_method','_token','btn_guardar'));
    return response()
      ->json([
        'message'  => 'Los datos se han guardado correctamente',
        'location' => route('tutor.infoadicional.create', $informacionTutor->id)
      ]);
  }

  public function createInfoAdicional(InformacionTutor $informacionTutor){
      return view('tutores.infoadicional.create',[
        'infoTutor' => $informacionTutor,
        'estados'=> DB::table('estados')->select('id', 'estado_nombre')->get()
      ]);
  }

  public function updateInfoAdicional(Request $request, InformacionTutor $informacionTutor){
    $informacionTutor->update($request->except('_method','_token','btn_guardar'));
    return response()
    ->json([
      'message'  => 'Los datos se han guardado correctamente',
      'location' => route('tutores.create')
    ]);
  }
}
