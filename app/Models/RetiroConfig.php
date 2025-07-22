<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RetiroConfig extends Model
{
    protected $table = 'retiros_config';

    protected $fillable = ['nombre', 'monto_min', 'monto_max', 'comision'];
}
