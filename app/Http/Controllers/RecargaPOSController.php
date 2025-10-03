<?php

namespace App\Http\Controllers;

use App\Models\RecargaRealizada;
use App\Models\PaqueteRecarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecargaPOSController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'paquete_id' => 'required|exists:paquetes_recarga,id',
            'numero'     => 'nullable|string|max:20',
        ]);

        // Traemos el paquete para leer precios al momento de la transacción
        $paquete = PaqueteRecarga::findOrFail($request->paquete_id);

        $precioCompra = (float) $paquete->precio_compra;
        $precioVenta  = (float) $paquete->precio_venta;
        $comision     = round($precioVenta - $precioCompra, 2);

        RecargaRealizada::create([
            'paquete_id'    => $paquete->id,
            'numero'        => $request->numero,
            'user_id'       => Auth::id(),
            'precio_compra' => $precioCompra,
            'precio_venta'  => $precioVenta,
            'comision'      => $comision,
        ]);

        return redirect()->route('pos')->with('success', '✅ Recarga registrada con éxito.');
    }

    // AJAX para obtener paquetes dinámicamente (solo lo que necesita el POS)
    public function paquetesPorProveedor($id)
    {
        return response()->json(
            \App\Models\PaqueteRecarga::where('proveedor_id', $id)
                ->get(['id', 'descripcion', 'precio_venta']) // importante: enviar precio_venta
        );
    }
}
