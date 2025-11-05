<?php

namespace App\Http\Controllers;

use App\Models\Consumo;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsumoController extends Controller
{
    /**
     * Listado de consumos del usuario autenticado (historial).
     */
    public function index()
    {
        $consumos = Consumo::with('producto')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(20);

        return view('consumos.index', compact('consumos'));
    }

    /**
     * AJAX: Buscar producto por código (o por nombre como fallback).
     * Espera: { codigo: '...' }
     * Responde JSON para llenar el modal.
     */
    public function buscarPorCodigo(Request $request)
    {
        $codigo = trim((string) $request->get('codigo', ''));

        if ($codigo === '') {
            return response()->json([
                'found'   => false,
                'message' => 'Código vacío.'
            ], 422);
        }

        // Buscar por la columna existente 'codigo'
        $prod = Producto::where('codigo', $codigo)->first();

        // Fallback: por nombre (contiene)
        if (!$prod) {
            $prod = Producto::where('nombre', 'like', "%{$codigo}%")->first();
        }

        if (!$prod) {
            return response()->json([
                'found'   => false,
                'message' => 'Producto no encontrado.'
            ], 404);
        }

        return response()->json([
            'found' => true,
            'data'  => [
                'producto_id'            => $prod->id,
                'codigo_barra'           => $prod->codigo,              // rellenará tu input de código
                'nombre'                 => $prod->nombre,
                'costo_unitario_default' => (float) ($prod->precio_compra ?? 0),
            ],
        ]);
    }

    /**
     * Guardar consumo (no afecta cierres). Si es AJAX, responde JSON; si no, redirige al POS.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'codigo_barra'   => 'required|string|max:255',
                'nombre'         => 'nullable|string|max:255',
                'producto_id'    => 'nullable|exists:productos,id',
                'cantidad'       => 'required|numeric|min:0.01',
                'costo_unitario' => 'required|numeric|min:0',
                'observacion'    => 'nullable|string|max:255',
            ]);

            $total = round($validated['cantidad'] * $validated['costo_unitario'], 2);

            $consumo = Consumo::create([
                'user_id'        => Auth::id(),
                'producto_id'    => $validated['producto_id'] ?? null,
                'codigo_barra'   => $validated['codigo_barra'],
                'nombre'         => $validated['nombre'] ?? null,
                'cantidad'       => $validated['cantidad'],
                'costo_unitario' => $validated['costo_unitario'],
                'total_costo'    => $total,
                'observacion'    => $validated['observacion'] ?? null,
            ]);

            // Si es AJAX/JSON, respondemos JSON para que el modal no falle.
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'ok'       => true,
                    'id'       => $consumo->id,
                    'redirect' => route('pos'),
                    'message'  => 'Consumo registrado correctamente.',
                ]);
            }

            // Petición normal (no AJAX): redirige al POS.
            return redirect()
                ->route('pos')
                ->with('success', 'Consumo registrado correctamente.');
        } catch (\Illuminate\Validation\ValidationException $ve) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'ok'      => false,
                    'message' => 'Datos inválidos.',
                    'errors'  => $ve->errors(),
                ], 422);
            }
            throw $ve;
        } catch (\Throwable $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'ok'      => false,
                    'message' => 'Error del servidor al guardar.',
                    'error'   => config('app.debug') ? $e->getMessage() : null,
                ], 500);
            }

            return redirect()
                ->route('pos')
                ->with('error', 'Error del servidor al guardar.');
        }
    }
}
