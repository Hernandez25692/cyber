<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RetiroRealizado extends Model
{
    protected $table = 'retiros_realizados';

    protected $fillable = ['user_id', 'monto', 'comision', 'referencia'];

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
        return $this->belongsTo(Banco::class);
    }
}
