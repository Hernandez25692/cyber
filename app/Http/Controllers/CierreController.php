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

class CierreController extends Controller
{
    public function create()
    {
        $apertura = Apertura::where('user_id', Auth::id())->latest()->firstOrFail();

        // 🔴 Decodificar JSON manualmente para asegurar que sea array
        $apertura->pos_inicial = json_decode($apertura->pos_inicial, true);

        $bancos = Banco::all();

        return view('cierres.create', compact('apertura', 'bancos'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'efectivo_final' => 'required|numeric|min:0',
            'banco_id.*' => 'required|exists:bancos,id',
            'pos_monto.*' => 'required|numeric|min:0',
        ]);

        $apertura = Apertura::where('user_id', Auth::id())->latest()->firstOrFail();

        $pos_final = [];
        foreach ($request->banco_id as $index => $id) {
            $pos_final[$id] = $request->pos_monto[$index];
        }

        $desde = $apertura->created_at;
        $hasta = now();
        $user_id = Auth::id();

        $ventas = Venta::whereBetween('created_at', [$desde, $hasta])->where('user_id', $user_id)->sum('total');
        $recargas = RecargaRealizada::whereBetween('created_at', [$desde, $hasta])->where('user_id', $user_id)->get()->sum(fn($r) => $r->paquete->precio ?? 0);
        $servicios = ServicioRealizado::whereBetween('created_at', [$desde, $hasta])->where('user_id', $user_id)->sum('comision');
        $impresiones = ImpresionRealizada::whereBetween('created_at', [$desde, $hasta])->where('user_id', $user_id)->sum('precio');

        $ingresos = $ventas + $recargas + $servicios + $impresiones;

        $retiros = RetiroRealizado::whereBetween('created_at', [$desde, $hasta])->where('user_id', $user_id)->sum('monto');
        $remesas = RemesaRealizada::whereBetween('created_at', [$desde, $hasta])->where('user_id', $user_id)->sum('monto');

        $egresos = $retiros + $remesas;

        $esperado = $apertura->efectivo_inicial + $ingresos - $egresos;
        $diferencia = $request->efectivo_final - $esperado;

        Cierre::create([
            'apertura_id' => $apertura->id,
            'efectivo_final' => $request->efectivo_final,
            'pos_final' => json_encode($pos_final),
            'total_ingresos' => $ingresos,
            'total_egresos' => $egresos,
            'diferencia' => $diferencia,
        ]);

        return redirect()->route('cierres.reporte_z', $apertura->id);
    }

    public function reporteZ($apertura_id)
    {
        $apertura = Apertura::findOrFail($apertura_id);
        $cierre = Cierre::where('apertura_id', $apertura_id)->latest()->firstOrFail();

        $desde = $apertura->created_at;
        $hasta = now();
        $user_id = $apertura->user_id;

        // INGRESOS DIRECTOS
        $ventas = Venta::whereBetween('created_at', [$desde, $hasta])
            ->where('user_id', $user_id)
            ->sum('total');

        $recargas = RecargaRealizada::whereBetween('created_at', [$desde, $hasta])
            ->where('user_id', $user_id)
            ->get()
            ->sum(fn($r) => $r->paquete->precio ?? 0);

        $servicios = ServicioRealizado::whereBetween('created_at', [$desde, $hasta])
            ->where('user_id', $user_id)
            ->sum('total');

        $impresiones = ImpresionRealizada::whereBetween('created_at', [$desde, $hasta])
            ->where('user_id', $user_id)
            ->sum('precio');

        // COMISIONES
        $comision_retiros = RetiroRealizado::whereBetween('created_at', [$desde, $hasta])
            ->where('user_id', $user_id)
            ->sum('comision');

        $comision_remesas = RemesaRealizada::whereBetween('created_at', [$desde, $hasta])
            ->where('user_id', $user_id)
            ->sum('comision');

        $comision_servicios = ServicioRealizado::whereBetween('created_at', [$desde, $hasta])
            ->where('user_id', $user_id)
            ->sum('comision');

        // EGRESOS
        $retiros = RetiroRealizado::whereBetween('created_at', [$desde, $hasta])
            ->where('user_id', $user_id)
            ->sum('monto');

        $remesas = RemesaRealizada::whereBetween('created_at', [$desde, $hasta])
            ->where('user_id', $user_id)
            ->sum('monto');

        // SUMATORIA FINAL
        $ingresos_comisiones = $comision_servicios + $comision_remesas + $comision_retiros;
        $ingresos = $ventas + $recargas + $impresiones + $servicios + $ingresos_comisiones;
        $egresos = $retiros + $remesas;

        // CÁLCULO FINAL
        $esperado = $apertura->efectivo_inicial + $ingresos - $egresos;
        $diferencia = $cierre->efectivo_final - $esperado;

        return view('cierres.reporte_z', compact(
            'apertura',
            'cierre',
            'ventas',
            'recargas',
            'servicios',
            'impresiones',
            'retiros',
            'remesas',
            'comision_remesas',
            'comision_retiros',
            'ingresos',
            'ingresos_comisiones',
            'egresos',
            'esperado',
            'diferencia' // se pasa a la vista para usar en el cálculo correcto
        ));
    }



    public function finalizar(Cierre $cierre)
    {
        if ($cierre->diferencia < 0) {
            return redirect()->back()->with('error', 'No se puede cerrar el turno con faltante.');
        }

        $cierre->update(['reporte_z_generado' => true]);

        return redirect()->route('dashboard')->with('success', 'Turno cerrado correctamente.');
    }
}
