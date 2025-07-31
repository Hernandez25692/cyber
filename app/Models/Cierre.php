<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cierre extends Model
{
    protected $fillable = [
        'apertura_id',
        'efectivo_final',
        'pos_final',
        'total_ingresos',
        'total_egresos',
        'diferencia',
        'reporte_z_generado',
    ];

    protected $casts = [
        'pos_final' => 'array',
    ];

    public function apertura()
    {
        return $this->belongsTo(Apertura::class);
    }
}
