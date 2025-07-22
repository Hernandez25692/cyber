<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RemesaRealizada extends Model
{
    protected $table = 'remesas_realizadas';

    protected $fillable = [
        'user_id',
        'monto',
        'comision',
        'referencia',
    ];

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
