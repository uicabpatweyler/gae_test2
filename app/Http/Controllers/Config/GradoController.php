<?php

namespace App\Http\Controllers\Config;

use App\Http\Requests\GradoRequest;
use App\Models\Config\Escuela;
use App\Models\Config\Grado;
use App\Http\Controllers\Controller;

class GradoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('grados.index',[
            'escuelas' => Escuela::with('nivel')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('grados.create',[
            'escuelas' => Escuela::with('nivel')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GradoRequest $request)
    {
        $grado = tap(new Grado($request->all()))->save();
        return response()
            ->json([
                'message'  => 'Los datos se han guardado correctamente',
                'location' => route('grados.index')
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Config\Grado  $grado
     * @return \Illuminate\Http\Response
     */
    public function show(Grado $grado)
    {
      //One To Many (Inverse) Escuelas:Grados
        return view('grados.show',[
          'grado'    => $grado,
          'escuela'  =>  Grado::find($grado->id)->escuela
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Config\Grado  $grado
     * @return \Illuminate\Http\Response
     */
    public function edit(Grado $grado)
    {
        return view('grados.edit',[
            'escuelas' => Escuela::with('nivel')->get(),
            'grado'    => $grado
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Config\Grado  $grado
     * @return \Illuminate\Http\Response
     */
    public function update(GradoRequest $request, Grado $grado)
    {
        $grado->update($request->all());
        return response()
            ->json([
                'message'  => 'Los datos se han actualizado correctamente',
                'location' => route('grados.index')
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Config\Grado  $grado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Grado $grado)
    {
        $grado->delete();
        return response()->json([
            'success' => true
        ]);
    }
}
