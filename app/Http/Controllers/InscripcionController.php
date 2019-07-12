<?php

namespace App\Http\Controllers;

use App\Http\Requests\InscripcionRequest;
use App\Models\Alumno;
use App\Models\Config\Ciclo;
use App\Models\Config\Escuela;
use App\Models\InformacionAlumno;
use App\Models\InformacionTutor;
use App\Models\Inscripcion;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InscripcionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('inscripciones.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(InformacionAlumno $informacionAlumno)
    {
        return view('inscripciones.create',[
          'escuelas' => Escuela::with('nivel')->get(),
          'ciclos' => Ciclo::orderBy('periodo','desc')->get(),
          'alumno' => Alumno::find(($informacionAlumno->alumno_id)),
          'fecha' => Carbon::now()->format('d-m-Y'),
          'info' => $informacionAlumno
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InscripcionRequest $request)
    {
        $inscripcion = tap( new Inscripcion($request->all()) )->save();
        InformacionAlumno::where('id',$request->get('infoalumno_id'))
          ->update([
            'escuela_id' => $request->get('escuela_id'),
            'ciclo_id' => $request->get('ciclo_id')
          ]);
        InformacionTutor::where('infoalumno_id', $request->get('infoalumno_id'))
          ->update([
            'escuela_id' => $request->get('escuela_id'),
            'ciclo_id' => $request->get('ciclo_id')
          ]);
        Alumno::where('id',$request->get('infoalumno_id'))
          ->update([
            'created_at' => (new Carbon($request->get('fecha')))->format('Y-m-d').' '.Carbon::now()->toTimeString(),
            'updated_at' => (new Carbon($request->get('fecha')))->format('Y-m-d').' '.Carbon::now()->toTimeString()
          ]);
      return response()
        ->json([
          'message'  => 'Los datos se han guardado correctamente',
          'location' => route('pagos_inscripcion.create', $inscripcion->id)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
