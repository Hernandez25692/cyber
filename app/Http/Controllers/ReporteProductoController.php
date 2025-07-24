<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\User;
use Carbon\Carbon;

class ReporteProductoController extends Controller
{
    public function reporteUtilidad(Request $request)
    {
        $desde = $request->input('desde') ?? Carbon::now()->startOfMonth()->format('Y-m-d');
        $hasta = $request->input('hasta') ?? Carbon::now()->endOfMonth()->format('Y-m-d');
        $user_id = $request->input('user_id');

        $detalles = DetalleVenta::with('venta.user', 'producto')
            ->whereHas('venta', function ($q) use ($desde, $hasta, $user_id) {
                $q->whereBetween('created_at', [$desde . ' 00:00:00', $hasta . ' 23:59:59']);
                if ($user_id) {
                    $q->where('user_id', $user_id);
                }
            })
            ->get();

        $filtros = [
            'desde' => $desde,
            'hasta' => $hasta,
            'user_id' => $user_id,
        ];

        $usuarios = User::all();

        return view('admin.reportes.utilidad_productos', compact('detalles', 'filtros', 'usuarios'));
    }
}
