<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apertura;
use App\Models\Cierre;
use App\Models\Banco;
use App\Models\Venta;
use App\Models\RecargaRealizada;
use App\Models\ServicioRealizado;
use App\Models\RemesaRealizada;
use App\Models\RetiroRealizado;
use App\Models\ImpresionRealizada;
use Illuminate\Support\Facades\Auth;
use App\Models\DepositoRealizado;
use App\Models\SalidaEfectivo;

class CierreController extends Controller
{
    public function create()
    {
        $apertura = Apertura::where('user_id', Auth::id())->latest()->firstOrFail();
        $apertura->pos_inicial = json_decode($apertura->pos_inicial, true);
        $bancos = Banco::all();

        $cierre_pendiente = Cierre::where('apertura_id', $apertura->id)->where('pendiente', true)->first();

        return view('cierres.create', compact('apertura', 'bancos', 'cierre_pendiente'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'efectivo_final' => 'required|numeric|min:0',
            'banco_id.*'     => 'required|exists:bancos,id',
            'pos_monto.*'    => 'required|numeric|min:0',
        ]);

        $apertura = Apertura::where('user_id', Auth::id())->latest()->firstOrFail();

        // POS final
        $pos_final = [];
        foreach ($request->banco_id as $index => $id) {
            $pos_final[$id] = $request->pos_monto[$index];
        }

        $desde   = $apertura->created_at;
        $hasta   = now();
        $user_id = Auth::id();

        // ===== INGRESOS BASE (lo facturado que entra a caja)
        $ventas = Venta::whereBetween('created_at', [$desde, $hasta])
            ->where('user_id', $user_id)
            ->sum('total');

        // Recargas a PRECIO DE COMPRA (lo que “consume” del saldo del proveedor)
        $recargas_compra = RecargaRealizada::whereBetween('created_at', [$desde, $hasta])
            ->where('user_id', $user_id)
            ->sum('precio_compra');

        // Servicios: total cobrado (manteniendo tu lógica previa)
        $servicios = ServicioRealizado::whereBetween('created_at', [$desde, $hasta])
            ->where('user_id', $user_id)
            ->sum('total');

        $impresiones = ImpresionRealizada::whereBetween('created_at', [$desde, $hasta])
            ->where('user_id', $user_id)
            ->sum('precio');

        $depositos = DepositoRealizado::whereBetween('created_at', [$desde, $hasta])
            ->where('user_id', $user_id)
            ->sum('monto');

        // ===== COMISIONES (se suman a ingresos)
        $comision_retiros = RetiroRealizado::whereBetween('created_at', [$desde, $hasta])
            ->where('user_id', $user_id)
            ->sum('comision');

        $comision_remesas = RemesaRealizada::whereBetween('created_at', [$desde, $hasta])
            ->where('user_id', $user_id)
            ->sum('comision');

        $comision_servicios = ServicioRealizado::whereBetween('created_at', [$desde, $hasta])
            ->where('user_id', $user_id)
            ->sum('comision');

        $comision_depositos = DepositoRealizado::whereBetween('created_at', [$desde, $hasta])
            ->where('user_id', $user_id)
            ->sum('comision');

        // Comisión de recargas: preferimos columna 'comision'; fallback a (venta - compra) si hiciera falta
        $comision_recargas = RecargaRealizada::whereBetween('created_at', [$desde, $hasta])
            ->where('user_id', $user_id)
            ->get()
            ->sum(function ($r) {
                if (!is_null($r->comision)) return (float)$r->comision;
                // fallback seguro por si existen registros antiguos
                $venta  = (float)($r->precio_venta ?? 0);
                $compra = (float)($r->precio_compra ?? 0);
                return max($venta - $compra, 0);
            });

        $ingresos_comisiones = $comision_servicios + $comision_remesas + $comision_retiros + $comision_depositos + $comision_recargas;

        // 👉 Ingresos totales (base + comisiones)
        $ingresos = $ventas + $recargas_compra + $servicios + $impresiones + $depositos + $ingresos_comisiones;

        // ===== EGRESOS
        $retiros = RetiroRealizado::whereBetween('created_at', [$desde, $hasta])
            ->where('user_id', $user_id)
            ->sum('monto');

        $remesas = RemesaRealizada::whereBetween('created_at', [$desde, $hasta])
            ->where('user_id', $user_id)
            ->sum('monto');

        $salidas_efectivo = SalidaEfectivo::whereBetween('created_at', [$desde, $hasta])
            ->where('user_id', $user_id)
            ->sum('monto');

        $egresos = $retiros + $remesas + $salidas_efectivo;

        // ===== CUADRE
        $esperado   = $apertura->efectivo_inicial + $ingresos - $egresos;
        $diferencia = $request->efectivo_final - $esperado;

        // Guardar/actualizar cierre pendiente
        Cierre::updateOrCreate(
            ['apertura_id' => $apertura->id, 'pendiente' => true],
            [
                'efectivo_final' => $request->efectivo_final,
                'pos_final'      => json_encode($pos_final),
                'total_ingresos' => $ingresos,
                'total_egresos'  => $egresos,
                'diferencia'     => $diferencia,
                'updated_at'     => now(),
            ]
        );

        return redirect()->route('cierres.reporte_z', $apertura->id);
    }



