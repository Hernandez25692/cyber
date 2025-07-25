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
use Carbon\Carbon;

class ReporteCyberController extends Controller
{
    public function index(Request $request)
    {
        $desde = $request->input('desde', now()->subMonth()->format('Y-m-d'));
        $hasta = $request->input('hasta', now()->format('Y-m-d'));
        $user_id = $request->input('user_id');
        $modulo = $request->input('modulo', 'todos'); // por defecto todos los módulos

        $desdeCompleto = $desde . ' 00:00:00';
        $hastaCompleto = $hasta . ' 23:59:59';

        $users = User::all();

        // Consultas con relaciones
        $remesas = RemesaRealizada::with('banco', 'usuario')
            ->when($user_id, fn($q) => $q->where('user_id', $user_id))
            ->whereBetween('created_at', [$desdeCompleto, $hastaCompleto])
            ->get();

        $retiros = RetiroRealizado::with('banco', 'usuario')
            ->when($user_id, fn($q) => $q->where('user_id', $user_id))
            ->whereBetween('created_at', [$desdeCompleto, $hastaCompleto])
            ->get();

        $servicios = ServicioRealizado::with('tipoServicio', 'banco', 'usuario')
            ->when($user_id, fn($q) => $q->where('user_id', $user_id))
            ->whereBetween('created_at', [$desdeCompleto, $hastaCompleto])
            ->get();

        $recargas = RecargaRealizada::with('paquete.proveedor', 'usuario')
            ->when($user_id, fn($q) => $q->where('user_id', $user_id))
            ->whereBetween('created_at', [$desdeCompleto, $hastaCompleto])
            ->get();

        $impresiones = ImpresionRealizada::with('servicio', 'tipo', 'usuario')
            ->when($user_id, fn($q) => $q->where('user_id', $user_id))
            ->whereBetween('created_at', [$desdeCompleto, $hastaCompleto])
            ->get();

        $productos = DetalleVenta::with('producto', 'venta.user')
            ->whereHas('venta', function ($q) use ($desdeCompleto, $hastaCompleto, $user_id) {
                $q->whereBetween('created_at', [$desdeCompleto, $hastaCompleto]);
                if ($user_id) {
                    $q->where('user_id', $user_id);
                }
            })
            ->get();

        return view('admin.reportes.cyber', [
            'users' => $users,
            'filtros' => [
                'desde' => $desde,
                'hasta' => $hasta,
                'user_id' => $user_id,
                'modulo' => $modulo,
            ],
            'remesas' => $remesas,
            'retiros' => $retiros,
            'servicios' => $servicios,
            'recargas' => $recargas,
            'impresiones' => $impresiones,
            'productos' => $productos,
        ]);
    }
}
