<?php

namespace App\Http\Controllers;

use App\Http\Requests\TutorRequest;
use App\Models\InformacionTutor;
use App\Models\Tutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TutorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tutores.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('tutores.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TutorRequest $request)
    {
        $tutor = tap(new Tutor($request->all()))->save();
        return response()
          ->json([
            'message'  => 'Los datos se han guardado correctamente',
            'location' => route('tutor.elegir.alumno',$tutor->id)
          ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tutor  $tutor
     * @return \Illuminate\Http\Response
     */
    public function show(Tutor $tutor)
    {
      $rows = InformacionTutor::where('tutor_id', $tutor->id)
        ->join('escuelas', 'informacion_tutores.escuela_id','=','escuelas.id')
        ->join('ciclos', 'informacion_tutores.ciclo_id','=', 'ciclos.id')
        ->join('alumnos', 'informacion_tutores.alumno_id', '=', 'alumnos.id')
        ->select('informacion_tutores.id as infotutor_id','escuelas.nombre as escuela', 'ciclos.periodo', 'alumnos.id as alumno_id')
        ->addSelect(DB::raw("CONCAT(alumnos.nombre1,' ',alumnos.nombre2,' ', alumnos.apellido1, ' ', alumnos.apellido2)  AS alumno"))
        ->orderBy('ciclos.periodo', 'desc')
        ->get();

      return view('tutores.show',[
        'tutor' => $tutor,
        'rows' => $rows
      ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tutor  $tutor
     * @return \Illuminate\Http\Response
     */
    public function edit(Tutor $tutor)
    {
        return view('tutores.edit', [
          'tutor' => $tutor
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tutor  $tutor
     * @return \Illuminate\Http\Response
     */
    public function update(TutorRequest $request, Tutor $tutor)
    {
      $tutor->update($request->all());
      return response()
        ->json([
          'message'  => 'Los datos se han actualizado correctamente',
          'location' => route('tutores.show', ['id' => $tutor->id])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tutor  $tutor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tutor $tutor)
    {
        //
    }
}
