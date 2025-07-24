<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::with('user')->latest()->paginate(20);
        return view('ventas.index', compact('ventas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'productos' => 'required|array',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precio' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'monto_recibido' => 'required|numeric|min:0'
        ]);

        DB::beginTransaction();

        try {
            // Calcular cambio
            $cambio = $data['monto_recibido'] - $data['total'];
            if ($cambio < 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Monto recibido insuficiente.'
                ], 400);
            }

            // Crear venta
            $venta = Venta::create([
                'user_id' => auth()->id(),
                'total' => $data['total'],
                'monto_recibido' => $data['monto_recibido'],
                'cambio' => $cambio,
            ]);

            // Detalle y control de stock
            foreach ($data['productos'] as $p) {
                $producto = Producto::findOrFail($p['id']);

                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $producto->id,
                    'cantidad' => $p['cantidad'],
                    'precio_unitario' => $p['precio'],
                    'subtotal' => $p['cantidad'] * $p['precio'],
                ]);

                // Descontar del stock (sin validación de límite)
                $producto->stock -= $p['cantidad'];
                $producto->save();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'venta_id' => $venta->id,
                'cambio' => $cambio
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la venta.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function reporteProductos()
    {
        $reporte = DetalleVenta::select('producto_id', DB::raw('SUM(cantidad) as total_vendidos'))
            ->groupBy('producto_id')
            ->with('producto')
            ->orderByDesc('total_vendidos')
            ->get();

        return view('ventas.reporte_productos', compact('reporte'));
    }
}
