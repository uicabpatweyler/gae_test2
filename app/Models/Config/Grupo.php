<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grupo extends Model
{
    use SoftDeletes;
    protected $table = 'grupos';
    protected $fillable= [
        'escuela_id', 'ciclo_id', 'grado_id', 'nombre','cupoalumnos','cuotainscripcion_id','cuotacolegiatura_id'
    ];
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

  public function setCuotainscripcionIdAttribute($value){
      if(isset($value)){
          $this->attributes['cuotainscripcion_id'] = $value;
      }
      else{
          $this->attributes['cuotainscripcion_id'] = 0;
      }
  }

    public function setCuotacolegiaturaIdAttribute($value){
        if(isset($value)){
            $this->attributes['cuotacolegiatura_id'] = $value;
        }
        else{
            $this->attributes['cuotacolegiatura_id'] = 0;
        }
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

  /*
   * Relacion CUOTA:GRUPOS (1:M) Cuota de Inscripcion
   * Lado M
   * Obtener el grupo al que pertenece esta cuota
   */
  public function inscripcion(){
      return $this->belongsTo(Cuota::class, 'cuotainscripcion_id','id');
  }

  public function colegiatura(){
      return $this->belongsTo(Cuota::class,'cuotacolegiatura_id','id');
  }
}
