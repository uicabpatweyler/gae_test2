<?php

namespace App\Http\Controllers\config;

use App\Http\Requests\CategoriaRequest;
use App\Models\Config\Categoria;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $categorias = Categoria::where('parent_id','=',0)->get();
      return view('categorias.index',compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categorias.create');
    }

    public function createChild($parent_id)
    {
      return view('categorias.create_child',compact('parent_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriaRequest $request)
    {
      $categoria = tap(new Categoria($request->all()))->save();
      return response()
        ->json([
          'message'  => 'Los datos se han guardado correctamente',
          'location' => route('categorias.show', ['id' => $categoria->id])
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Config\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function show(Categoria $categoria)
    {
        return view('categorias.show',compact('categoria'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Config\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function edit(Categoria $categoria)
    {
        return view('categorias.edit',compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Config\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(CategoriaRequest $request, Categoria $categoria)
    {
        $categoria->update($request->all());
      return response()
        ->json([
          'message'  => 'Los datos se han actualizado correctamente',
          'location' => route('categorias.show',$categoria->id)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Config\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categoria $categoria)
    {
        //
    }
}
