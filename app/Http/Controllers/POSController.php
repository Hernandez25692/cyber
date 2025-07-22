<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\TipoServicio;
use App\Models\Banco;

class POSController extends Controller
{
    public function index()
    {
        $productos = Producto::select('id', 'codigo', 'nombre', 'precio_venta')->get();
        $tipos = TipoServicio::all();
        $bancos = Banco::all();

        return view('pos', compact('productos', 'tipos', 'bancos'));
    }
}
