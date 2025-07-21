<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'codigo',
        'nombre',
        'categoria',
        'precio_compra',
        'precio_venta',
        'stock',
    ];
}
