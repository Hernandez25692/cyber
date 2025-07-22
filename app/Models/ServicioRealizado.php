<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicioRealizado extends Model
{
    use HasFactory;

    protected $table = 'servicios_realizados';

    protected $fillable = [
        'tipo_servicio_id',
        'banco_id',
        'comision',
        'referencia',
        'user_id',
    ];

    // Relación con tipo de servicio
    public function tipoServicio()
    {
        return $this->belongsTo(TipoServicio::class, 'tipo_servicio_id');
    }

    // Relación con banco
    public function banco()
    {
        return $this->belongsTo(Banco::class, 'banco_id');
    }

    // Relación con usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
