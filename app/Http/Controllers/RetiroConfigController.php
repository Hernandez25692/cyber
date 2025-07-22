<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RetiroConfig;

class RetiroConfigController extends Controller
{
    public function index()
    {
        $rangos = RetiroConfig::orderBy('monto_min')->get();
        return view('admin.retiros.config.index', compact('rangos'));
    }

    public function create()
    {
        return view('admin.retiros.config.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'monto_min' => 'required|numeric|min:0',
            'monto_max' => 'required|numeric|gt:monto_min',
            'comision' => 'required|numeric|min:0',
        ]);

        RetiroConfig::create($request->all());
        return redirect()->route('admin.retiros.config.index')->with('success', 'Rango guardado correctamente');
    }

    public function destroy(RetiroConfig $retiro)
    {
        $retiro->delete();
        return back()->with('success', 'Rango eliminado');
    }
}
