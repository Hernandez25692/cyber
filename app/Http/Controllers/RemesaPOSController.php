<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RemesaConfig;
use App\Models\RemesaRealizada;

class RemesaPOSController extends Controller
{
    public function form()
    {
        $rangos = \App\Models\RemesaConfig::all();
        return view('pos.remesas.form', compact('rangos'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'monto' => 'required|numeric|min:0',
            'banco_id' => 'required|exists:bancos,id',
            'referencia' => 'nullable|string|max:255',
        ]);

        $config = RemesaConfig::where('monto_min', '<=', $request->monto)
            ->where('monto_max', '>=', $request->monto)
            ->first();

        if (!$config) {
            return back()->with('error', '⚠️ No hay comisión definida para este monto.');
        }

        RemesaRealizada::create([
            'user_id' => auth()->id(),
            'banco_id' => $request->banco_id,
            'monto' => $request->monto,
            'comision' => $config->comision,
            'referencia' => $request->referencia,
        ]);

        return redirect()->route('pos')->with('success', '✅ Remesa registrada exitosamente.');
    }
}
