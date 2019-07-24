<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model
{
  use SoftDeletes;
  protected $table = 'categorias';
  protected $fillable = [
    'nombre',
    'disponible',
    'user_created',
    'user_updated'
  ];
  protected $dates = [
    'deleted_at',
    'created_at',
    'updated_at'
  ];
  protected $casts = [
    'disponible' => 'boolean'
  ];

  /*Mutators - set*/
  public function setNombreAttribute($value){
    $this->attributes['nombre'] = mb_convert_case($value,MB_CASE_TITLE,"UTF-8");
  }
  public function setDisponibleAttribute($value){
    if(isset($value)){
      $this->attributes['disponible'] = $value;
    }
    else{
      $this->attributes['disponible'] = false;
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

}
