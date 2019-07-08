<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alumno extends Model
{
  use SoftDeletes;
  protected $table = 'alumnos';
  protected $fillable= [
    'curp',
    'nombre1',
    'nombre2',
    'apellido1',
    'apellido2',
    'fechanacimiento',
    'genero',
    'status',
    'user_created',
    'user_updated',
    'created_at',
    'updated_at'
  ];
  protected $dates = [
    'deleted_at',
    'created_at',
    'updated_at'
  ];
  protected $casts = [
    'status'   => 'boolean',
    'fechanacimiento' => 'date:d-m-Y',
  ];

  /* Mutators: set and get */

  public function setNombre1Attribute($value)
  {
    $this->attributes['nombre1'] = mb_convert_case($value,MB_CASE_TITLE,"UTF-8");
  }
  public function setApellido1Attribute($value)
  {
    $this->attributes['apellido1'] = mb_convert_case($value,MB_CASE_TITLE,"UTF-8");
  }

  public function setNombre2Attribute($value){
    if(isset($value)){
      $this->attributes['nombre2'] = mb_convert_case($value,MB_CASE_TITLE,"UTF-8");
    }
    else{

    }
  }
  public function setApellido2Attribute($value){
    if(isset($value)){
      $this->attributes['apellido2'] = mb_convert_case($value,MB_CASE_TITLE,"UTF-8");
    }
    else{

    }
  }

  public function setFechanacimientoAttribute($value){
    $this->attributes['fechanacimiento'] = (new Carbon($value))->format('Y-m-d');
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
      $this->attributes['updated_at'] = Carbon::now()->toDateTimeString();
    }
  }

  public function getFullNameAttribute(){
    return "{$this->nombre1} {$this->nombre2} {$this->apellido1} {$this->apellido2}";
  }

  public function getMatriculaAttribute(){
    if($this->id<1000){
      return "00"."{$this->id} - ".(new Carbon($this->created_at))->format('dmY');
    }
    return "{$this->id} - ".(new Carbon($this->created_at))->format('dmY');
  }

  public function informacion(){
    return $this->hasMany(InformacionAlumno::class);
  }

  /*
   * Obtener las inscripciones para este alumno
   */
  public function inscripciones(){
    return $this->hasMany(Inscripcion::class);
  }

}
