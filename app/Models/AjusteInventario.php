<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AjusteInventario extends Model
{
    protected $table = 'ajustes_inventario';
    protected $fillable = [
        'producto_id', 'stock_sistema', 'stock_fisico', 'diferencia', 'observacion', 'user_id'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
