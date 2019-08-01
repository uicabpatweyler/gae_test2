<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class SalidaProducto extends Model
{
  protected $table = 'salida_productos';
  protected $fillable = [
    'escuela_id',
    'ciclo_id',
    'alumno_id',
    'grupo_id',
    'user_created',
    'serie_recibo',
    'folio_recibo',
    'fecha_venta',
    'cancelado_por',
    'moneda',
    'cantidad_recibida_mxn',
    'cantidad_recibida_usd',
    'usd_tipodecambio',
    'forma_de_pago'
  ];
  protected $dates = [
    'fecha_venta',
    'fecha_cancelacion',
    'created_at',
    'updated_at'
  ];
  protected $casts = [
    'fecha_venta'        => 'date:d-m-Y',
    'fecha_cancelacion' => 'date:d-m-Y',
    'venta_cancelada'    => 'boolean'
  ];

  public function setSerieReciboAttribute($value){
    if(isset($value)){
      $this->attributes['serie_recibo'] = $value;
    }
    else{
      $this->attributes['serie_recibo'] = null;
    }
  }

  public function setFechaVentaAttribute($value){
    $this->attributes['fecha_venta'] = (new Carbon($value))->format('Y-m-d');
  }

}
