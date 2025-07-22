<?php

namespace App\Http\Controllers;

use App\Models\RecargaRealizada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecargaPOSController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'paquete_id' => 'required|exists:paquetes_recarga,id',
            'numero' => 'nullable|string|max:20'
        ]);

        RecargaRealizada::create([
            'paquete_id' => $request->paquete_id,
            'numero' => $request->numero,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('pos')->with('success', '✅ Recarga registrada con éxito.');
    }

    // AJAX para obtener paquetes dinámicamente
    public function paquetesPorProveedor($id)
    {
        return response()->json(
            \App\Models\PaqueteRecarga::where('proveedor_id', $id)->get()
        );
    }
}
