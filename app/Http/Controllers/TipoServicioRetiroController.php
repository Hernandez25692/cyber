<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoServicio;
use Illuminate\Support\Facades\Auth;

class TipoServicioRetiroController extends Controller
{
    public function index()
    {
        $retiros = TipoServicio::where('categoria', 'retiro')->orderBy('monto_min')->get();
        return view('admin.retiros.config.index', compact('retiros'));
    }

    public function create()
    {
        return view('admin.retiros.config.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'monto_min' => 'required|numeric',
            'monto_max' => 'required|numeric|gt:monto_min',
            'comision' => 'required|numeric|min:0',
        ]);

        TipoServicio::create([
            'nombre' => $request->nombre,
            'monto_min' => $request->monto_min,
            'monto_max' => $request->monto_max,
            'comision' => $request->comision,
            'categoria' => 'retiro',
            'banco' => null, // opcional
        ]);

        return redirect()->route('admin.retiros.config.index')->with('success', '✅ Rango de retiro guardado.');
    }

    public function destroy($id)
    {
        TipoServicio::findOrFail($id)->delete();
        return back()->with('success', '🗑️ Rango eliminado.');
    }
}
