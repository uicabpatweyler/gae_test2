<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grado extends Model
{
    use SoftDeletes;
    protected $table = 'grados';
    protected $fillable = ['escuela_id','ciclo_id','nombre','abreviacion'];
    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at'
    ];
    protected $casts = [
        'status'   => 'boolean'
    ];

    /*
     * Relacion: ESCUELAS:GRADOS (1:M)
     * Lado M
     * Obtener la escuela al que pertenece este grado
     */
    public function escuela(){
        return $this->belongsTo(Escuela::class,'escuela_id','id');
    }
}
