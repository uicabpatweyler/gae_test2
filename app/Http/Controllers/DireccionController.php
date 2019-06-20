<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DireccionController extends Controller
{
    public function direccionAlumnoCreate(Alumno $alumno){
      return view('direccion.alumno_create',[
        'alumno' => $alumno,
        'estados'=> DB::table('estados')->select('id', 'estado_nombre')->get()
      ]);
    }
}
