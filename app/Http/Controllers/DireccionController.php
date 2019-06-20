<?php

namespace App\Http\Controllers;

use App\Http\Requests\DireccionAlumnoRequest;
use App\Models\Alumno;
use App\Models\DireccionAlumno;
use Illuminate\Support\Facades\DB;

class DireccionController extends Controller
{
    public function direccionAlumnoCreate(Alumno $alumno){
      return view('direccion.alumno_create',[
        'alumno' => $alumno,
        'estados'=> DB::table('estados')->select('id', 'estado_nombre')->get()
      ]);
    }

    public function direccionAlumnoStore(DireccionAlumnoRequest $request){
      $direccion = tap(new DireccionAlumno($request->all()))->save();
      return response()
        ->json([
          'message'  => 'Los datos se han guardado correctamente',
          'location' => ''
        ]);
    }
}
