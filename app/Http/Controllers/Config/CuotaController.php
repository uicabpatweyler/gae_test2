<?php

namespace App\Http\Controllers\Config;

use App\Http\Requests\CuotaRequest;
use App\Models\Config\Ciclo;
use App\Models\Config\Cuota;
use App\Models\Config\Escuela;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CuotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cuotas.index',[
            'escuelas' => Escuela::with('nivel')->get(),
            'ciclos' => Ciclo::orderBy('periodo','desc')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cuotas.create',[
            'escuelas' => Escuela::with('nivel')->get(),
            'ciclos' => Ciclo::orderBy('periodo','desc')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CuotaRequest $request)
    {
        $cuota = tap(new Cuota($request->all()))->save();
        return response()
            ->json([
                'message'  => 'Los datos se han guardado correctamente',
                'location' => route('cuotas.show',$cuota->id)
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Config\Cuota  $cuota
     * @return \Illuminate\Http\Response
     */
    public function show(Cuota $cuota)
    {
        return view('cuotas.show', [
            'escuela' => Escuela::find($cuota->escuela_id),
            'ciclo' => Ciclo::find($cuota->ciclo_id),
            'cuota' => $cuota
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Config\Cuota  $cuota
     * @return \Illuminate\Http\Response
     */
    public function edit(Cuota $cuota)
    {
        return view('cuotas.edit',[
            'escuelas' => Escuela::with('nivel')->get(),
            'ciclos' => Ciclo::orderBy('periodo','desc')->get(),
            'cuota' => $cuota
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Config\Cuota  $cuota
     * @return \Illuminate\Http\Response
     */
    public function update(CuotaRequest $request, Cuota $cuota)
    {
        $cuota->update($request->all());
        return response()
            ->json([
                'message'  => 'Los datos se han actualizado correctamente',
                'location' => route('cuotas.show',$cuota->id)
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Config\Cuota  $cuota
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cuota $cuota)
    {
        $cuota->delete();
        return response()->json([
            'success' => true
        ]);
    }
}
