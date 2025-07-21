<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'productos' => 'required|array',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precio' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $venta = Venta::create([
                'user_id' => auth()->id(),
                'total' => $data['total'],
            ]);

            foreach ($data['productos'] as $p) {
                $producto = Producto::find($p['id']);

                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $producto->id,
                    'cantidad' => $p['cantidad'],
                    'precio_unitario' => $p['precio'],
                    'subtotal' => $p['cantidad'] * $p['precio'],
                ]);

                // Descontar del stock
                $producto->stock -= $p['cantidad'];
                $producto->save();
            }

            DB::commit();

            return response()->json(['success' => true, 'venta_id' => $venta->id]);
        } catch (\Throwable $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Error al guardar venta.'], 500);
        }
    }
}
