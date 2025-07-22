<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banco;

class BancoController extends Controller
{
    public function index()
    {
        $bancos = Banco::all();
        return view('admin.servicios.bancos.index', compact('bancos'));
    }

    public function create()
    {
        return view('admin.servicios.bancos.create');
    }

    public function store(Request $request)
    {
        $request->validate(['nombre' => 'required|unique:bancos']);
        Banco::create($request->only('nombre'));
        return redirect()->route('admin.servicios.bancos.index')->with('success', 'Banco creado.');
    }

    public function destroy(Banco $banco)
    {
        $banco->delete();
        return back()->with('success', 'Banco eliminado.');
    }
}
