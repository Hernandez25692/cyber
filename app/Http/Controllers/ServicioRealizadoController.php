<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServicioRealizado;
use App\Http\Controllers\Controller;
use App\Models\TipoServicio;
use App\Models\Banco;
use App\Models\User;

class ServicioRealizadoController extends Controller
{
    public function index()
    {
        $servicios = \App\Models\ServicioRealizado::with(['tipoServicio', 'banco', 'usuario'])->latest()->get();
        return view('admin.servicios.realizados.index', compact('servicios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo_servicio_id' => 'required|exists:tipos_servicio,id',
            'banco_id' => 'required|exists:bancos,id',
            'comision' => 'required|numeric|min:0',
            'referencia' => 'nullable|string|max:255',
        ]);

        ServicioRealizado::create([
            'tipo_servicio_id' => $request->tipo_servicio_id,
            'banco_id' => $request->banco_id,
            'comision' => $request->comision,
            'referencia' => $request->referencia,
            'user_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Servicio registrado correctamente.');
    }
}
