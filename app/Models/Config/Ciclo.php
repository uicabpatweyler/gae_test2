<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ciclo extends Model
{
    use SoftDeletes;
    protected $table = 'ciclos';
    protected $fillable = ['periodo','status','user_created', 'user_updated'];
    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at'
    ];
    protected $casts = [
        'status'   => 'boolean'
    ];

  /* Mutators: set and get */
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

  /*
   * Relacion CICLO:GRUPOS (1:M)
   * Lado 1
   * Obtener todos los grupos creados o que pertenecen a este ciclo escolar
   */
  public function grupos(){
    return $this->hasMany(Ciclo::class);
  }

  /*
   * Relacion CICLO:CUOTAS (1:M)
   * Lado 1
   * Obtener todas las cuotas que pertenecen a este ciclo escolar   *
   */
  public function cuotas(){
      return $this->hasMany(Cuota::class);
  }
}
