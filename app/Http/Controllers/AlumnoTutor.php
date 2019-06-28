<?php

namespace App\Http\Controllers;

use App\Models\InformacionAlumno;
use App\Models\Tutor;
use Illuminate\Http\Request;

class AlumnoTutor extends Controller
{
    public function tutorElegirAlumno(Tutor $tutor){
      $info = InformacionAlumno::with('alumno')
        ->where('tutor_id','=',0)
        ->get();
      return view('tutores.elegir_alumno',[
        'tutor'   => $tutor,
        'alumnos' => $info
      ]);
    }

    public function asignarTutorAlumno(Request $request){
      $filaInfoAlumno = InformacionAlumno::find($request->id_row);
      $filaInfoAlumno->tutor_id = $request->tutor_id;
      $filaInfoAlumno->save();
      return response()
        ->json([
          'message'  => 'Los datos se han guardado correctamente',
          'location' => route('tutor.direccion.create', $filaInfoAlumno->id)
        ]);
    }
}
