<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImpresionRealizada extends Model
{
    protected $table = 'impresiones_realizadas';
    protected $fillable = ['servicio_id', 'tipo_id', 'precio', 'descripcion', 'user_id'];

    public function servicio()
    {
        return $this->belongsTo(ServicioImpresion::class, 'servicio_id');
    }

    public function tipo()
    {
        return $this->belongsTo(TipoImpresion::class, 'tipo_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}
