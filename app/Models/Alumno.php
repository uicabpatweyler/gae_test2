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
    'curp', 'nombre1', 'nombre2', 'apellido1', 'apellido2', 'fechanacimiento', 'genero', 'status'
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
    $this->attributes['fechanacimiento'] = (new Carbon($value))->format('y-m-d');
  }

  public function informacion(){
    return $this->hasMany(InformacionAlumno::class);
  }

}
