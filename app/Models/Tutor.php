<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tutor extends Model
{
  use SoftDeletes;
  protected $table = 'tutores';
  protected $fillable= [
    'nombre', 'apellido1', 'apellido2', 'genero', 'status'
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

  public function getFullNameAttribute(){
    return "{$this->nombre} {$this->apellido1} {$this->apellido2}";
  }
}
