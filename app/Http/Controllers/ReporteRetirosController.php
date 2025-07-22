<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RetiroRealizado;

class ReporteRetirosController extends Controller
{
    public function index()
    {
        $retiros = RetiroRealizado::with('usuario')->latest()->get();
        return view('admin.reportes.retiros', compact('retiros'));
    }
}
