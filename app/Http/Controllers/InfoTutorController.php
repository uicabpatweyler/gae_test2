<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Config\Ciclo;
use App\Models\Config\Escuela;
use App\Models\InformacionAlumno;
use App\Models\InformacionTutor;
use App\Http\Requests\InfoTutorRequest;
use App\Models\Tutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InfoTutorController extends Controller
{
  public function createDireccion(InformacionAlumno $informacionAlumno){
    return view('tutores.direccion.create',[
      'infoAlumno' => $informacionAlumno,
      'tutor' => Tutor::find($informacionAlumno->tutor_id),
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

  public function editDireccionTutor(InformacionTutor $informacionTutor){
    return view('tutores.direccion.edit',[
      'infoTutor' => $informacionTutor,
      'tutor' => Tutor::find($informacionTutor->tutor_id),
      'escuela' => Escuela::find($informacionTutor->escuela_id),
      'ciclo' => Ciclo::find($informacionTutor->ciclo_id),
      'alumno' => Alumno::find($informacionTutor->alumno_id),
      'estados'=> DB::table('estados')->select('id', 'estado_nombre')->get()
    ]);
  }

  public function updateDireccionTutor(InfoTutorRequest $request, InformacionTutor $informacionTutor){
    $informacionTutor->update($request->except('_method','_token','btn_guardar'));
    return response()
      ->json([
        'message'  => 'Los datos se han actualizado correctamente',
        'location' => route('tutores.index')
      ]);
  }

  public function createTelefonos(InformacionTutor $informacionTutor){
      return view('tutores.telefonos.create',[
        'infoTutor' => $informacionTutor,
        'tutor' => Tutor::find($informacionTutor->tutor_id),
        'infoAlumno' => InformacionAlumno::find($informacionTutor->alumno_id)
      ]);
  }

  public function editTelefonos(InformacionTutor $informacionTutor){
    return view('tutores.telefonos.edit',[
      'infoTutor' => $informacionTutor,
      'tutor' => Tutor::find($informacionTutor->tutor_id),
      'escuela' => Escuela::find($informacionTutor->escuela_id),
      'ciclo' => Ciclo::find($informacionTutor->ciclo_id),
      'alumno' => Alumno::find($informacionTutor->alumno_id)
    ]);
  }

  //Nuevo tutor, inscripcion de nuevo alumno
  public function updateTelefonos(Request $request, InformacionTutor $informacionTutor){
    $informacionTutor->update($request->except('_method','_token','btn_guardar'));
    return response()
      ->json([
        'message'  => 'Los datos se han guardado correctamente',
        'location' => route('tutor.infoadicional.create', $informacionTutor->id)
      ]);
  }

  //Editar datos de tutor existente en el sistema
  public function updateInfoTelefonos(Request $request, InformacionTutor $informacionTutor){
    $informacionTutor->update($request->except('_method','_token','btn_guardar'));
    return response()
      ->json([
        'message'  => 'Los datos se han actualizado correctamente',
        'location' => route('tutores.index')
      ]);
  }

  public function createInfoAdicional(InformacionTutor $informacionTutor){
      return view('tutores.infoadicional.create',[
        'infoTutor' => $informacionTutor,
        'tutor' => Tutor::find($informacionTutor->tutor_id),
        'estados'=> DB::table('estados')->select('id', 'estado_nombre')->get()
      ]);
  }

  public function editInfoAdicional(InformacionTutor $informacionTutor){
    return view('tutores.infoadicional.edit',[
      'infoTutor' => $informacionTutor,
      'tutor' => Tutor::find($informacionTutor->tutor_id),
      'escuela' => Escuela::find($informacionTutor->escuela_id),
      'ciclo' => Ciclo::find($informacionTutor->ciclo_id),
      'alumno' => Alumno::find($informacionTutor->alumno_id),
      'estados'=> DB::table('estados')->select('id', 'estado_nombre')->get()
    ]);
  }

  public function updateInfoAdicional(Request $request, InformacionTutor $informacionTutor){
    $informacionTutor->update($request->except('_method','_token','btn_guardar'));
    return response()
    ->json([
      'message'  => 'Los datos se han guardado correctamente',
      'location' => route('inscripciones.index')
    ]);
  }

  public function patchInfoAdicional(Request $request, InformacionTutor $informacionTutor){
    $informacionTutor->update($request->except('_method','_token','btn_guardar'));
    return response()
      ->json([
        'message'  => 'Los datos se han guardado correctamente',
        'location' => route('tutores.index')
      ]);
  }

  public function show(InformacionTutor $informacionTutor){
    return view('tutores.showInfo',[
      'infoTutor' => $informacionTutor,
      'tutor' => Tutor::find($informacionTutor->tutor_id),
      'escuela' => Escuela::find($informacionTutor->escuela_id),
      'ciclo' => Ciclo::find($informacionTutor->ciclo_id),
      'alumno' => Alumno::find($informacionTutor->alumno_id),
      'estados'=> DB::table('estados')->select('id', 'estado_nombre')->get()
    ]);
  }


}
