<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MesDePago extends Model
{
  use SoftDeletes;
  protected $table = 'mesesdepago';
  protected $fillable= [
    'cuota_id',
    'orden',
    'mes',
    'fecha1',
    'fecha2',
    'fecha3',
    'fecha4',
    'recargo',
    'descuento',
    'user_created',
    'user_updated'
  ];
  protected $dates = [
    'fecha1',
    'fecha2',
    'fecha3',
    'fecha4',
    'deleted_at',
    'created_at',
    'updated_at'
  ];
  protected $casts = [
    'status'   => 'boolean'
  ];

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
