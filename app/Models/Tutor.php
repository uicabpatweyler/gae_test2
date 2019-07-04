<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tutor extends Model
{
  use SoftDeletes;
  protected $table = 'tutores';
  protected $fillable= [
    'nombre',
    'apellido1',
    'apellido2',
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
    'status'   => 'boolean'
  ];

  public function setNombreAttribute($value)
  {
    $this->attributes['nombre'] = mb_convert_case($value,MB_CASE_TITLE,"UTF-8");
  }
  public function setApellido1Attribute($value)
  {
    $this->attributes['apellido1'] = mb_convert_case($value,MB_CASE_TITLE,"UTF-8");
  }

  public function setApellido2Attribute($value)
  {
    if (isset($value)) {
      $this->attributes['apellido2'] = mb_convert_case($value, MB_CASE_TITLE, "UTF-8");
    } else {

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

  public function getFullNameAttribute(){
    return "{$this->nombre} {$this->apellido1} {$this->apellido2}";
  }
}
