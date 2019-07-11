<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class DetallePagoColegiatura extends Model
{
  protected $table = 'detalle_pago_colegiaturas';
  protected $dates = [
    'fecha_pago',
    'created_at',
    'updated_at'
  ];
  protected $casts = [
    'fecha_pago'     => 'date:d-m-Y',
    'pago_cancelado' => 'boolean'
  ];

  protected $fillable = [
    'pago_id',
    'escuela_id',
    'ciclo_id',
    'alumno_id',
    'grupo_id',
    'grado_id',
    'orden_mes',
    'nombre_mes',
    'cantidad_concepto',
    'importe_colegiatura',
    'porcentaje_recargo',
    'recargo_pesos',
    'porcentaje_descuento',
    'descuento_pesos',
    'fecha_pago',
    'pago_cancelado'
  ];

  public function setFechaPagoAttribute($value){
    $this->attributes['fecha_pago'] = (new Carbon($value))->format('Y-m-d');
  }
}
