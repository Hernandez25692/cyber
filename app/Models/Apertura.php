<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apertura extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'efectivo_inicial', 'pos_inicial'];

    protected $casts = [
        'pos_inicial' => 'array',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    // Relación con banco
    public function banco()
    {
        return $this->belongsTo(Banco::class, 'banco_id');
    }
}
