<?php

namespace App\Http\Controllers;

use App\Http\Requests\InfoAlumnoRequest;
use App\Models\Alumno;
use App\Models\InfoAlumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InfoAlumnoController extends Controller
{
  //Formulario para los datos de la direccion
  public function createDireccion(Alumno $alumno){
    return view('alumnos.direccion.create',[
      'alumno' => $alumno,
      'estados'=> DB::table('estados')->select('id', 'estado_nombre')->get()
    ]);
  }

  public function storeDireccion(InfoAlumnoRequest $request){
    $infoAlumno = tap(new InfoAlumno($request->all()))->save();
    return response()
      ->json([
        'message'  => 'Los datos se han guardado correctamente',
        'location' => route('alumno.infogeneral.create',$infoAlumno->id)
      ]);
  }
  //Formulario para los datos generales (telefonos, escuela y encuesta)
  public function createInfoGral($infoAlumno){
    return view('alumnos.infogeneral.create',[
      'infoAlumno' => InfoAlumno::find($infoAlumno)
    ]);
  }

  public function updateInfoGral(Request $request,$infoAlumno){
    $info = InfoAlumno::find($infoAlumno);
    $info->update($request->except('_method','_token','btn_guardar'));
    return response()
      ->json([
        'message'  => 'Los datos se han guardado correctamente',
        'location' => route('alumnos.create')
      ]);
  }
}
