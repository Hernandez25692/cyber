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
            'nombre' => 'required|string|max:255',
            'monto_min' => 'required|numeric|min:0',
            'monto_max' => 'required|numeric|gt:monto_min',
            'comision' => 'required|numeric|min:0',
        ]);

        RemesaConfig::create($request->all());

        return redirect()->route('admin.remesas.index')->with('success', '✅ Comisión registrada correctamente.');
    }

    public function destroy($id)
    {
        $remesa = RemesaConfig::findOrFail($id);
        $remesa->delete();

        return redirect()->route('admin.remesas.index')->with('success', '✅ Comisión eliminada correctamente.');
    }
}
