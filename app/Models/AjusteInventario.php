<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AjusteInventario extends Model
{
    protected $table = 'ajustes_inventario';
    protected $fillable = ['codigo', 'descripcion', 'user_id'];

    public function detalles()
    {
        return $this->hasMany(DetalleAjuste::class, 'ajuste_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
