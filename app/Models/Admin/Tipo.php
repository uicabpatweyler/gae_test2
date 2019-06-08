<?php

namespace App\Models\Admin;

use App\Models\Config\Escuela;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tipo extends Model
{
    use SoftDeletes;

    protected $table    = 'tipos';
    protected $fillable = ['nombre', 'status'];
    protected $dates    = ['deleted_at', 'created_at', 'updated_at'];
    protected $casts    = ['status' => 'boolean'];

    /*
     * Relacion: TIPOS:NIVELES (1:M)
     * Lado 1
     * Obtener todos los niveles que pertenecen a este tipo
     */
    public function niveles(){
        return $this->hasMany(Nivel::class);
    }

    /*
     * Relacion: TIPOS:SERVICIOS (1:M)
     * Lado 1
     * Obtener todos los servicios que pertenecen a este tipo
     */
    public function servicios(){
        return $this->hasMany(Servicio::class);
    }

    /*
     * Relacion: TIPOS:ESCUELAS (1:M)
     * Lado 1
     * Obtener todas las escuelas que pertenecen a este tipo
     */
    public function escuelas(){
        return $this->hasMany(Escuela::class);
    }
}
