<?php

namespace App\Http\Controllers;

use App\Models\Config\Categoria;
use App\Models\Config\Ciclo;
use App\Models\Config\Escuela;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('productos.index',[
          'escuelas' => Escuela::with('nivel')->get(),
          'ciclos' => Ciclo::orderBy('periodo','desc')->get(),
          'categorias' => Categoria::where('parent_id',0)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('productos.create',[
          'escuelas' => Escuela::with('nivel')->get(),
          'ciclos' => Ciclo::orderBy('periodo','desc')->get(),
          'categorias' => Categoria::where('parent_id', '=', 0)->get()
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
      $producto = tap(new Producto($request->all()))->save();
      return response()
        ->json([
          'message'  => 'Los datos se han guardado correctamente',
          'location' => route('productos.index')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit(Producto $producto)
    {
        return view('productos.edit',[
          'producto' => $producto,
          'escuelas' => Escuela::with('nivel')->get(),
          'ciclos' => Ciclo::orderBy('periodo','desc')->get(),
          'categorias' => Categoria::where('parent_id',0)->get(),
          'subcategorias' => Categoria::where('parent_id', $producto->categoria_id)->get(),
          'clasificaciones' => Categoria::where('parent_id', $producto->subcategoria_id)->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto)
    {
      $producto->update($request->all());
      return response()
        ->json([
          'message'  => 'Los datos se han actualizado correctamente',
          'location' => route('productos.index')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producto $producto)
    {
        //
    }
}
