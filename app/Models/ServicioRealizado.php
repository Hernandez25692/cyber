<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ServicioConfig;

class ServicioRealizado extends Model
{
    protected $table = 'servicios_realizados';

    protected $fillable = ['user_id', 'servicio_config_id', 'referencia', 'comision'];

    public function servicio()
    {
        return $this->belongsTo(ServicioConfig::class, 'servicio_config_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
