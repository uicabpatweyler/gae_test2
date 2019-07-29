<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Config\Categoria;
use App\Models\Config\Ciclo;
use App\Models\Config\Escuela;
use App\Models\Config\Grado;
use App\Models\Config\Grupo;
use App\Models\DetalleSalidaProducto;
use App\Models\Inscripcion;
use App\Models\SalidaProducto;
use App\Models\SerieFolio;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('venta.index',[
        'escuelas' => Escuela::with('nivel')->get(),
        'ciclos' => Ciclo::orderBy('periodo','desc')->get()
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($inscripcion)
    {
      $datosInscripcion = Inscripcion::find($inscripcion);
      $alumno = Alumno::find($datosInscripcion->alumno_id);
      $grado = Grado::find($datosInscripcion->grado_id);
      $grupo = Grupo::find($datosInscripcion->grupo_id);
      return view('venta.create',[
        'escuela' => Escuela::find($datosInscripcion->escuela_id),
        'ciclo' => Ciclo::find($datosInscripcion->ciclo_id),
        'alumno' => $alumno,
        'inscripcion' => $datosInscripcion,
        'grado' => $grado,
        'grupo' => $grupo,
        'recibo' => SerieFolio::where('tipo',4)->first(),
        'fecha' => Carbon::now()->format('d-m-Y'),
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
      $rowVenta = tap(new SalidaProducto([
        'escuela_id'            => $request->get('escuela_id'),
        'ciclo_id'              => $request->get('ciclo_id'),
        'alumno_id'             => $request->get('alumno_id'),
        'grupo_id'              => $request->get('grupo_id'),
        'user_created'          => $request->get('user_created'),
        'serie_recibo'          => $request->get('serie_recibo'),
        'folio_recibo'          => $request->get('folio_recibo'),
        'fecha_venta'           => $request->get('fecha_venta'),
        'venta_cancelada'       => false,
        'fecha_cancelacion'     => null,
        'cancelado_por'         => 0,
        'motivo_cancelacion'    => null,
        'moneda'                => 'MXN',
        'cantidad_recibida_mxn' => $request->get('cantidad_recibida_mxn'),
        'cantidad_recibida_usd' => 0,
        'usd_tipodecambio'      => 0,
        'forma_de_pago'         => '01'
      ]))->save();

      $rows = json_decode($request->get('rows_salida'), true);

      foreach ($rows as $row){
        tap(new DetalleSalidaProducto([
          'salidaprod_id' => $rowVenta->id,
          'escuela_id'    => $request->get('escuela_id'),
          'ciclo_id'      => $request->get('ciclo_id'),
          'alumno_id'     => $request->get('alumno_id'),
          'grupo_id'      => $request->get('grupo_id'),
          'user_id'       => $request->get('user_created'),
          'numero_linea'  => $row['numero_linea'],
          'categoria_id'  => $row['categoria'],
          'producto_id'   => $row['producto'],
          'precio_unitario'  => $row['precio_unitario'],
          'cantidad'      => $row['cantidad'],
          'fecha_venta'   => $request->get('fecha_venta')
        ]))->save();

       $productKardex = DB::table('kardex')
         ->where([
           ['escuela_id', '=', $request->get('escuela_id')],
           ['ciclo_id', '=', $request->get('ciclo_id')],
           ['producto_id', '=', $row['producto']]
         ])
         ->limit(1);
       $productKardex->decrement('existencia',$row['cantidad']);
       $productKardex->increment('salidas',$row['cantidad']);

      }

      $folio = SerieFolio::where('tipo',4)->first();
      $folio->increment('folio');

      return response()
        ->json([
          'message'  => 'La venta se realizo correctamente con el folio '.$request->get('folio_recibo'),
          'urlRecibo' => route('print.reciboventa',['salidaProducto' => $rowVenta->id])
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
