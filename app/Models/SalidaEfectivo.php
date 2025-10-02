<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalidaEfectivo extends Model
{
    use HasFactory;

    protected $table = 'salidas_efectivo';

    protected $fillable = [
        'user_id',
        'cierre_id',
        'motivo',
        'monto',
        'observacion',
        'fecha_hora',
    ];

    protected $casts = [
        'fecha_hora' => 'datetime',
        'monto'      => 'decimal:2',
    ];

    public function usuario()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function cierre()
    {
        return $this->belongsTo(\App\Models\Cierre::class, 'cierre_id');
    }
}
