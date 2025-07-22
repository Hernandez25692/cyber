@extends('layouts.admin')

@section('title', 'Nuevo Usuario')

@section('content')
    <h2 class="text-2xl font-bold mb-4">➕ Registrar Nuevo Usuario</h2>

    <form method="POST" action="{{ route('admin.usuarios.store') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block font-semibold">Nombre</label>
            <input type="text" name="name" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block font-semibold">Email</label>
            <input type="email" name="email" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block font-semibold">Contraseña</label>
            <input type="password" name="password" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block font-semibold">Confirmar Contraseña</label>
            <input type="password" name="password_confirmation" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block font-semibold">Rol</label>
            <select name="rol" class="w-full border rounded p-2" required>
                <option value="admin">Administrador</option>
                <option value="cajero">Cajero</option>
            </select>
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Guardar Usuario
        </button>
        <a href="{{ route('admin.usuarios.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            ← Regresar
        </a>
    </form>
@endsection
