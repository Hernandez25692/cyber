<?php

namespace App\Http\Controllers;

use App\Models\PaqueteRecarga;
use App\Models\ProveedorRecarga;
use Illuminate\Http\Request;

class PaqueteRecargaController extends Controller
{
    public function index()
    {
        $paquetes = PaqueteRecarga::with('proveedor')->get();
        return view('admin.recargas.paquetes.index', compact('paquetes'));
    }

    public function create()
    {
        $proveedores = ProveedorRecarga::all();
        return view('admin.recargas.paquetes.create', compact('proveedores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'proveedor_id' => 'required|exists:proveedores_recarga,id',
            'descripcion' => 'required|string|max:100',
            'precio' => 'required|numeric|min:1'
        ]);

        PaqueteRecarga::create($request->only('proveedor_id', 'descripcion', 'precio'));
        return redirect()->route('admin.recargas.paquetes.index')->with('success', 'Paquete registrado correctamente.');
    }

    public function destroy($id)
    {
        PaqueteRecarga::findOrFail($id)->delete();
        return back()->with('success', 'Paquete eliminado.');
    }
}
