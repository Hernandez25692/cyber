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
        'pendiente',
    ];

    protected $casts = [
        'reporte_z_generado' => 'boolean',
        'pendiente' => 'boolean',
        'pos_final' => 'array',
    ];

    public function apertura()
    {
        return $this->belongsTo(Apertura::class);
    }
    public function salidasEfectivo()
    {
        return $this->hasMany(SalidaEfectivo::class, 'cierre_id');
    }
}
