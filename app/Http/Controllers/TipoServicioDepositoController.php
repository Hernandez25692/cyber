<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoServicio;

class TipoServicioDepositoController extends Controller
{
    public function index()
    {
        $depositos = TipoServicio::where('categoria', 'deposito')->orderBy('monto_min')->get();
        return view('admin.depositos.config.index', compact('depositos'));
    }

    public function create()
    {
        return view('admin.depositos.config.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'    => 'required|string',
            'monto_min' => 'required|numeric',
            'monto_max' => 'required|numeric|gt:monto_min',
            'comision'  => 'required|numeric|min:0',
        ]);

        TipoServicio::create([
            'nombre'    => $request->nombre,
            'monto_min' => $request->monto_min,
            'monto_max' => $request->monto_max,
            'comision'  => $request->comision,
            'categoria' => 'deposito',
            'banco'     => null,
        ]);

        return redirect()->route('admin.depositos.config.index')->with('success', '✅ Rango de depósito guardado.');
    }

    public function destroy($id)
    {
        TipoServicio::findOrFail($id)->delete();
        return back()->with('success', '🗑️ Rango eliminado.');
    }
}
