<?php

namespace App\Http\Controllers;

use App\Models\ImpresionRealizada;

class ReporteImpresionesController extends Controller
{
    public function index()
    {
        $impresiones = ImpresionRealizada::with(['servicio', 'tipo', 'usuario'])->latest()->get();
        return view('admin.impresiones.reportes.index', compact('impresiones'));
    }
}
