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
            'proveedor_id'   => 'required|exists:proveedores_recarga,id',
            'descripcion'    => 'required|string|max:100',
            'precio_compra'  => 'required|numeric|min:0',
            'precio_venta'   => 'required|numeric|min:0|gte:precio_compra',
        ], [
            'precio_venta.gte' => 'El precio de venta debe ser mayor o igual al precio de compra.',
        ]);

        PaqueteRecarga::create([
            'proveedor_id'  => $request->proveedor_id,
            'descripcion'   => $request->descripcion,
            'precio_compra' => $request->precio_compra,
            'precio_venta'  => $request->precio_venta,
        ]);

        return redirect()->route('admin.recargas.paquetes.index')
            ->with('success', '✅ Paquete creado correctamente.');
    }

    public function edit($id)
    {
        $paquete = PaqueteRecarga::findOrFail($id);
        $proveedores = ProveedorRecarga::all();
        return view('admin.recargas.paquetes.edit', compact('paquete', 'proveedores'));
    }

    public function update(Request $request, $id)
    {
        $paquete = PaqueteRecarga::findOrFail($id);

        $request->validate([
            'proveedor_id'   => 'required|exists:proveedores_recarga,id',
            'descripcion'    => 'required|string|max:100',
            'precio_compra'  => 'required|numeric|min:0',
            'precio_venta'   => 'required|numeric|min:0|gte:precio_compra',
        ], [
            'precio_venta.gte' => 'El precio de venta debe ser mayor o igual al precio de compra.',
        ]);

        $paquete->update([
            'proveedor_id'  => $request->proveedor_id,
            'descripcion'   => $request->descripcion,
            'precio_compra' => $request->precio_compra,
            'precio_venta'  => $request->precio_venta,
        ]);

        return redirect()->route('admin.recargas.paquetes.index')
            ->with('success', '✅ Paquete actualizado correctamente.');
    }

    public function destroy($id)
    {
        PaqueteRecarga::findOrFail($id)->delete();
        return back()->with('success', 'Paquete eliminado.');
    }
}
