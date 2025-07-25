<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RemesaRealizada;
use Carbon\Carbon;

class ReporteRemesasController extends Controller
{
    public function index(Request $request)
    {
        $query = RemesaRealizada::with('usuario');

        if ($request->filled('cajero')) {
            $query->whereHas('usuario', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->cajero . '%');
            });
        }

        if ($request->filled('desde')) {
            $query->whereDate('created_at', '>=', $request->desde);
        }

        if ($request->filled('hasta')) {
            $query->whereDate('created_at', '<=', $request->hasta);
        }

        $remesas = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.reportes.remesas', [
            'remesas' => $remesas,
            'filtros' => $request->all(),
        ]);
    }
}
