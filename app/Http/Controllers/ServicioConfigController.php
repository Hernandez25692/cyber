<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServicioConfig;
use App\Models\Banco;
use App\Models\TipoServicio;


class ServicioConfigController extends Controller
{
    public function index()
    {
        $configs = ServicioConfig::with(['tipo', 'banco'])->get();
        return view('admin.servicios.config.index', compact('configs'));
    }

    public function create()
    {
        $tipos = TipoServicio::all();
        $bancos = Banco::all();
        return view('admin.servicios.config.create', compact('tipos', 'bancos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo_servicio_id' => 'required|exists:tipos_servicio,id',
            'banco_id' => 'required|exists:bancos,id',
            'comision' => 'required|numeric|min:0',
        ]);

        ServicioConfig::create($request->only('tipo_servicio_id', 'banco_id', 'comision'));
        return redirect()->route('admin.servicios.config.index')->with('success', 'Configuración guardada.');
    }

    public function destroy(ServicioConfig $config)
    {
        $config->delete();
        return back()->with('success', 'Configuración eliminada.');
    }
}
