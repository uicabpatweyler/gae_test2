<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InformacionTutor extends Model
{
  use SoftDeletes;
  protected $table = 'informacion_tutores';
  protected $fillable= [
    'tutor_id',
    'alumno_id',
    'infoalumno_id',
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
    'telefcasa',
    'referencia1',
    'teleftrabajo',
    'referencia2',
    'telefcelular',
    'referencia3',
    'telefotro',
    'referencia4',
    'adicional_trabajo',
    'adicional_direccion',
    'adicional_estado',
    'adicional_delegacion',
    'adicional_localidad',
    'adicional_tipoasentamiento',
    'adicional_nombreasentamiento',
    'adicional_codpost',
    'email'
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

  public function setExteriorAttribute($value){
    $this->attributes['exterior'] = mb_convert_case($value,MB_CASE_TITLE,'UTF-8');
  }

  public function setInteriorAttribute($value){
    if(isset($value)){
      $this->attributes['interior'] = mb_convert_case($value,MB_CASE_TITLE,'UTF-8');
    }
    else{}
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

  public function setReferencia1Attribute($value){
    if(isset($value)){
      $this->attributes['referencia1'] = mb_convert_case($value,MB_CASE_TITLE,'UTF-8');
    }
    else{}
  }

  public function setReferencia2Attribute($value){
    if(isset($value)){
      $this->attributes['referencia2'] = mb_convert_case($value,MB_CASE_TITLE,'UTF-8');
    }
    else{}
  }

  public function setReferencia3Attribute($value){
    if(isset($value)){
      $this->attributes['referencia3'] = mb_convert_case($value,MB_CASE_TITLE,'UTF-8');
    }
    else{}
  }

  public function setReferencia4Attribute($value){
    if(isset($value)){
      $this->attributes['referencia4'] = mb_convert_case($value,MB_CASE_TITLE,'UTF-8');
    }
    else{}
  }

  public function setAdicionalTrabajoAttribute($value){
    if(isset($value)){
      $this->attributes['adicional_trabajo'] = mb_convert_case($value,MB_CASE_TITLE,'UTF-8');
    }
    else{}
  }

  public function setAdicionalDireccionAttribute($value){
    if(isset($value)){
      $this->attributes['adicional_direccion'] = mb_convert_case($value,MB_CASE_TITLE,'UTF-8');
    }
    else{}
  }

  public function setAdicionalLocalidadAttribute($value){
    if(isset($value)){
      $this->attributes['adicional_localidad'] = mb_convert_case($value,MB_CASE_TITLE,'UTF-8');
    }
    else{}
  }

  public function setAdicionalTipoasentamientoAttribute($value){
    if(isset($value)){
      $this->attributes['adicional_tipoasentamiento'] = mb_convert_case($value,MB_CASE_TITLE,'UTF-8');
    }
    else{}
  }

  public function setAdicionalNombreasentamientoAttribute($value){
    if(isset($value)){
      $this->attributes['adicional_nombreasentamiento'] = mb_convert_case($value,MB_CASE_TITLE,'UTF-8');
    }
    else{}
  }
}
