<?php

namespace App\Models\Admin;

use App\Models\Config\Escuela;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nivel extends Model
{
    use SoftDeletes;

    protected $table    = 'niveles';
    protected $fillable = ['tipo_id', 'nombre', 'status'];
    protected $dates    = ['deleted_at', 'created_at', 'updated_at'];
    protected $casts    = ['status' => 'boolean'];

    /*
     * Relacion TIPOS:NIVELES (1:M)
     * Lado M
     * Obtener el tipo al que pertenece este nivel
     */
    public function tipo(){
        return $this->belongsTo(Tipo::class,'tipo_id','id');
    }

    /*
     * Relacion NIVELES:SERVICIOS (1:M)
     * Lado 1
     * Obtener todos los servicios que pertenecen a este nivel
     */
    public function servicios(){
        return $this->hasMany(Servicio::class);
    }

    /*
     * Relacion NIVELES:ESCUELAS (1:M)
     * Lado 1
     * Obtener todas las escuelas que pertenecen a este nivel
     */
    public function escuelas(){
        return $this->hasMany(Escuela::class);
    }
}
