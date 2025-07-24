<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class InventarioController extends Controller
{
    /**
     * Mostrar sugerencias de pedido por bajo stock.
     */
    public function sugerenciaPedido()
    {
        $productos = Producto::where('stock', '<', 10)->orderBy('stock', 'asc')->get();
        return view('inventario.sugerencias', compact('productos'));
    }
}
