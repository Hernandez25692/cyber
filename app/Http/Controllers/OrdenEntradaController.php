<?php

namespace App\Http\Controllers;

use App\Models\OrdenEntrada;
use App\Models\DetalleEntrada;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrdenEntradaController extends Controller
{
    public function create()
    {
        return view('inventario.entrada-masiva');
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'nullable|string',
            'productos' => 'required|array',
            'productos.*.codigo' => 'required|exists:productos,codigo',
            'productos.*.cantidad' => 'required|integer|min:1',
        ]);

        // Crear cabecera
        $orden = OrdenEntrada::create([
            'codigo' => 'OEN-' . str_pad(OrdenEntrada::count() + 1, 4, '0', STR_PAD_LEFT),
            'descripcion' => $request->descripcion,
            'user_id' => auth()->id(),
        ]);

        foreach ($request->productos as $item) {
            $producto = Producto::where('codigo', $item['codigo'])->first();
            $producto->stock += $item['cantidad'];
            $producto->save();

            DetalleEntrada::create([
                'orden_entrada_id' => $orden->id,
                'producto_id' => $producto->id,
                'cantidad' => $item['cantidad'],
            ]);
        }

        return redirect()->route('productos.index')->with('success', 'Orden de entrada registrada con éxito.');
    }

    public function index(Request $request)
    {
        $query = \App\Models\OrdenEntrada::with('detalles.producto', 'usuario')
            ->orderByDesc('created_at');

        // Filtro por rango de fechas
        if ($request->filled('desde')) {
            $query->whereDate('created_at', '>=', $request->desde);
        }

        if ($request->filled('hasta')) {
            $query->whereDate('created_at', '<=', $request->hasta);
        }

        // Filtro por nombre de producto
        if ($request->filled('producto')) {
            $query->whereHas('detalles.producto', function ($q) use ($request) {
            $q->where('nombre', 'like', '%' . $request->producto . '%');
            });
        }

        // Filtro por código de producto
        if ($request->filled('codigo')) {
            $query->whereHas('detalles.producto', function ($q) use ($request) {
            $q->where('codigo', 'like', '%' . $request->codigo . '%');
            });
        }

        $ordenes = $query->paginate(10);

        return view('inventario.ordenes-historial', compact('ordenes', 'request'));
    }
}
