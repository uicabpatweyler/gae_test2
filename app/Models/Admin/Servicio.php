<?php

namespace App\Models\Admin;

use App\Models\Config\Escuela;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servicio extends Model
{
    use SoftDeletes;

    protected $table    = 'servicios';
    protected $fillable = ['tipo_id','nivel_id', 'nombre', 'status'];
    protected $dates    = ['deleted_at', 'created_at', 'updated_at'];
    protected $casts    = ['status' => 'boolean'];

    /*
     * Relacion: TIPOS:SERVICIOS (1:M)
     * Lado M
     * Obtener el tipo al que pertenece este servicio
     */
    public function tipo(){
        return $this->belongsTo(Tipo::class, 'tipo_id','id');
    }

    /*
     * Relacion: NIVELES:SERVICIOS (1:M)
     * Lado M
     * Obtener el nivel al que pertenece este servicio
     */
    public function nivel(){
        return $this->belongsTo(Nivel::class, 'nivel_id', 'id');
    }

    /*
     * Relacion: SERVICIOS:ESCUELAS (1:M)
     * Lado 1
     * Obtener todas las escuelas que pertenecen a este servicio
     */
    public function escuelas(){
        return $this->hasMany(Escuela::class);
    }
}
