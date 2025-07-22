<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ServicioConfig;

class ServicioDataController extends Controller
{
    public function bancosPorTipo($tipoId)
    {
        $bancos = ServicioConfig::where('tipo_servicio_id', $tipoId)
            ->with('banco')
            ->get()
            ->map(function ($item) {
                return [
                    'banco_id' => $item->banco->id,
                    'banco_nombre' => $item->banco->nombre,
                ];
            })->unique('banco_id')->values();

        return response()->json($bancos);
    }

    public function comision($tipoId, $bancoId)
    {
        $config = ServicioConfig::where('tipo_servicio_id', $tipoId)
            ->where('banco_id', $bancoId)
            ->first();

        return response()->json([
            'comision' => $config->comision ?? null
        ]);
    }
}
