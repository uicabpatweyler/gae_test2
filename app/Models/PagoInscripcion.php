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
    'created_at',
    'updated_at',
  ];

  protected $dates = [
    'deleted_at',
    'created_at',
    'updated_at',
    'fecha'
  ];
  protected $casts = [
    'status'   => 'boolean',
    'fecha' => 'date:d-m-Y',
  ];

  public function setFechaAttribute($value){
    $this->attributes['fecha'] = (new Carbon($value))->format('y-m-d');
  }
}
