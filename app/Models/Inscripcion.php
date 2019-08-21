<?php

namespace App\Models;

use App\Models\Config\Ciclo;
use App\Models\Config\Escuela;
use App\Models\Config\Grado;
use App\Models\Config\Grupo;
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
    'pago_id',
    'user_id',
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
    'fecha'
  ];
  protected $casts = [
    'status'   => 'boolean',
    'fecha' => 'date:d-m-Y',
  ];

  public function setFechaAttribute($value){
    $this->attributes['fecha'] = (new Carbon($value))->format('Y-m-d');
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

  /*
   * Obtener el alumno a la que pertenece esta inscripcion
   */
  public function alumno(){
    return $this->belongsTo(Alumno::class, 'alumno_id', 'id');
  }

  /*
   * Obtener la escuela a la que pertenece esta inscripcion
   */
  public function escuela(){
    return $this->belongsTo(Escuela::class, 'escuela_id', 'id');
  }

  /*
   * Obtener el ciclo al que pertenece esta inscripcion
   */
  public function ciclo(){
    return $this->belongsTo(Ciclo::class, 'ciclo_id', 'id');
  }

  /*
   * Obtener el grado al que pertenece esta inscripcion
   */
  public function grado(){
    return $this->belongsTo(Grado::class, 'grado_id', 'id');
  }

  /*
   * Obtener el grupo al que pertenece esta inscripcion
   */
  public function grupo(){
    return $this->belongsTo(Grupo::class, 'grupo_id', 'id');
  }

}
