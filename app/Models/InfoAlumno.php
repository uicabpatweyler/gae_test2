<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InfoAlumno extends Model
{
  use SoftDeletes;
  protected $table = 'informacion_alumnos';
  protected $fillable= [
    'alumno_id',
    'nombre_vialidad',
    'exterior',
    'interior',
    'entre_calles',
    'tipo_asentamiento',
    'nombre_asentamiento',
    'codigo_postal',
    'localidad',
    'delegacion',
    'estado',
    'telefcasa', 'referencia1','teleftutor', 'referencia2','telefcelular', 'referencia3','telefotro', 'referencia4',
    'escuela', 'ultimogrado', 'lugartrabajo', 'email', 'pregunta1', 'pregunta2'
  ];
  protected $dates = [
    'deleted_at',
    'created_at',
    'updated_at'
  ];
  protected $casts = [
    'status'   => 'boolean'
  ];

  public function setNombreVialidadAttribute($value){
    $this->attributes['nombre_vialidad'] = mb_convert_case($value,MB_CASE_TITLE,"UTF-8");
  }

  public function setEntreCallesAttribute($value){
    if(isset($value)){
      $this->attributes['entre_calles'] = mb_convert_case($value,MB_CASE_TITLE,"UTF-8");
    }
  }

  public function setLocalidadAttribute($value){
    $this->attributes['localidad'] = mb_convert_case($value,MB_CASE_TITLE,"UTF-8");
  }

  public function setTipoAsentamientoAttribute($value){
    $this->attributes['tipo_asentamiento'] = mb_convert_case($value,MB_CASE_TITLE,"UTF-8");
  }

  public function setNombreAsentamientoAttribute($value){
    $this->attributes['nombre_asentamiento'] = mb_convert_case($value,MB_CASE_TITLE,"UTF-8");
  }
}
