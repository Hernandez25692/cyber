<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RetiroConfig;
use App\Models\RetiroRealizado;
use Illuminate\Support\Facades\Auth;

class RetiroPOSController extends Controller
{
    public function calcularComision(Request $request)
    {
        $monto = $request->input('monto');

        $rango = RetiroConfig::where('monto_min', '<=', $monto)
            ->where('monto_max', '>=', $monto)
            ->first();

        if ($rango) {
            return response()->json([
                'comision' => $rango->comision,
                'nombre' => $rango->nombre
            ]);
        }

        return response()->json(['error' => 'No se encontró un rango válido.'], 404);
    }

    public function store(Request $request)
    {
        $request->validate([
            'monto' => 'required|numeric|min:0.01',
            'comision' => 'required|numeric|min:0',
            'referencia' => 'nullable|string|max:255',
            'banco_id' => 'required|exists:bancos,id',
        ]);

        RetiroRealizado::create([
            'user_id' => auth()->id(),
            'monto' => $request->monto,
            'comision' => $request->comision,
            'referencia' => $request->referencia,
            'banco_id' => $request->banco_id,
        ]);

        return redirect()->route('pos')->with('success', 'Retiro registrado correctamente.');
    }
}
