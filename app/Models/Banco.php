<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    protected $fillable = ['nombre'];

    public function servicios()
    {
        return $this->hasMany(ServicioConfig::class);
    }
}
