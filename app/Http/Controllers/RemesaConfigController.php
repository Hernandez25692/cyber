<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RemesaConfig;

class RemesaConfigController extends Controller
{
    public function index()
    {
        $remesas = RemesaConfig::all();
        return view('admin.remesas.index', compact('remesas'));
    }

    public function create()
    {
        return view('admin.remesas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'     => 'required|string|max:255',
            'monto_min'  => 'required|numeric|min:0',
            'monto_max'  => 'required|numeric|gt:monto_min',
            'comision'   => 'required|numeric|min:0',
        ]);

        RemesaConfig::create($request->only(['nombre', 'monto_min', 'monto_max', 'comision']));

        return redirect()->route('admin.remesas.index')
            ->with('success', '✅ Comisión registrada correctamente.');
    }

    // NUEVO: Editar
    public function edit(RemesaConfig $remesa)
    {
        return view('admin.remesas.edit', compact('remesa'));
    }

    // NUEVO: Actualizar
    public function update(Request $request, RemesaConfig $remesa)
    {
        $request->validate([
            'nombre'     => 'required|string|max:255',
            'monto_min'  => 'required|numeric|min:0',
            'monto_max'  => 'required|numeric|gt:monto_min',
            'comision'   => 'required|numeric|min:0',
        ]);

        $remesa->update($request->only(['nombre', 'monto_min', 'monto_max', 'comision']));

        return redirect()->route('admin.remesas.index')
            ->with('success', '✅ Comisión actualizada correctamente.');
    }

    public function destroy($id)
    {
        $remesa = RemesaConfig::findOrFail($id);
        $remesa->delete();

        return redirect()->route('admin.remesas.index')
            ->with('success', '✅ Comisión eliminada correctamente.');
    }
}
