<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InformacionAlumno extends Model
{
  use SoftDeletes;
  protected $table = 'informacion_alumnos';
  protected $fillable= [
    'escuela_id',
    'ciclo_id',
    'tutor_id',
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
    'telefcasa',
    'referencia1',
    'teleftutor',
    'referencia2',
    'telefcelular',
    'referencia3',
    'telefotro',
    'referencia4',
    'escuela',
    'ultimogrado',
    'lugartrabajo',
    'email',
    'pregunta1',
    'pregunta2',
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

  public function setEscuelaAttribute($value){
    if(isset($value)){
      $this->attributes['escuela'] = mb_convert_case($value,MB_CASE_TITLE,'UTF-8');
    }
    else{}
  }

  public function setUltimogradoAttribute($value){
    if(isset($value)){
      $this->attributes['ultimogrado'] = mb_convert_case($value,MB_CASE_TITLE,'UTF-8');
    }
    else{}
  }

  public function setLugartrabajoAttribute($value){
    if(isset($value)){
      $this->attributes['lugartrabajo'] = mb_convert_case($value,MB_CASE_TITLE,'UTF-8');
    }
    else{}
  }

  public function setEscuelaIdAttribute($value){
    if(isset($value)){
      $this->attributes['escuela_id'] = $value;
    }
    else{
      $this->attributes['escuela_id'] = 0;
    }
  }

  public function setCicloIdAttribute($value){
    if(isset($value)){
      $this->attributes['ciclo_id'] = $value;
    }
    else{
      $this->attributes['ciclo_id'] = 0;
    }
  }

  public function setTutorIdAttribute($value){
    if(isset($value)){
      $this->attributes['tutor_id'] = $value;
    }
    else{
      $this->attributes['tutor_id'] = 0;
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

  public function getDireccionAttribute(){
    return "{$this->nombre_vialidad} {$this->exterior} {$this->interior} {$this->entre_calles}";
  }

  public function alumno(){
    return $this->belongsTo(Alumno::class, 'alumno_id', 'id');
  }
}
