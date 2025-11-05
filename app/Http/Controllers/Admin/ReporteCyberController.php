<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RemesaRealizada;
use App\Models\RetiroRealizado;
use App\Models\ServicioRealizado;
use App\Models\RecargaRealizada;
use App\Models\ImpresionRealizada;
use App\Models\DetalleVenta;
use App\Models\DepositoRealizado;
use App\Models\SalidaEfectivo;
use App\Models\Consumo; // 👈 nuevo
use Carbon\Carbon;

class ReporteCyberController extends Controller
{
    public function index(Request $request)
    {
        $desde   = $request->input('desde', now()->subMonth()->format('Y-m-d'));
        $hasta   = $request->input('hasta', now()->format('Y-m-d'));
        $user_id = $request->input('user_id');
        $modulo  = $request->input('modulo', 'todos'); // por defecto todos los módulos

        $desdeCompleto = $desde . ' 00:00:00';
        $hastaCompleto = $hasta . ' 23:59:59';

        $users = User::all();

        // === Salidas de efectivo ===
        $salidas = SalidaEfectivo::with('usuario')
            ->when($user_id, fn($q) => $q->where('user_id', $user_id))
            ->where(function ($q) use ($desdeCompleto, $hastaCompleto) {
                $q->whereBetween('fecha_hora', [$desdeCompleto, $hastaCompleto])
                    ->orWhere(function ($qq) use ($desdeCompleto, $hastaCompleto) {
                        $qq->whereNull('fecha_hora')
                            ->whereBetween('created_at', [$desdeCompleto, $hastaCompleto]);
                    });
            })
            ->orderByDesc('fecha_hora')
            ->orderByDesc('created_at')
            ->get();

        $total_salidas = $salidas->sum('monto');

        // === Remesas ===
        $remesas = RemesaRealizada::with('banco', 'usuario')
            ->when($user_id, fn($q) => $q->where('user_id', $user_id))
            ->whereBetween('created_at', [$desdeCompleto, $hastaCompleto])
            ->get();

        // === Retiros ===
        $retiros = RetiroRealizado::with('banco', 'usuario')
            ->when($user_id, fn($q) => $q->where('user_id', $user_id))
            ->whereBetween('created_at', [$desdeCompleto, $hastaCompleto])
            ->get();

        // === Depósitos ===
        $depositos = DepositoRealizado::with('banco', 'usuario')
            ->when($user_id, fn($q) => $q->where('user_id', $user_id))
            ->whereBetween('created_at', [$desdeCompleto, $hastaCompleto])
            ->get();

        // === Servicios ===
        $servicios = ServicioRealizado::with('tipoServicio', 'banco', 'usuario')
            ->when($user_id, fn($q) => $q->where('user_id', $user_id))
            ->whereBetween('created_at', [$desdeCompleto, $hastaCompleto])
            ->get();

        // === Recargas ===
        $recargas = RecargaRealizada::with('paquete.proveedor', 'usuario')
            ->when($user_id, fn($q) => $q->where('user_id', $user_id))
            ->whereBetween('created_at', [$desdeCompleto, $hastaCompleto])
            ->get();

        // === Impresiones ===
        $impresiones = ImpresionRealizada::with('servicio', 'tipo', 'usuario')
            ->when($user_id, fn($q) => $q->where('user_id', $user_id))
            ->whereBetween('created_at', [$desdeCompleto, $hastaCompleto])
            ->get();

        // === Productos vendidos (detalle) ===
        $productos = DetalleVenta::with('producto', 'venta.user')
            ->whereHas('venta', function ($q) use ($desdeCompleto, $hastaCompleto, $user_id) {
                $q->whereBetween('created_at', [$desdeCompleto, $hastaCompleto]);
                if ($user_id) {
                    $q->where('user_id', $user_id);
                }
            })
            ->get();

        // === Consumos (nuevo bloque) ===
        $consumos = Consumo::with(['producto', 'usuario', 'user']) // por si tienes ambos accessor/relaciones
            ->when($user_id, fn($q) => $q->where('user_id', $user_id))
            ->whereBetween('created_at', [$desdeCompleto, $hastaCompleto])
            ->orderByDesc('created_at')
            ->get();

        $total_consumos = $consumos->sum('total_costo');

        return view('admin.reportes.cyber', [
            'users'   => $users,
            'filtros' => [
                'desde'   => $desde,
                'hasta'   => $hasta,
                'user_id' => $user_id,
                'modulo'  => $modulo,
            ],
            'remesas'        => $remesas,
            'retiros'        => $retiros,
            'depositos'      => $depositos,
            'servicios'      => $servicios,
            'recargas'       => $recargas,
            'impresiones'    => $impresiones,
            'productos'      => $productos,
            'salidas'        => $salidas,
            'total_salidas'  => $total_salidas,
            'consumos'       => $consumos,
            'total_consumos' => $total_consumos,
        ]);
    }
}
