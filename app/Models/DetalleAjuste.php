<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleAjuste extends Model
{
    protected $table = 'detalle_ajustes';
    protected $fillable = [
        'ajuste_id',
        'producto_id',
        'stock_sistema',
        'stock_fisico',
        'diferencia',
        'observacion'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function ajuste()
    {
        return $this->belongsTo(AjusteInventario::class, 'ajuste_id');
    }
}
