<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class PagoColegiatura extends Model
{
  protected $table = 'pago_colegiaturas';
  protected $dates = [
    'fecha_pago',
    'fecha_cancelacion',
    'created_at',
    'updated_at'
  ];
  protected $casts = [
    'fecha_pago'        => 'date:d-m-Y',
    'pago_cancelado'    => 'boolean',
    'cancelado_por'     => 'boolean',
    'fecha_cancelacion' => 'date:d-m-Y'
  ];
  protected $fillable = [
    'escuela_id',
    'ciclo_id',
    'alumno_id',
    'grupo_id',
    'grado_id',
    'user_created',
    'serie_recibo',
    'folio_recibo',
    'fecha_pago',
    'pago_cancelado',
    'fecha_cancelacion',
    'cancelado_por',
    'motivo_cancelacion',
    'moneda',
    'cantidad_recibida_mxn',
    'cantidad_recibida_usd',
    'usd_tipodecambio',
    'forma_de_pago',
    'referencia_pago',
    'tipo_tarjeta'
  ];

  public function setSerieReciboAttribute($value){
    if(isset($value)){
      $this->attributes['serie_recibo'] = $value;
    }
    else{
      $this->attributes['serie_recibo'] = null;
    }
  }

  public function setFechaPagoAttribute($value){
    $this->attributes['fecha_pago'] = (new Carbon($value))->format('Y-m-d');
  }

  public function setPagoCanceladoAttribute($value){
    if(isset($value)){
      $this->attributes['pago_cancelado'] = $value;
    }
    else{
      $this->attributes['pago_cancelado'] = false;
    }
  }

  public function setFechaCancelacionAttribute($value){
    if(isset($value)){
      $this->attributes['fecha_cancelacion'] = (new Carbon($value))->format('Y-m-d');
    }
    else{
      $this->attributes['fecha_cancelacion'] = null;
    }
  }

  public function setCanceladoPorAttribute($value){
    if(isset($value)){
      $this->attributes['cancelado_por'] = $value;
    }
    else{
      $this->attributes['cancelado_por'] = 0;
    }
  }

  public function setMotivoCancelacionAttribute($value){
    if(isset($value)){
      $this->attributes['motivo_cancelacion'] = $value;
    }
    else{
      $this->attributes['cancelado_por'] = null;
    }
  }

  public function setMonedaAttribute($value){
    if(isset($value)){
      $this->attributes['moneda'] = $value;
    }
    else{
      $this->attributes['moneda'] = 'MXN';
    }
  }

  public function setCantidadRecibidaUsdAttribute($value){
    if(isset($value)){
      $this->attributes['cantidad_recibida_usd'] = $value;
    }
    else{
      $this->attributes['cantidad_recibida_usd'] = 0;
    }
  }

  public function setUsdTipodecambioAttribute($value){
    if(isset($value)){
      $this->attributes['usd_tipodecambio'] = $value;
    }
    else{
      $this->attributes['usd_tipodecambio'] = 0;
    }
  }

  public function setFormaDePagoAttribute($value){
    if(isset($value)){
      $this->attributes['forma_de_pago'] = $value;
    }
    else{
      $this->attributes['forma_de_pago'] = '01';
    }
  }

  public function setReferenciaPagoAttribute($value){
    if(isset($value)){
      $this->attributes['referencia_pago'] = $value;
    }
    else{
      $this->attributes['referencia_pago'] = null;
    }
  }

  public function setTipoTarjetaAttribute($value){
    if(isset($value)){
      $this->attributes['tipo_tarjeta'] = $value;
    }
    else{
      $this->attributes['tipo_tarjeta'] = null;
    }
  }
}
