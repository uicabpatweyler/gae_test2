<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cuota extends Model
{
    use SoftDeletes;
    protected $table = 'cuotas';
    protected $fillable = ['escuela_id','ciclo_id','nombre','tipo','cantidad','user_created', 'user_updated'];
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
     * Relacion ESCUELA:CUOTAS (1:M)
     * Lado M
     * Obtener la escuela a la que pertenece esta cuota
     */
    public function escuela(){
        return $this->belongsTo(Escuela::class,'escuela_id','id');
    }

    /*
     * Relacion CICLO:CUOTAS (1:M)
     * Lado M
     * Obtener el ciclo escolar al que pertenece esta cuota
     */
    public function ciclo(){
        return $this->belongsTo(Ciclo::class,'ciclo_id','id');
    }

    /*
     * Relacion CUOTA:GRUPOS (1:M)
     * Lado 1
     * Obtener los grupos que tienen asignada esta cuota
     */
    public function gruposIns(){
        return $this->hasMany(Grupo::class,'cuotainscripcion_id','id');
    }

    public function gruposCol(){
        return $this->hasMany(Grupo::class,'cuotacolegiatura_id','id');
    }
}
