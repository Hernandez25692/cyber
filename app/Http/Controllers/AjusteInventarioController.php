<?php

namespace App\Http\Controllers;

use App\Models\AjusteInventario;
use App\Models\DetalleAjuste;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AjusteInventarioController extends Controller
{
    public function crear()
    {
        return view('inventario.ajuste-inventario');
    }

    public function buscarProducto(Request $request)
    {
        $producto = Producto::where('codigo', $request->codigo)->first();
        if (!$producto) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }

        return response()->json($producto);
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'descripcion' => 'nullable|string',
            'productos' => 'required|array|min:1',
        ]);

        // Generar código automático
        $ultimoId = AjusteInventario::max('id') + 1;
        $codigo = 'AI-' . str_pad($ultimoId, 4, '0', STR_PAD_LEFT);

        $ajuste = AjusteInventario::create([
            'codigo' => $codigo,
            'descripcion' => $request->descripcion,
            'user_id' => Auth::id(),
        ]);

        foreach ($request->productos as $p) {
            $producto = Producto::find($p['id']);
            if (!$producto) continue;

            $diferencia = intval($p['stock_fisico']) - $producto->stock;

            // Crear detalle
            DetalleAjuste::create([
                'ajuste_id' => $ajuste->id,
                'producto_id' => $producto->id,
                'stock_sistema' => $producto->stock,
                'stock_fisico' => intval($p['stock_fisico']),
                'diferencia' => $diferencia,
                'observacion' => $p['observacion'] ?? '',
            ]);

            // Actualizar stock
            $producto->stock = intval($p['stock_fisico']);
            $producto->save();
        }

        return redirect()->route('ajustes.historial')->with('success', 'Ajuste registrado correctamente.');
    }

    public function historial()
    {
        $ajustes = AjusteInventario::with('usuario')->orderByDesc('id')->paginate(15);
        return view('inventario.historial-ajustes', compact('ajustes'));
    }

    public function detalle($id)
    {
        $ajuste = AjusteInventario::with('detalles.producto')->findOrFail($id);
        return view('inventario.detalle-ajuste', compact('ajuste'));
    }
}
