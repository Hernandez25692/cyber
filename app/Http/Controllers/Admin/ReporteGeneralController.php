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

class ReporteGeneralController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();

        $desde = $request->input('desde', now()->subMonth()->format('Y-m-d')) . ' 00:00:00';
        $hasta = $request->input('hasta', now()->format('Y-m-d')) . ' 23:59:59';
        $user_id = $request->user_id;

        // Remesas
        $remesas = RemesaRealizada::with('user', 'banco')
            ->whereBetween('created_at', [$desde, $hasta]);
        // Retiros
        $retiros = RetiroRealizado::with('user', 'banco')
            ->whereBetween('created_at', [$desde, $hasta]);
        // Servicios
        $servicios = ServicioRealizado::with('user', 'tipoServicio', 'banco')
            ->whereBetween('created_at', [$desde, $hasta]);
        // Recargas
        $recargas = RecargaRealizada::with('user', 'proveedor')
            ->whereBetween('created_at', [$desde, $hasta]);
        // Impresiones
        $impresiones = ImpresionRealizada::with('user', 'servicio', 'tipo')
            ->whereBetween('created_at', [$desde, $hasta]);

        // Si hay filtro por usuario
        if ($user_id) {
            $remesas->where('user_id', $user_id);
            $retiros->where('user_id', $user_id);
            $servicios->where('user_id', $user_id);
            $recargas->where('user_id', $user_id);
            $impresiones->where('user_id', $user_id);
        }

        return view('admin.reportes.general', [
            'users' => $users,
            'remesas' => $remesas->get(),
            'retiros' => $retiros->get(),
            'servicios' => $servicios->get(),
            'recargas' => $recargas->get(),
            'impresiones' => $impresiones->get(),
            'filtros' => [
                'desde' => substr($desde, 0, 10),
                'hasta' => substr($hasta, 0, 10),
                'user_id' => $user_id,
            ]
        ]);
    }
}
