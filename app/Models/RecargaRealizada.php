<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RecargaRealizada extends Model
{
    use HasFactory;
    protected $table = 'recargas_realizadas';
    protected $fillable = ['paquete_id', 'numero', 'user_id'];

    public function paquete()
    {
        return $this->belongsTo(PaqueteRecarga::class, 'paquete_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
