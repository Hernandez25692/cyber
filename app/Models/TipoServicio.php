<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ServicioConfig;

class TipoServicio extends Model
{
    protected $table = 'tipos_servicio'; 

    protected $fillable = ['nombre'];

    public function servicios()
    {
        return $this->hasMany(ServicioConfig::class);
    }
}
