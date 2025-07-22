<?php

namespace App\Http\Controllers;

use App\Models\RecargaRealizada;
use Illuminate\Http\Request;

class ReporteRecargasController extends Controller
{
    public function index()
    {
        $recargas = RecargaRealizada::with(['paquete.proveedor', 'usuario'])->latest()->get();
        return view('admin.recargas.reportes.index', compact('recargas'));
    }
}
