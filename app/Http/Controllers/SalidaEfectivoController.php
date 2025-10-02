<?php

namespace App\Http\Controllers;

use App\Models\SalidaEfectivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Apertura;
use App\Models\Cierre;
class SalidaEfectivoController extends Controller
{
    // Listado con filtros por fecha y cajero
    public function index(Request $request)
    {
        $qUser   = $request->get('user_id');
        $qFrom   = $request->get('from');
        $qTo     = $request->get('to');

        $salidas = SalidaEfectivo::with(['usuario'])
            ->when($qUser, fn($qq) => $qq->where('user_id', $qUser))
            ->when($qFrom, fn($qq) => $qq->whereDate('fecha_hora', '>=', $qFrom))
            ->when($qTo,   fn($qq) => $qq->whereDate('fecha_hora', '<=', $qTo))
            ->orderBy('fecha_hora', 'desc')
            ->paginate(20)
            ->appends($request->only(['user_id', 'from', 'to']));

        $usuarios = \App\Models\User::orderBy('name')->get(['id', 'name']);

        return view('salidas.index', compact('salidas', 'usuarios', 'qUser', 'qFrom', 'qTo'));
    }

    // Registro vía modal (AJAX)
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'motivo' => ['required', 'string', 'max:255'],
            'monto'  => ['required', 'numeric', 'min:0.01'],
            'observacion' => ['nullable', 'string', 'max:1000'],
        ], [
            'motivo.required' => 'El motivo es obligatorio.',
            'monto.required'  => 'El monto es obligatorio.',
            'monto.min'       => 'El monto debe ser mayor a 0.',
        ]);

        if ($validator->fails()) {
            return response()->json(['ok' => false, 'errors' => $validator->errors()], 422);
        }

        $userId = \Auth::id();

        // 1) Apertura vigente del cajero
        $apertura = \App\Models\Apertura::where('user_id', $userId)->latest()->first();
        if (!$apertura) {
            return response()->json([
                'ok' => false,
                'message' => 'No hay una apertura de caja vigente para este usuario.',
            ], 422);
        }

        // 2) (Opcional) Cierre pendiente asociado a esa apertura
        $cierrePendiente = \App\Models\Cierre::where('apertura_id', $apertura->id)
            ->where('pendiente', true)
            ->orderByDesc('id')
            ->first();

        // 3) Registrar salida
        $salida = \App\Models\SalidaEfectivo::create([
            'user_id'     => $userId,
            'cierre_id'   => $cierrePendiente?->id, // puede quedar null y no pasa nada
            'motivo'      => $request->input('motivo'),
            'monto'       => $request->input('monto'),
            'observacion' => $request->input('observacion'),
            'fecha_hora'  => now(),
        ]);

        return response()->json([
            'ok'     => true,
            'id'     => $salida->id,
            'monto'  => (string) $salida->monto,
            'motivo' => $salida->motivo,
            'hora'   => $salida->fecha_hora->format('Y-m-d H:i:s'),
        ]);
    }
}
