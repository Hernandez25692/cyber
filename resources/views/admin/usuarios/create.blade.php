@extends('layouts.admin')

@section('title', 'Nuevo Usuario')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4 py-6">
    <div class="w-full max-w-2xl">
        <!-- Título principal y subtítulo -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2 flex items-center justify-center gap-2">
                👤 Nuevo Usuario
            </h1>
            <p class="text-base text-gray-500">Registra un nuevo usuario para el sistema de administración.</p>
        </div>

        <!-- Sección de acciones -->
        <div class="mb-6 flex justify-center gap-4">
            <a href="{{ route('admin.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600 flex items-center gap-2">
                ← Regresar
            </a>
        </div>

        <!-- Tarjeta de formulario -->
        <div class="bg-white rounded-2xl shadow-lg p-8 w-full">
            <h2 class="text-xl font-semibold text-gray-700 mb-6 flex items-center justify-center gap-2">
                📝 Datos del Usuario
            </h2>
            <form method="POST" action="{{ route('admin.usuarios.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block font-semibold text-gray-600 mb-1 text-center">Nombre</label>
                    <input type="text" name="name" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 text-center" required>
                </div>

                <div>
                    <label class="block font-semibold text-gray-600 mb-1 text-center">Email</label>
                    <input type="email" name="email" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 text-center" required>
                </div>

                <div>
                    <label class="block font-semibold text-gray-600 mb-1 text-center">Contraseña</label>
                    <input type="password" name="password" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 text-center" required>
                </div>

                <div>
                    <label class="block font-semibold text-gray-600 mb-1 text-center">Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 text-center" required>
                </div>

                <div>
                    <label class="block font-semibold text-gray-600 mb-1 text-center">Rol</label>
                    <select name="rol" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 text-center" required>
                        <option value="admin">Administrador</option>
                        <option value="cajero">Cajero</option>
                    </select>
                </div>

                <div class="flex flex-col md:flex-row gap-4 mt-8 justify-center">
                    <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-lg shadow hover:bg-green-700 flex items-center justify-center gap-2 w-full md:w-auto">
                        💾 Guardar Usuario
                    </button>
                    <a href="{{ route('admin.usuarios.index') }}" class="bg-gray-400 text-white px-6 py-3 rounded-lg shadow hover:bg-gray-500 flex items-center justify-center gap-2 w-full md:w-auto">
                        📋 Ver Usuarios
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
