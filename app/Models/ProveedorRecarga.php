<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class ProveedorRecarga extends Model
{
    use HasFactory;
    protected $table = 'proveedores_recarga';
    protected $fillable = ['nombre'];

    public function paquetes()
    {
        return $this->hasMany(PaqueteRecarga::class, 'proveedor_id');
    }
}
