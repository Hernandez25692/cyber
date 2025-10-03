<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ReporteGananciasController extends Controller
{
    /**
     * Vista con filtros.
     */
    public function index(Request $request)
    {
        $usuarios = User::orderBy('name')->get(['id', 'name']);
        return view('admin.reportes.ganancias.index', compact('usuarios'));
    }

    /**
     * Datos JSON para el reporte (filtros: desde, hasta, user_id, servicios[]).
     */
    public function data(Request $request)
    {
        $request->validate([
            'desde'     => 'nullable|date',
            'hasta'     => 'nullable|date',
            'cajero_id' => 'nullable|integer|exists:users,id',
            'servicios' => 'nullable|array', // ['ventas','recargas','remesas','retiros','depositos','impresiones','servicios']
        ]);

        $desde     = $request->input('desde');
        $hasta     = $request->input('hasta');
        $cajeroId  = $request->input('cajero_id');
        $servicios = $request->input('servicios', []);

        if (empty($servicios)) {
            $servicios = ['ventas', 'recargas', 'remesas', 'retiros', 'depositos', 'impresiones', 'servicios'];
        }

        $resumen = [
            'totales' => ['ingresos' => 0.0, 'costos' => 0.0, 'comisiones' => 0.0, 'ganancias' => 0.0],
            'por_categoria' => [],
            'detalles' => [],
        ];

        $aplicaRango = function ($q, $col) use ($desde, $hasta) {
            if ($desde) $q->whereDate($col, '>=', $desde);
            if ($hasta) $q->whereDate($col, '<=', $hasta);
        };
        $aplicaCajero = function ($q, $col) use ($cajeroId) {
            if ($cajeroId) $q->where($col, $cajeroId);
        };

        /* =======================
         * 1) VENTAS DE PRODUCTOS
         * ======================= */
        if (in_array('ventas', $servicios)) {
            // detalle_ventas: venta_id, producto_id, cantidad, precio_unitario, subtotal
            // productos: precio_compra
            // ventas: user_id, created_at
            $ventasQ = DB::table('ventas as v')
                ->join('detalle_ventas as d', 'd.venta_id', '=', 'v.id')
                ->leftJoin('productos as p', 'p.id', '=', 'd.producto_id')
                ->select(
                    'v.id as venta_id',
                    'v.created_at as fecha',
                    'v.user_id as user_id',
                    DB::raw('SUM(d.precio_unitario * d.cantidad) as ingreso'),
                    DB::raw('SUM(COALESCE(p.precio_compra, 0) * d.cantidad) as costo'),
                    DB::raw('SUM( (d.precio_unitario - COALESCE(p.precio_compra, 0)) * d.cantidad ) as ganancia')
                )
                ->groupBy('v.id', 'v.created_at', 'v.user_id');

            $aplicaRango($ventasQ, 'v.created_at');
            $aplicaCajero($ventasQ, 'v.user_id');

            $ventas = $ventasQ->get();

            $cat = 'ventas';
            $resumen['por_categoria'][$cat] = [
                'ingresos' => 0.0,
                'costos' => 0.0,
                'comisiones' => 0.0,
                'ganancias' => 0.0,
                'items' => count($ventas)
            ];

            foreach ($ventas as $r) {
                $resumen['por_categoria'][$cat]['ingresos']  += (float)$r->ingreso;
                $resumen['por_categoria'][$cat]['costos']    += (float)$r->costo;
                $resumen['por_categoria'][$cat]['ganancias'] += (float)$r->ganancia;

                $resumen['detalles'][] = [
                    'categoria' => 'Ventas de productos',
                    'fecha'     => $r->fecha,
                    'cajero'    => optional(User::find($r->user_id))->name,
                    'referencia' => 'Venta #' . $r->venta_id,
                    'ingreso'   => (float)$r->ingreso,
                    'costo'     => (float)$r->costo,
                    'comision'  => 0.0,
                    'ganancia'  => (float)$r->ganancia,
                ];
            }
        }

        /* ============
         * 2) RECARGAS
         * ============ */
        if (in_array('recargas', $servicios)) {
            // recargas_realizadas: precio_compra, precio_venta, comision, user_id, created_at
            $q = DB::table('recargas_realizadas as r')
                ->select(
                    'r.id',
                    'r.created_at as fecha',
                    'r.user_id',
                    'r.precio_venta',
                    'r.precio_compra',
                    'r.comision'
                );

            $aplicaRango($q, 'r.created_at');
            $aplicaCajero($q, 'r.user_id');

            $rows = $q->get();
            $cat = 'recargas';
            $resumen['por_categoria'][$cat] = [
                'ingresos' => 0.0,
                'costos' => 0.0,
                'comisiones' => 0.0,
                'ganancias' => 0.0,
                'items' => count($rows)
            ];

            foreach ($rows as $r) {
                $venta  = (float)$r->precio_venta;
                $compra = (float)$r->precio_compra;
                $comi   = (float)$r->comision;

                $resumen['por_categoria'][$cat]['ingresos']   += $venta;
                $resumen['por_categoria'][$cat]['costos']     += $compra;
                $resumen['por_categoria'][$cat]['comisiones'] += $comi;
                $resumen['por_categoria'][$cat]['ganancias']  += $comi;

                $resumen['detalles'][] = [
                    'categoria' => 'Recargas',
                    'fecha'     => $r->fecha,
                    'cajero'    => optional(User::find($r->user_id))->name,
                    'referencia' => 'Recarga #' . $r->id,
                    'ingreso'   => $venta,
                    'costo'     => $compra,
                    'comision'  => $comi,
                    'ganancia'  => $comi,
                ];
            }
        }

        /* ===========
         * 3) REMESAS
         * =========== */
        if (in_array('remesas', $servicios)) {
            // remesas_realizadas: monto, comision, user_id, created_at
            $q = DB::table('remesas_realizadas as m')
                ->select('m.id', 'm.created_at as fecha', 'm.user_id', 'm.monto', 'm.comision');

            $aplicaRango($q, 'm.created_at');
            $aplicaCajero($q, 'm.user_id');

            $rows = $q->get();
            $cat = 'remesas';
            $resumen['por_categoria'][$cat] = [
                'ingresos' => 0.0,
                'costos' => 0.0,
                'comisiones' => 0.0,
                'ganancias' => 0.0,
                'items' => count($rows)
            ];

            foreach ($rows as $r) {
                $ing = (float)$r->monto;
                $com = (float)$r->comision;
                $gan = $com;

                $resumen['por_categoria'][$cat]['ingresos']   += $ing;
                $resumen['por_categoria'][$cat]['comisiones'] += $com;
                $resumen['por_categoria'][$cat]['ganancias']  += $gan;

                $resumen['detalles'][] = [
                    'categoria' => 'Remesas',
                    'fecha'     => $r->fecha,
                    'cajero'    => optional(User::find($r->user_id))->name,
                    'referencia' => 'Remesa #' . $r->id,
                    'ingreso'   => $ing,
                    'costo'     => 0.0,
                    'comision'  => $com,
                    'ganancia'  => $gan,
                ];
            }
        }

        /* ==========
         * 4) RETIROS
         * ========== */
        if (in_array('retiros', $servicios)) {
            // retiros_realizados: monto, comision, user_id, created_at
            $q = DB::table('retiros_realizados as r')
                ->select('r.id', 'r.created_at as fecha', 'r.user_id', 'r.monto', 'r.comision');

            $aplicaRango($q, 'r.created_at');
            $aplicaCajero($q, 'r.user_id');

            $rows = $q->get();
            $cat = 'retiros';
            $resumen['por_categoria'][$cat] = [
                'ingresos' => 0.0,
                'costos' => 0.0,
                'comisiones' => 0.0,
                'ganancias' => 0.0,
                'items' => count($rows)
            ];

            foreach ($rows as $r) {
                $ing = (float)$r->monto;
                $com = (float)$r->comision;
                $gan = $com;

                $resumen['por_categoria'][$cat]['ingresos']   += $ing;
                $resumen['por_categoria'][$cat]['comisiones'] += $com;
                $resumen['por_categoria'][$cat]['ganancias']  += $gan;

                $resumen['detalles'][] = [
                    'categoria' => 'Retiros',
                    'fecha'     => $r->fecha,
                    'cajero'    => optional(User::find($r->user_id))->name,
                    'referencia' => 'Retiro #' . $r->id,
                    'ingreso'   => $ing,
                    'costo'     => 0.0,
                    'comision'  => $com,
                    'ganancia'  => $gan,
                ];
            }
        }

        /* ============
         * 5) DEPÓSITOS
         * ============ */
        if (in_array('depositos', $servicios)) {
            // depositos_realizados: monto, comision, user_id, created_at
            $q = DB::table('depositos_realizados as d')
                ->select('d.id', 'd.created_at as fecha', 'd.user_id', 'd.monto', 'd.comision');

            $aplicaRango($q, 'd.created_at');
            $aplicaCajero($q, 'd.user_id');

            $rows = $q->get();
            $cat = 'depositos';
            $resumen['por_categoria'][$cat] = [
                'ingresos' => 0.0,
                'costos' => 0.0,
                'comisiones' => 0.0,
                'ganancias' => 0.0,
                'items' => count($rows)
            ];

            foreach ($rows as $r) {
                $ing = (float)$r->monto;
                $com = (float)$r->comision;
                $gan = $com;

                $resumen['por_categoria'][$cat]['ingresos']   += $ing;
                $resumen['por_categoria'][$cat]['comisiones'] += $com;
                $resumen['por_categoria'][$cat]['ganancias']  += $gan;

                $resumen['detalles'][] = [
                    'categoria' => 'Depósitos',
                    'fecha'     => $r->fecha,
                    'cajero'    => optional(User::find($r->user_id))->name,
                    'referencia' => 'Depósito #' . $r->id,
                    'ingreso'   => $ing,
                    'costo'     => 0.0,
                    'comision'  => $com,
                    'ganancia'  => $gan,
                ];
            }
        }

        /* =================
         * 6) IMPRESIONES
         * ================= */
        if (in_array('impresiones', $servicios)) {
            // impresiones_realizadas: precio, user_id, created_at
            $q = DB::table('impresiones_realizadas as i')
                ->select('i.id', 'i.created_at as fecha', 'i.user_id', 'i.precio');

            $aplicaRango($q, 'i.created_at');
            $aplicaCajero($q, 'i.user_id');

            $rows = $q->get();
            $cat = 'impresiones';
            $resumen['por_categoria'][$cat] = [
                'ingresos' => 0.0,
                'costos' => 0.0,
                'comisiones' => 0.0,
                'ganancias' => 0.0,
                'items' => count($rows)
            ];

            foreach ($rows as $r) {
                $ing = (float)$r->precio;
                $gan = $ing;

                $resumen['por_categoria'][$cat]['ingresos']  += $ing;
                $resumen['por_categoria'][$cat]['ganancias'] += $gan;

                $resumen['detalles'][] = [
                    'categoria' => 'Impresiones',
                    'fecha'     => $r->fecha,
                    'cajero'    => optional(User::find($r->user_id))->name,
                    'referencia' => 'Impresión #' . $r->id,
                    'ingreso'   => $ing,
                    'costo'     => 0.0,
                    'comision'  => 0.0,
                    'ganancia'  => $gan,
                ];
            }
        }

        /* =========================
         * 7) SERVICIOS GENERALES
         * ========================= */
        if (in_array('servicios', $servicios)) {
            // servicios_realizados: total, comision, user_id, created_at
            $q = DB::table('servicios_realizados as s')
                ->select('s.id', 's.created_at as fecha', 's.user_id', 's.total', 's.comision');

            $aplicaRango($q, 's.created_at');
            $aplicaCajero($q, 's.user_id');

            $rows = $q->get();
            $cat = 'servicios';
            $resumen['por_categoria'][$cat] = [
                'ingresos' => 0.0,
                'costos' => 0.0,
                'comisiones' => 0.0,
                'ganancias' => 0.0,
                'items' => count($rows)
            ];

            foreach ($rows as $r) {
                $ing = (float)$r->total;
                $com = (float)$r->comision;
                $gan = $com;

                $resumen['por_categoria'][$cat]['ingresos']   += $ing;
                $resumen['por_categoria'][$cat]['comisiones'] += $com;
                $resumen['por_categoria'][$cat]['ganancias']  += $gan;

                $resumen['detalles'][] = [
                    'categoria' => 'Servicios',
                    'fecha'     => $r->fecha,
                    'cajero'    => optional(User::find($r->user_id))->name,
                    'referencia' => 'Servicio #' . $r->id,
                    'ingreso'   => $ing,
                    'costo'     => 0.0,
                    'comision'  => $com,
                    'ganancia'  => $gan,
                ];
            }
        }

        // Totales globales
        foreach ($resumen['por_categoria'] as $cat => $v) {
            $resumen['totales']['ingresos']   += $v['ingresos'];
            $resumen['totales']['costos']     += $v['costos'];
            $resumen['totales']['comisiones'] += $v['comisiones'];
            $resumen['totales']['ganancias']  += $v['ganancias'];
        }

        return response()->json($resumen);
    }
}
