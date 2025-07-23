<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenEntrada extends Model
{
    protected $table = 'ordenes_entrada';
    protected $fillable = ['codigo', 'descripcion', 'user_id'];

    public function detalles()
    {
        return $this->hasMany(DetalleEntrada::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
