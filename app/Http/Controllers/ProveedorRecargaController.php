<?php

namespace App\Http\Controllers;

use App\Models\ProveedorRecarga;
use Illuminate\Http\Request;

class ProveedorRecargaController extends Controller
{
    public function index()
    {
        $proveedores = ProveedorRecarga::all();
        return view('admin.recargas.proveedores.index', compact('proveedores'));
    }

    public function create()
    {
        return view('admin.recargas.proveedores.create');
    }

    public function store(Request $request)
    {
        $request->validate(['nombre' => 'required|string|max:50']);
        ProveedorRecarga::create($request->only('nombre'));

        return redirect()->route('admin.recargas.proveedores.index')->with('success', 'Proveedor creado correctamente.');
    }

    public function destroy($id)
    {
        ProveedorRecarga::findOrFail($id)->delete();
        return back()->with('success', 'Proveedor eliminado.');
    }
}
