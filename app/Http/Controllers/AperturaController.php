<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apertura;
use App\Models\Banco;
use Illuminate\Support\Facades\Auth;

class AperturaController extends Controller
{
    public function create()
    {
        $bancos = Banco::all();
        return view('aperturas.create', compact('bancos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'efectivo_inicial' => 'required|numeric|min:0',
            'banco_id.*' => 'nullable|exists:bancos,id',
            'pos_monto.*' => 'nullable|numeric|min:0',
        ]);

        $pos = [];
        foreach ($request->banco_id as $index => $id) {
            $pos[$id] = $request->pos_monto[$index] ?? 0;
        }

        Apertura::create([
            'user_id' => Auth::id(),
            'efectivo_inicial' => $request->efectivo_inicial,
            'pos_inicial' => json_encode($pos),
        ]);

        return redirect()->route('pos')->with('success', 'Turno iniciado correctamente.');
    }
}
