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
use App\Models\DepositoRealizado;

class ReporteGeneralController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();

        $desde = $request->input('desde', now()->subMonth()->format('Y-m-d')) . ' 00:00:00';
        $hasta = $request->input('hasta', now()->format('Y-m-d')) . ' 23:59:59';

        $user_id = $request->user_id;

        // Cargar todas las relaciones necesarias con eager loading
        $remesasQuery = RemesaRealizada::with('banco', 'usuario')->whereBetween('created_at', [$desde, $hasta]);
        $retirosQuery = RetiroRealizado::with('banco', 'usuario')->whereBetween('created_at', [$desde, $hasta]);
        $serviciosQuery = ServicioRealizado::with('tipoServicio', 'banco', 'usuario')->whereBetween('created_at', [$desde, $hasta]);
        $recargasQuery = RecargaRealizada::with('proveedor', 'paquete', 'usuario')->whereBetween('created_at', [$desde, $hasta]);
        $impresionesQuery = ImpresionRealizada::with('servicio', 'tipo', 'usuario')->whereBetween('created_at', [$desde, $hasta]);
        $depositosQuery = DepositoRealizado::with('banco', 'usuario')->whereBetween('created_at', [$desde, $hasta]);

        if ($user_id) {
            $remesasQuery->where('user_id', $user_id);
            $retirosQuery->where('user_id', $user_id);
            $serviciosQuery->where('user_id', $user_id);
            $recargasQuery->where('user_id', $user_id);
            $impresionesQuery->where('user_id', $user_id);
            $depositosQuery->where('user_id', $user_id);
        }

        // Ejecutar queries
        $remesas = $remesasQuery->get();
        $retiros = $retirosQuery->get();
        $servicios = $serviciosQuery->get();
        $recargas = $recargasQuery->get();
        $impresiones = $impresionesQuery->get();
        $depositos = $depositosQuery->get();

        // Cálculos de totales
        $totales = [
            'remesas' => [
                'total' => $remesas->sum('monto'),
                'ganancia' => $remesas->sum('comision'),
            ],
            'retiros' => [
                'total' => $retiros->sum('monto'),
                'ganancia' => $retiros->sum('comision'),
            ],
            'servicios' => [
                'total' => $servicios->sum('comision'), // no hay monto
                'ganancia' => $servicios->sum('comision'),
            ],
            'recargas' => [
                'total' => $recargas->sum(fn($r) => $r->paquete->precio ?? 0),
                'ganancia' => 0, // si manejas comisión se puede ajustar
            ],
            'impresiones' => [
                'total' => $impresiones->sum('precio'),
                'ganancia' => 0, // si manejas comisión, ajusta aquí
            ],
            'depositos' => [
                'total' => $depositos->sum('monto'),
                'ganancia' => $depositos->sum('comision'),
            ],
        ];

        // Resumen general
        $resumen = [
            'total_operaciones' => $remesas->count() + $retiros->count() + $servicios->count() + $recargas->count() + $impresiones->count() + $depositos->count(),
            'total_ganancia' => $totales['remesas']['ganancia'] + $totales['retiros']['ganancia'] + $totales['servicios']['ganancia'] + $totales['depositos']['ganancia'],
            'total_monto' => $totales['remesas']['total'] + $totales['retiros']['total'] + $totales['recargas']['total'] + $totales['impresiones']['total'] + $totales['depositos']['total'],
        ];

        return view('admin.reportes.general', [
            'users' => $users,
            'remesas' => $remesas,
            'retiros' => $retiros,
            'servicios' => $servicios,
            'recargas' => $recargas,
            'impresiones' => $impresiones,
            'depositos' => $depositos,
            'totales' => $totales,
            'resumen' => $resumen,
            'filtros' => [
                'desde' => $desde,
                'hasta' => $hasta,
                'user_id' => $user_id,
            ]
        ]);
    }
}
