<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class PaqueteRecarga extends Model
{
    use HasFactory;
    protected $table = 'paquetes_recarga';
    protected $fillable = ['proveedor_id', 'descripcion', 'precio'];

    public function proveedor()
    {
        return $this->belongsTo(ProveedorRecarga::class, 'proveedor_id');
    }
}
