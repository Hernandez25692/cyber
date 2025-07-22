@extends('layouts.admin')
@section('title', 'Nuevo Proveedor')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 bg-gray-50 min-h-screen">
    <!-- Título principal y subtítulo -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center gap-2">
            <span>➕ Nuevo Proveedor</span>
        </h1>
        <p class="text-sm text-gray-500">Registra un nuevo proveedor para el sistema de recargas.</p>
    </div>

    <!-- Sección de acciones -->
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('admin.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600 flex items-center gap-2">
            <span>←</span> Regresar
        </a>
    </div>

    <!-- Tarjeta de formulario -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                <span>📋</span> Datos del Proveedor
            </h2>
            <form action="{{ route('admin.recargas.proveedores.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block mb-2 font-semibold text-gray-600" for="nombre">Nombre del Proveedor</label>
                    <input type="text" name="nombre" id="nombre" required
                        class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500"
                        placeholder="Ej: Claro, Tigo">
                </div>
                <div class="flex gap-3">
                    <button type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700 flex items-center gap-2">
                        <span>💾</span> Guardar
                    </button>
                    <a href="{{ route('admin.recargas.proveedores.index') }}"
                        class="bg-gray-200 text-gray-700 px-4 py-2 rounded shadow hover:bg-gray-300 flex items-center gap-2">
                        <span>✖️</span> Cancelar
                    </a>
                </div>
            </form>
        </div>
        <!-- Puedes agregar más tarjetas aquí si es necesario -->
    </div>
</div>
@endsection
