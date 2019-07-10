<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetallePagoColegiatura extends Model
{
  protected $table = 'detalle_pago_colegiaturas';
  protected $dates = [
    'fecha_pago',
    'created_at',
    'updated_at'
  ];
  protected $casts = [
    'pago_cancelado' => 'boolean',
    'fecha_pago'     => 'date:d-m-Y'
  ];
}
