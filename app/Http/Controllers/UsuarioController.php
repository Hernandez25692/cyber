<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::all();
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('admin.usuarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'rol' => 'required|in:admin,cajero',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'rol' => $request->rol,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.usuarios.index')->with('success', '✅ Usuario creado correctamente.');
    }

    public function destroy($id)
    {
        if (auth()->id() == $id) {
            return back()->with('error', '❌ No puedes eliminarte a ti mismo.');
        }

        User::destroy($id);
        return back()->with('success', '🗑️ Usuario eliminado.');
    }

    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        return view('admin.usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'rol' => 'required|in:admin,cajero',
            'activo' => 'required|boolean',
        ]);

        $usuario->update([
            'name' => $request->name,
            'email' => $request->email,
            'rol' => $request->rol,
            'activo' => $request->activo,
        ]);

        return redirect()->route('admin.usuarios.index')->with('success', '✅ Usuario actualizado.');
    }
}
