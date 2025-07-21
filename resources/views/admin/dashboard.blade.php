@extends('layouts.admin')

@section('title', 'Panel de Administración')

@section('content')
    <h1 class="text-3xl font-bold text-green-700 mb-6">👨‍💼 Panel de Administración</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 text-center">
        <a href="{{ route('admin.usuarios.index') }}"
            class="bg-blue-600 text-white p-6 rounded-xl shadow hover:bg-blue-700 transition font-semibold">
            👥 Gestión de Usuarios
        </a>

        <a href="#" class="bg-yellow-500 text-white p-6 rounded-xl shadow hover:bg-yellow-600 transition font-semibold">
            💰 Comisiones y Servicios
        </a>

        <a href="#" class="bg-green-600 text-white p-6 rounded-xl shadow hover:bg-green-700 transition font-semibold">
            📦 Inventario
        </a>

        <a href="#" class="bg-purple-600 text-white p-6 rounded-xl shadow hover:bg-purple-700 transition font-semibold">
            📈 Reportes
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full bg-red-600 text-white p-6 rounded-xl shadow hover:bg-red-700 transition font-semibold">
                🚪 Cerrar sesión
            </button>
        </form>
    </div>
@endsection
