<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoServicio extends Model
{
    protected $table = 'tipos_servicio';

    protected $fillable = [
        'categoria',
        'banco',
        'nombre',
        'monto_min',
        'monto_max',
        'comision',
    ];
}
