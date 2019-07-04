<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inscripcion extends Model
{
  use SoftDeletes;
  protected $table = 'inscripciones';
  protected $fillable= [
    'escuela_id',
    'ciclo_id',
    'grado_id',
    'grupo_id',
    'infoalumno_id',
    'alumno_id',
    'pago_id', //
    'user_id', //
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

  /*
   * Obtener el alumno a la que pertenece esta inscripcion
   */
  public function alumno(){
    return $this->belongsTo(Alumno::class, 'alumno_id', 'id');
  }

}
