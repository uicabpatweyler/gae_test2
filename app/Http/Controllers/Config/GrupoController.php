<?php

namespace App\Http\Controllers\Config;

use App\Http\Requests\GrupoRequest;
use App\Models\Config\Ciclo;
use App\Models\Config\Escuela;
use App\Models\Config\Grado;
use App\Models\Config\Grupo;
use App\Http\Controllers\Controller;

class GrupoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('grupos.index',[
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
        return view('grupos.create',[
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
    public function store(GrupoRequest $request)
    {
      $grupo = tap(new Grupo($request->all()))->save();
      return response()
        ->json([
          'message'  => 'Los datos se han guardado correctamente',
          'location' => route('grupos.show',$grupo->id)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Config\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function show(Grupo $grupo)
    {
        return view('grupos.show',[
          'grupo' => $grupo,
          'escuela' => Escuela::find($grupo->escuela_id),
          'ciclo' => Ciclo::find($grupo->ciclo_id),
          'grado' => Grado::find($grupo->grado_id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Config\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function edit(Grupo $grupo)
    {
        return view('grupos.edit',[
          'escuelas' => Escuela::with('nivel')->get(),
          'grados'   => Escuela::find($grupo->escuela_id)->grados()->get(),
          'ciclos'   => Ciclo::orderBy('periodo','desc')->get(),
          'grupo'    => $grupo
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Config\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function update(GrupoRequest $request, Grupo $grupo)
    {
      $grupo->update($request->all());
      return response()
        ->json([
          'message'  => 'Los datos se han actualizado correctamente',
          'location' => route('grupos.show',$grupo->id)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Config\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Grupo $grupo)
    {
      $grupo->delete();
      return response()->json([
        'success' => true
      ]);
    }
}
