<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\AjusteInventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AjusteInventarioController extends Controller
{
    public function index()
    {
        $productos = Producto::orderBy('nombre')->get();
        return view('inventario.ajuste', compact('productos'));
    }

    public function store(Request $request)
    {
        foreach ($request->producto_id as $index => $productoId) {
            $producto = Producto::find($productoId);
            $stockSistema = $producto->stock;
            $stockFisico = $request->stock_fisico[$index];
            $diferencia = $stockFisico - $stockSistema;

            // Ajustamos el stock real si hay diferencia
            $producto->stock = $stockFisico;
            $producto->save();

            AjusteInventario::create([
                'producto_id' => $productoId,
                'stock_sistema' => $stockSistema,
                'stock_fisico' => $stockFisico,
                'diferencia' => $diferencia,
                'observacion' => $request->observacion[$index] ?? null,
                'user_id' => Auth::id()
            ]);
        }

        return redirect()->route('inventario.ajuste.index')->with('success', 'Ajustes de inventario aplicados correctamente.');
    }
}
