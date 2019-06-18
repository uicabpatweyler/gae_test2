<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MesDePago extends Model
{
  use SoftDeletes;
  protected $table = 'mesesdepago';
  protected $fillable= [
    'cuota_id', 'orden', 'mes', 'fecha1', 'fecha2', 'fecha3', 'fecha4', 'recargo', 'descuento'
  ];
  protected $dates = [
    'deleted_at',
    'created_at',
    'updated_at'
  ];
  protected $casts = [
    'status'   => 'boolean'
  ];
}
