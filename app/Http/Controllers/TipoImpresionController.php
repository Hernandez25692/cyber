<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoImpresion;

class TipoImpresionController extends Controller
{
    public function index()
    {
        $tipos = TipoImpresion::all();
        return view('admin.impresiones.tipos.index', compact('tipos'));
    }

    public function create()
    {
        return view('admin.impresiones.tipos.create');
    }

    public function store(Request $request)
    {
        $request->validate(['nombre' => 'required|string|max:100']);
        TipoImpresion::create(['nombre' => $request->nombre]);
        return redirect()->route('admin.impresiones.tipos.index')->with('success', 'Tipo creado.');
    }

    public function destroy($id)
    {
        TipoImpresion::findOrFail($id)->delete();
        return back()->with('success', 'Tipo eliminado.');
    }
}
