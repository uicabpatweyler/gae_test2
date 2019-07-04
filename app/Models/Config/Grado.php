<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grado extends Model
{
    use SoftDeletes;
    protected $table = 'grados';
    protected $fillable = ['escuela_id','nombre','abreviacion','user_created', 'user_updated'];
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
     * Relacion: ESCUELAS:GRADOS (1:M)
     * Lado M
     * Obtener la escuela al que pertenece este grado
     */
    public function escuela(){
        return $this->belongsTo(Escuela::class,'escuela_id','id');
    }

    /*
     * Relacion: GRADO:GRUPOS (1:M)
     * Lado 1
     * Obtener todos los grupos que pertenece a este grado
     */
    public function grupos(){
      return $this->hasMany(Grupo::class);
    }
}
