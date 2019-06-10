<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grupo extends Model
{
    use SoftDeletes;
    protected $table = 'grupos';
    protected $fillable= ['escuela_id', 'ciclo_id', 'grado_id', 'nombre','cupoalumnos'];
    protected $dates = [
      'deleted_at',
      'created_at',
      'updated_at'
    ];
    protected $casts = [
      'status'   => 'boolean'
    ];

  /*Establecer a mayusculas el nombre del grupo*/
  public function setNombreAttribute($value)
  {
    $this->attributes['nombre'] = mb_convert_case($value,MB_CASE_UPPER,"UTF-8");
  }

  /**
   * Relacion ESCUELA:GRUPOS (1:M)
   * Lado M
   * Obtener la escuela a la que pertenece este grupo
   */
  public function escuela(){
    return $this->belongsTo(Escuela::class,'escuela_id','id');
  }

  /*
   * Relacion CICLO:GRUPOS (1:M)
   * Lado M
   * Obtener el ciclo escolar al que pertenece este grupo
   */
  public function ciclo(){
    return $this->belongsTo(Ciclo::class,'ciclo_id','id');
  }

  /*
   * Relacion GRADO:GRUPOS (1:M)
   * Lado M
   * Obtener el grado al que pertenece este grupo
   */
  public function grado(){
    return $this->belongsTo(Grado::class, 'grado_id','id');
  }
}
