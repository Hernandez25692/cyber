<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepositoConfig extends Model
{
    protected $table = 'depositos_config';

    protected $fillable = ['nombre', 'monto_min', 'monto_max', 'comision'];
}
