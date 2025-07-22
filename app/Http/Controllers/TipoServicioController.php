<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoServicio;

class TipoServicioController extends Controller
{
    public function index()
    {
        $tipos = TipoServicio::all();
        return view('admin.servicios.tipos.index', compact('tipos'));
    }

    public function create()
    {
        return view('admin.servicios.tipos.create');
    }

    public function store(Request $request)
    {
        $request->validate(['nombre' => 'required|unique:tipos_servicio']);
        TipoServicio::create($request->only('nombre'));
        return redirect()->route('admin.servicios.tipos.index')->with('success', 'Tipo de servicio creado.');
    }

    public function destroy(TipoServicio $tipo)
    {
        $tipo->delete();
        return back()->with('success', 'Tipo de servicio eliminado.');
    }
}
