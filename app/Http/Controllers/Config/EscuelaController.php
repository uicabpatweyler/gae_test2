<?php

namespace App\Http\Controllers\Config;

use App\Http\Requests\EscuelaRequest;
use App\Models\Admin\Nivel;
use App\Models\Admin\Tipo;
use App\Models\Config\Escuela;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EscuelaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('escuelas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('escuelas.create',[
            'tipos' => Tipo::orderBy('id','asc')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EscuelaRequest $request)
    {
        $escuela = tap(new Escuela($request->all()))->save();
        return response()
            ->json([
                'message'  => 'Los datos se han guardado correctamente',
                'location' => route('escuelas.index')
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Config\Escuela  $escuela
     * @return \Illuminate\Http\Response
     */
    public function show(Escuela $escuela)
    {
        return view('escuelas.show',compact('escuela'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Config\Escuela  $escuela
     * @return \Illuminate\Http\Response
     */
    public function edit(Escuela $escuela)
    {
        return view('escuelas.edit',[
            'escuela'   => $escuela,
            'tipos'     => Tipo::orderBy('id','asc')->get(),
            'niveles'   => Tipo::find($escuela->tipo_id)->niveles,   /*TIPOS:NIVELES*/
            'servicios' => Nivel::find($escuela->nivel_id)->servicios /*NIVELES:SERVICIOS*/
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Config\Escuela  $escuela
     * @return \Illuminate\Http\Response
     */
    public function update(EscuelaRequest $request, Escuela $escuela)
    {
        $escuela->update($request->all());
        return response()
            ->json([
                'message'  => 'Los datos se han actualizado correctamente',
                'location' => route('escuelas.show',$escuela->id)
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Config\Escuela  $escuela
     * @return \Illuminate\Http\Response
     */
    public function destroy(Escuela $escuela)
    {
        $escuela->delete();
        return response()->json([
            'success' => true
        ]);
    }
}
