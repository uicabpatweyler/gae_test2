<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class DetalleSalidaProducto extends Model
{
  protected $table = 'detalle_salida_productos';
  protected $fillable = [
    'salidaprod_id',
    'escuela_id',
    'ciclo_id',
    'alumno_id',
    'grupo_id',
    'user_id',
    'numero_linea',
    'categoria_id',
    'producto_id',
    'precio_unitario',
    'cantidad',
    'fecha_venta'
  ];
  protected $dates = [
    'fecha_venta',
    'created_at',
    'updated_at'
  ];
  protected $casts = [
    'fecha_venta'        => 'date:d-m-Y',
    'venta_cancelada'    => 'boolean'
  ];

  public function setFechaVentaAttribute($value){
    $this->attributes['fecha_venta'] = (new Carbon($value))->format('Y-m-d');
  }
}
