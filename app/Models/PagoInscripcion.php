<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PagoInscripcion extends Model
{
  use SoftDeletes;
  protected $table = 'pago_inscripciones';
  protected $fillable = [
    'inscripcion_id',
    'escuela_id',
    'ciclo_id',
    'grado_id',
    'grupo_id',
    'alumno_id',
    'user_id',
    'serie_recibo',
    'folio_recibo',
    'cantidad_concepto',
    'importe_cuota',
    'cantidad_recibida_mxn',
    'fecha',
    'user_created',
    'user_updated',
    'created_at',
    'updated_at'
  ];

  protected $dates = [
    'deleted_at',
    'created_at',
    'updated_at',
    'fecha',
    'fecha_cancelacion'
  ];
  protected $casts = [
    'status'   => 'boolean',
    'pago_cancelado' => 'boolean',
    'fecha' => 'date:d-m-Y',
    'fecha_cancelacion' => 'date:d-m-Y'
  ];

  public function setFechaAttribute($value){
    if(isset($value)){
      $this->attributes['fecha'] = (new Carbon($value))->format('Y-m-d');
    }
    else{
      $this->attributes['fecha'] = Carbon::now()->format('Y-m-d');
    }

  }

  public function setUserCreatedAttribute($value){
    if(isset($value)){
      $this->attributes['user_created'] = $value;
    }
    else{
      $this->attributes['user_created'] = 0;
    }
  }

  public function setUserUpdatedAttribute($value){
    if(isset($value)){
      $this->attributes['user_updated'] = $value;
    }
    else{
      $this->attributes['user_updated'] = 0;
    }
  }

  public function setCreatedAtAttribute($value){
    if(isset($value)){
      $this->attributes['created_at'] = $value;
    }
    else{
      $this->attributes['created_at'] = Carbon::now()->format('Y-m-d').' '.Carbon::now()->toTimeString();
    }
  }

  public function setUpdatedAtAttribute($value){
    if(isset($value)){
      $this->attributes['updated_at'] = $value;
    }
    else{
      $this->attributes['updated_at'] = Carbon::now()->format('Y-m-d').' '.Carbon::now()->toTimeString();
    }
  }
}
