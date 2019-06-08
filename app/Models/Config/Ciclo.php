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
}
