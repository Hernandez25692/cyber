<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cierre;
use App\Models\User;
use Illuminate\Http\Request;

class ReporteCierresController extends Controller
{
    public function index(Request $request)
    {
        $users = User::orderBy('name')->get();

        // Filtros (por defecto: último mes hasta hoy)
        $desde = $request->input('desde', now()->subMonth()->format('Y-m-d'));
        $hasta = $request->input('hasta', now()->format('Y-m-d'));
        $user_id = $request->input('user_id');
        $estado  = $request->input('estado', 'todos'); // 'todos' | 'cerrado' | 'pendiente'

        $desdeCompleto = $desde . ' 00:00:00';
        $hastaCompleto = $hasta . ' 23:59:59';

        // Listado
        $cierres = Cierre::with(['apertura.usuario'])
            // usamos updated_at porque el cierre se "mueve" con updateOrCreate / finalizar
            ->whereBetween('updated_at', [$desdeCompleto, $hastaCompleto])
            ->when($user_id, function ($q) use ($user_id) {
                $q->whereHas('apertura', fn($qa) => $qa->where('user_id', $user_id));
            })
            ->when($estado !== 'todos', function ($q) use ($estado) {
                if ($estado === 'cerrado') {
                    $q->where('pendiente', false)->where('reporte_z_generado', true);
                } elseif ($estado === 'pendiente') {
                    $q->where('pendiente', true);
                }
            })
            ->orderByDesc('updated_at')
            ->paginate(20)
            ->withQueryString();

        // Totales visibles en la vista
        $totales = [
            'registros'  => $cierres->total(),
            'ingresos'   => $cierres->sum('total_ingresos'),
            'egresos'    => $cierres->sum('total_egresos'),
            'diferencia' => $cierres->sum('diferencia'),
        ];

        return view('admin.reportes.cierres', [
            'users'   => $users,
            'cierres' => $cierres,
            'totales' => $totales,
            'filtros' => [
                'desde'   => $desde,
                'hasta'   => $hasta,
                'user_id' => $user_id,
                'estado'  => $estado,
            ],
        ]);
    }
}