    public function reporteZ($apertura_id)
    {
        $apertura = Apertura::findOrFail($apertura_id);
        $cierre   = Cierre::where('apertura_id', $apertura_id)->orderByDesc('updated_at')->firstOrFail();

        $desde   = $apertura->created_at;
        $hasta   = now();
        $user_id = $apertura->user_id;

        // ===== INGRESOS BASE (para mostrar en la tarjeta "INGRESOS")
        $ventas = Venta::whereBetween('created_at', [$desde, $hasta])
            ->where('user_id', $user_id)
            ->sum('total');

        // Recargas a PRECIO DE COMPRA (lo que se “carga” al saldo con el proveedor)
        $recargas = RecargaRealizada::whereBetween('created_at', [$desde, $hasta])
            ->where('user_id', $user_id)
            ->sum('precio_compra');

        $servicios = ServicioRealizado::whereBetween('created_at', [$desde, $hasta])
            ->where('user_id', $user_id)
            ->sum('total');

        $impresiones = ImpresionRealizada::whereBetween('created_at', [$desde, $hasta])
            ->where('user_id', $user_id)
            ->sum('precio');

        $depositos = DepositoRealizado::whereBetween('created_at', [$desde, $hasta])
            ->where('user_id', $user_id)
            ->sum('monto');

        // ===== COMISIONES (desglose y se suman a ingresos)
        $comision_retiros = RetiroRealizado::whereBetween('created_at', [$desde, $hasta])
            ->where('user_id', $user_id)
            ->sum('comision');

        $comision_remesas = RemesaRealizada::whereBetween('created_at', [$desde, $hasta])
            ->where('user_id', $user_id)
            ->sum('comision');

        $comision_servicios = ServicioRealizado::whereBetween('created_at', [$desde, $hasta])
            ->where('user_id', $user_id)
            ->sum('comision');

        $comision_depositos = DepositoRealizado::whereBetween('created_at', [$desde, $hasta])
            ->where('user_id', $user_id)
            ->sum('comision');

        $comision_recargas = RecargaRealizada::whereBetween('created_at', [$desde, $hasta])
            ->where('user_id', $user_id)
            ->get()
            ->sum(function ($r) {
                if (!is_null($r->comision)) return (float)$r->comision;
                $venta  = (float)($r->precio_venta ?? 0);
                $compra = (float)($r->precio_compra ?? 0);
                return max($venta - $compra, 0);
            });

        $ingresos_comisiones = $comision_servicios + $comision_remesas + $comision_retiros + $comision_depositos + $comision_recargas;

        // ===== EGRESOS
        $retiros = RetiroRealizado::whereBetween('created_at', [$desde, $hasta])
            ->where('user_id', $user_id)
            ->sum('monto');

        $remesas = RemesaRealizada::whereBetween('created_at', [$desde, $hasta])
            ->where('user_id', $user_id)
            ->sum('monto');

        $salidas_efectivo = SalidaEfectivo::whereBetween('created_at', [$desde, $hasta])
            ->where('user_id', $user_id)
            ->sum('monto');

        $egresos = $retiros + $remesas + $salidas_efectivo;

        // ===== TOTALES PARA CUADRE
        // Ingresos = base (ventas + recargas_compra + servicios + impresiones + depósitos) + comisiones (incluida recargas)
        $ingresos = $ventas + $recargas + $impresiones + $servicios + $depositos + $ingresos_comisiones;

        $esperado   = $apertura->efectivo_inicial + $ingresos - $egresos;
        $diferencia = $cierre->efectivo_final - $esperado;

        return view('cierres.reporte_z', compact(
            'apertura',
            'cierre',
            'ventas',
            'recargas',             // << compra
            'servicios',
            'impresiones',
            'depositos',
            'retiros',
            'remesas',
            'comision_remesas',
            'comision_retiros',
            'comision_depositos',
            'comision_servicios',
            'comision_recargas',    // << nuevo en desglose
            'ingresos',
            'ingresos_comisiones',
            'egresos',
            'esperado',
            'diferencia',
            'salidas_efectivo'
        ));
    }




    public function finalizar(Cierre $cierre)
    {
        if ($cierre->diferencia < 0) {
            return redirect()->back()->with('error', 'No se puede cerrar el turno con faltante.');
        }

        $cierre->update([
            'reporte_z_generado' => true,
            'pendiente' => false,
        ]);

        return redirect()->route('pos')->with('success', 'Turno cerrado correctamente.');
    }
}
