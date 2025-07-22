<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TipoServicio;
use App\Models\Banco;

class ServicioConfig extends Model
{
    protected $table = 'servicios_config';

    protected $fillable = [
        'tipo_servicio_id',
        'banco_id',
        'comision'
    ];

    public function tipo()
    {
        return $this->belongsTo(TipoServicio::class, 'tipo_servicio_id');
    }

    public function banco()
    {
        return $this->belongsTo(Banco::class, 'banco_id');
    }
}
