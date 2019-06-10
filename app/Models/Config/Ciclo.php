<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ciclo extends Model
{
    use SoftDeletes;
    protected $table = 'ciclos';
    protected $fillable = ['periodo','status'];
    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at'
    ];
    protected $casts = [
        'status'   => 'boolean'
    ];

    /* Mutators: set and get */

  /*
   * Relacion CICLO:GRUPOS (1:M)
   * Lado 1
   * Obtener todos los grupos creados o que pertenecen a este ciclo escolar
   */
  public function grupos(){
    return $this->hasMany(Ciclo::class);
  }
}
