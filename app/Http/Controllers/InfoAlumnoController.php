<?php

namespace App\Http\Controllers;

use App\Http\Requests\InfoAlumnoRequest;
use App\Models\Alumno;
use App\Models\InformacionAlumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InfoAlumnoController extends Controller
{
  //Formulario para los datos de la direccion, para un nuevo alumno, inscripcion de alumno nuevo
  public function createDireccion(Alumno $alumno){
    return view('alumnos.direccion.create',[
      'alumno' => $alumno,
      'estados'=> DB::table('estados')->select('id', 'estado_nombre')->get()
    ]);
  }

  public function storeDireccion(InfoAlumnoRequest $request){
    $infoAlumno = tap(new InformacionAlumno($request->all()))->save();
    return response()
      ->json([
        'message'  => 'Los datos se han guardado correctamente',
        'location' => route('alumno.infoadicional.create',$infoAlumno->id)
      ]);
  }

  //Formulario para los datos generales (telefonos, escuela y encuesta)
  public function createInfoGral(InformacionAlumno $informacionAlumno){
    return view('alumnos.infogeneral.create',[
      'infoAlumno' => $informacionAlumno,
      'alumno' => Alumno::find($informacionAlumno->alumno_id)
    ]);
  }

  public function updateInfoGral(Request $request,InformacionAlumno $informacionAlumno){
    $informacionAlumno->update($request->except('_method','_token','btn_guardar'));
    return response()
      ->json([
        'message'  => 'Los datos se han guardado correctamente',
        'location' => route('tutores.create')
      ]);
  }
}
