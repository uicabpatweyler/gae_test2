<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cuota extends Model
{
    use SoftDeletes;
    protected $table = 'cuotas';
    protected $fillable = ['escuela_id','ciclo_id','nombre','tipo','cuota'];
    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at'
    ];
    protected $casts = [
        'status'   => 'boolean'
    ];

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
}
