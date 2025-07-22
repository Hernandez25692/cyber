<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RemesaConfig extends Model
{
    protected $table = 'remesas_config';

    protected $fillable = [
        'nombre',
        'monto_min',
        'monto_max',
        'comision',
    ];
}
