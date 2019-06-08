<?php

namespace App\Http\Controllers\Config;

use App\Http\Requests\GradoRequest;
use App\Models\Config\Ciclo;
use App\Models\Config\Escuela;
use App\Models\Config\Grado;
use Illuminate\Http\Request;
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
        return view('grados.create',[
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Config\Grado  $grado
     * @return \Illuminate\Http\Response
     */
    public function edit(Grado $grado)
    {
        //
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
        //
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
