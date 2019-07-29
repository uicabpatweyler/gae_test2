<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Entrada extends Model
{
    use SoftDeletes;
    protected $table = 'entradas';
    protected $fillable = [
      'escuela_id',
      'ciclo_id',
      'nombre',
      'fecha'
    ];
  protected $dates = [
    'deleted_at',
    'created_at',
    'updated_at'
  ];
  protected $casts = [
    'fecha'     => 'date:d-m-Y',
    'cancelado' => 'boolean'
  ];

  public function setNombreAttribute($value){
    $this->attributes['nombre'] = mb_convert_case($value,MB_CASE_TITLE,"UTF-8");
  }

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
}
