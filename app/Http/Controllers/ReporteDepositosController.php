<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DepositoRealizado;

class ReporteDepositosController extends Controller
{
    public function index(Request $request)
    {
        $q = \App\Models\DepositoRealizado::query()->with(['usuario', 'banco'])->latest();

        if ($request->filled('desde')) {
            $q->whereDate('created_at', '>=', $request->desde);
        }
        if ($request->filled('hasta')) {
            $q->whereDate('created_at', '<=', $request->hasta);
        }
        if ($request->filled('banco_id')) {
            $q->where('banco_id', $request->banco_id);
        }
        if ($request->filled('user_id')) {
            $q->where('user_id', $request->user_id);
        }

        $depositos = $q->get();

        // Para selects
        $bancos = \App\Models\Banco::orderBy('nombre')->get(['id', 'nombre']);
        $usuarios = \App\Models\User::orderBy('name')->get(['id', 'name']);

        // Totales rápidos
        $totales = [
            'monto'    => $depositos->sum('monto'),
            'comision' => $depositos->sum('comision'),
            'neto'     => $depositos->sum(fn($d) => $d->monto - $d->comision),
        ];

        return view('admin.reportes.depositos', compact('depositos', 'bancos', 'usuarios', 'totales'));
    }
}
