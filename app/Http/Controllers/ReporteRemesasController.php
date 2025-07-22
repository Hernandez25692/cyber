<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RemesaRealizada;
use Carbon\Carbon;

class ReporteRemesasController extends Controller
{
    public function index()
    {
        $remesas = RemesaRealizada::with('usuario')->orderBy('created_at', 'desc')->get();

        return view('admin.reportes.remesas', compact('remesas'));
    }
}
