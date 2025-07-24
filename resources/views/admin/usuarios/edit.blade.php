@extends('layouts.admin')

@section('title', 'Editar Usuario')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4 py-6">
        <div class="w-full max-w-2xl">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-800 mb-2 flex items-center justify-center gap-2">
                    ✏️ Editar Usuario
                </h1>
            </div>

            <div class="mb-6 flex justify-center gap-4">
                <a href="{{ route('admin.usuarios.index') }}"
                    class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600">
                    ← Volver
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-8">
                <form method="POST" action="{{ route('admin.usuarios.update', $usuario->id) }}" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block font-semibold text-gray-600 text-center">Nombre</label>
                        <input type="text" name="name" value="{{ $usuario->name }}"
                            class="w-full border rounded-lg p-3 text-center" required>
                    </div>

                    <div>
                        <label class="block font-semibold text-gray-600 text-center">Email</label>
                        <input type="email" name="email" value="{{ $usuario->email }}"
                            class="w-full border rounded-lg p-3 text-center" required>
                    </div>

                    <div>
                        <label class="block font-semibold text-gray-600 text-center">Rol</label>
                        <select name="rol" class="w-full border rounded-lg p-3 text-center" required>
                            <option value="admin" {{ $usuario->rol == 'admin' ? 'selected' : '' }}>Administrador</option>
                            <option value="cajero" {{ $usuario->rol == 'cajero' ? 'selected' : '' }}>Cajero</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold text-gray-600 text-center">Estado</label>
                        <select name="activo" class="w-full border rounded-lg p-3 text-center" required>
                            <option value="1" {{ $usuario->activo ? 'selected' : '' }}>✅ Activo</option>
                            <option value="0" {{ !$usuario->activo ? 'selected' : '' }}>🚫 Inactivo</option>
                        </select>
                    </div>

                    <div class="flex justify-center mt-6">
                        <button type="submit"
                            class="bg-green-600 text-white px-6 py-3 rounded-lg shadow hover:bg-green-700">
                            💾 Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
