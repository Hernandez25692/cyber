<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class POSController extends Controller
{
    public function index()
    {
        $productos = Producto::select('id', 'codigo', 'nombre', 'precio_venta')->get();
        return view('pos', compact('productos'));
    }
}
