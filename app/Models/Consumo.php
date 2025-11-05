<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consumo extends Model
{
    use HasFactory;

    protected $table = 'consumos';

    protected $fillable = [
        'user_id',
        'producto_id',
        'codigo_barra',
        'nombre',
        'cantidad',
        'costo_unitario',
        'total_costo',
        'observacion',
    ];

    protected $casts = [
        'cantidad'       => 'decimal:2',
        'costo_unitario' => 'decimal:2',
        'total_costo'    => 'decimal:2',
    ];

    // Relación con el producto (opcional/nullable)
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    // Alias 1: para usar $consumo->user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Alias 2: para usar $consumo->usuario (coincide con tus partials)
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
