<?php

namespace App\Models\Config;

use App\Models\Admin\Nivel;
use App\Models\Admin\Servicio;
use App\Models\Admin\Tipo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Escuela extends Model
{
    use SoftDeletes;

    protected $table = 'escuelas';

    protected $fillable = [
        'cct', 'incorporacion', 'nombre', 'tipo_id', 'nivel_id', 'servicio_id',
        'turno', 'sostenimiento', 'calle', 'exterior', 'interior', 'entrecalles',
        'colonia', 'codpost', 'pais', 'entidad', 'municipio', 'localidad', 'status'
    ];

    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'status'   => 'boolean'
    ];

    /* Mutators: set and get */

    public function setCctAttribute($value)
    {
        $this->attributes['cct'] = mb_strtoupper($value);
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = true;
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('status', true);
    }

    /* Relaciones de la entidad*/

    /*
     * Relacion: TIPOS:ESCUELAS (1:M)
     * Lado M
     * Obtener el tipo al que pertenece esta escuela
     */
    public function tipo(){
        return $this->belongsTo(Tipo::class,'tipo_id','id');
    }

    /*
     * Relacion: NIVELES:ESCUELAS (1:M)
     * Lado M
     * Obtener el nivel al que pertenece esta escuela
     */
    public function nivel(){
        return $this->belongsTo(Nivel::class,'nivel_id','id');
    }

    /*
     * Relacion: SERVICIOS:ESCUELAS (1:M)
     * Lado M
     * Obtener el servicio al que pertenece esta escuela
     */
    public function servicio(){
        return $this->belongsTo(Servicio::class,'servicio_id','id');
    }

    /*
     * Relacion: ESCUELAS:GRADOS (1:M)
     * Lado 1
     * Obtener todos los grados  que pertenecen a esta escuela
     */
    public function grados(){
        return $this->hasMany(Grado::class);
    }


}
