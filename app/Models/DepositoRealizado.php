<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepositoRealizado extends Model
{
    protected $table = 'depositos_realizados';

    protected $fillable = ['user_id', 'monto', 'comision', 'referencia', 'banco_id'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function banco()
    {
        return $this->belongsTo(Banco::class, 'banco_id');
    }
}
