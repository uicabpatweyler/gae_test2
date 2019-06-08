<?php

namespace App\Http\Controllers\Config;

use App\Http\Requests\CicloRequest;
use App\Models\Config\Ciclo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CicloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('ciclos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ciclos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CicloRequest $request)
    {
        $ciclo = tap(new Ciclo($request->all()))->save();
        return response()
            ->json([
                'message'  => 'Los datos se han guardado correctamente',
                'location' => route('ciclos.show',$ciclo->id)
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Config\Ciclo  $ciclo
     * @return \Illuminate\Http\Response
     */
    public function show(Ciclo $ciclo)
    {
        return view('ciclos.show',compact('ciclo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Config\Ciclo  $ciclo
     * @return \Illuminate\Http\Response
     */
    public function edit(Ciclo $ciclo)
    {
        return view('ciclos.edit',compact('ciclo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Config\Ciclo  $ciclo
     * @return \Illuminate\Http\Response
     */
    public function update(CicloRequest $request, Ciclo $ciclo)
    {
        $ciclo->update($request->all());
        return response()
            ->json([
                'message'  => 'Los datos se han actualizado correctamente',
                'location' => route('ciclos.show',$ciclo->id)
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Config\Ciclo  $ciclo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ciclo $ciclo)
    {
        $ciclo->delete();
        return response()->json([
            'success' => true
        ]);
    }
}
