<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServicioImpresion;

class ServicioImpresionController extends Controller
{
    public function index()
    {
        $servicios = ServicioImpresion::all();
        return view('admin.impresiones.servicios.index', compact('servicios'));
    }

    public function create()
    {
        return view('admin.impresiones.servicios.create');
    }

    public function store(Request $request)
    {
        $request->validate(['nombre' => 'required|string|max:100']);
        ServicioImpresion::create(['nombre' => $request->nombre]);
        return redirect()->route('admin.impresiones.servicios.index')->with('success', 'Servicio creado.');
    }

    public function destroy($id)
    {
        ServicioImpresion::findOrFail($id)->delete();
        return back()->with('success', 'Servicio eliminado.');
    }
}
