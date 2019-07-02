<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Config\Ciclo;
use App\Models\Config\Cuota;
use App\Models\Config\Escuela;
use App\Models\Config\Grado;
use App\Models\Config\Grupo;
use App\Models\Inscripcion;
use App\Models\PagoInscripcion;
use App\Models\SerieFolio;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PagoInscripcionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Inscripcion $inscripcion)
    {
        return view('pagos.inscripcion.create',[
          'inscripcion' => $inscripcion,
          'escuela' => Escuela::find($inscripcion->escuela_id),
          'ciclo' => Ciclo::find($inscripcion->ciclo_id),
          'grado' => Grado::find($inscripcion->grado_id),
          'grupo' => Grupo::find($inscripcion->grupo_id),
          'cuota' => Grupo::find($inscripcion->grupo_id)->inscripcion,
          'alumno' => Alumno::find($inscripcion->alumno_id),
          'recibo' => SerieFolio::where('tipo',1)->first()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $pago = tap(new PagoInscripcion($request->all()))->save();

      Inscripcion::where('id',$request->inscripcion_id)
        ->update(['pago_id' => $pago->id]);

      $folio = SerieFolio::where('tipo',1)->first();
      $folio->increment('folio');

      //return redirect(route('inscripciones.index'));
      return response()
        ->json([
          'message'  => 'Los datos del pago se han guardado correctamente.',
          'urlRecibo' => route('print.recibo.inscripcion', $pago->id),
          'urlHoja'   => route('print.hoja.inscripcion', $request->inscripcion_id)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PagoInscripcion  $pagoInscripcion
     * @return \Illuminate\Http\Response
     */
    public function show(PagoInscripcion $pagoInscripcion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PagoInscripcion  $pagoInscripcion
     * @return \Illuminate\Http\Response
     */
    public function edit(PagoInscripcion $pagoInscripcion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PagoInscripcion  $pagoInscripcion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PagoInscripcion $pagoInscripcion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PagoInscripcion  $pagoInscripcion
     * @return \Illuminate\Http\Response
     */
    public function destroy(PagoInscripcion $pagoInscripcion)
    {
        //
    }
}
