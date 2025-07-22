<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoImpresion extends Model
{
    protected $table = 'tipos_impresion';
    protected $fillable = ['nombre'];
}
