<?php

namespace App\Http\Controllers;

use App\Models\Inscripcion;
use Illuminate\Http\Request;
use App\Http\Requests\AlumnoRequest;
use App\Models\Alumno;

class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('alumnos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('alumnos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AlumnoRequest $request)
    {
      $alumno = tap(new Alumno($request->all()))->save();
      return response()
        ->json([
          'message'  => 'Los datos se han guardado correctamente',
          'location' => route('alumno.direccion.create',$alumno->id)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Alumno  $alumno
     * @return \Illuminate\Http\Response
     */
    public function show(Alumno $alumno)
    {
      $rows =Inscripcion::where('alumno_id', $alumno->id)
        ->join('escuelas', 'inscripciones.escuela_id','=','escuelas.id')
        ->join('ciclos', 'inscripciones.ciclo_id','=', 'ciclos.id')
        ->join('grados', 'inscripciones.grado_id', '=', 'grados.id')
        ->join('grupos', 'inscripciones.grupo_id', '=' , 'grupos.id')
        ->select('inscripciones.id','inscripciones.escuela_id','inscripciones.ciclo_id','inscripciones.grado_id')
        ->addSelect('inscripciones.grupo_id', 'inscripciones.infoalumno_id')
        ->addSelect('escuelas.nombre as escuela','ciclos.periodo', 'grados.nombre as grado', 'grupos.nombre as grupo')
        ->orderBy('ciclos.periodo', 'desc')
        ->get();

      return view('alumnos.show',[
        'alumno' => $alumno,
        'rows' => $rows
      ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Alumno  $alumno
     * @return \Illuminate\Http\Response
     */
    public function edit(Alumno $alumno)
    {
      return view('alumnos.edit',[
        'alumno' => $alumno
      ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Alumno  $alumno
     * @return \Illuminate\Http\Response
     */
    public function update(AlumnoRequest $request, Alumno $alumno)    {
      $alumno->update($request->all());
      return response()
        ->json([
          'message'  => 'Los datos se han guardado correctamente',
          'location' => route('alumnos.index')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Alumno  $alumno
     * @return \Illuminate\Http\Response
     */
    public function destroy(Alumno $alumno)
    {
      $alumno->delete();
      return response()->json([
        'success' => true
      ]);
    }
}
