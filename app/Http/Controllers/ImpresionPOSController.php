<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImpresionRealizada;
use Illuminate\Support\Facades\Auth;

class ImpresionPOSController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'servicio_id' => 'required|exists:servicios_impresion,id',
            'tipo_id' => 'required|exists:tipos_impresion,id',
            'precio' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string|max:255'
        ]);

        ImpresionRealizada::create([
            'servicio_id' => $request->servicio_id,
            'tipo_id' => $request->tipo_id,
            'precio' => $request->precio,
            'descripcion' => $request->descripcion,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('pos')->with('success', '🖨️ Impresión registrada correctamente.');
    }
}
