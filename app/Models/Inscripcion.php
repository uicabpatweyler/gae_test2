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
    'escuela_id', 'ciclo_id', 'grado_id', 'grupo_id', 'infoalumno_id', 'alumno_id', 'fecha'
  ];

  protected $dates = [
    'deleted_at',
    'created_at',
    'updated_at'
  ];
  protected $casts = [
    'status'   => 'boolean',
    'fecha' => 'date:d-m-Y',
  ];

  public function setFechaAttribute($value){
    $this->attributes['fecha'] = (new Carbon($value))->format('y-m-d');
  }
}
