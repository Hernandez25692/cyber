<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DepositoConfig;

class DepositoConfigController extends Controller
{
    public function index()
    {
        $rangos = DepositoConfig::orderBy('monto_min')->get();
        return view('admin.depositos.config.index', compact('rangos'));
    }

    public function create()
    {
        return view('admin.depositos.config.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'    => 'required|string|max:255',
            'monto_min' => 'required|numeric|min:0',
            'monto_max' => 'required|numeric|gt:monto_min',
            'comision'  => 'required|numeric|min:0',
        ]);

        DepositoConfig::create($request->only(['nombre', 'monto_min', 'monto_max', 'comision']));

        return redirect()->route('admin.depositos.config.index')
            ->with('success', 'Rango guardado correctamente');
    }

    // 🔹 NUEVO
    public function edit(DepositoConfig $deposito)
    {
        return view('admin.depositos.config.edit', compact('deposito'));
    }

    // 🔹 NUEVO
    public function update(Request $request, DepositoConfig $deposito)
    {
        $request->validate([
            'nombre'    => 'required|string|max:255',
            'monto_min' => 'required|numeric|min:0',
            'monto_max' => 'required|numeric|gt:monto_min',
            'comision'  => 'required|numeric|min:0',
        ]);

        $deposito->update($request->only(['nombre', 'monto_min', 'monto_max', 'comision']));

        return redirect()->route('admin.depositos.config.index')
            ->with('success', 'Rango actualizado correctamente');
    }

    public function destroy(DepositoConfig $deposito)
    {
        $deposito->delete();
        return back()->with('success', 'Rango eliminado');
    }
}
