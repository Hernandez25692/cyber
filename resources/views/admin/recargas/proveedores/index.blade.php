@extends('layouts.admin')
@section('title', 'Proveedores de Recarga')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 bg-gray-50 min-h-screen">
    <!-- Título principal y subtítulo -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-1 flex items-center gap-2">
            📱 Proveedores de Recarga
        </h1>
        <p class="text-sm text-gray-500">Administra los proveedores disponibles para recargas en la plataforma.</p>
    </div>

    <!-- Sección de acciones -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-3">
        <a href="{{ route('admin.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600 flex items-center gap-2">
            ← Regresar
        </a>
        <a href="{{ route('admin.recargas.proveedores.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 flex items-center gap-2">
            ➕ Nuevo Proveedor
        </a>
    </div>

    <!-- Tarjeta principal de proveedores -->
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
            📋 Lista de Proveedores
        </h2>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">#</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">Nombre</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($proveedores as $item)
                        <tr>
                            <td class="px-4 py-3">{{ $item->id }}</td>
                            <td class="px-4 py-3">{{ $item->nombre }}</td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <form action="{{ route('admin.recargas.proveedores.destroy', $item) }}" method="POST"
                                        onsubmit="return confirm('¿Eliminar proveedor?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-50 text-red-600 px-3 py-1 rounded hover:bg-red-100 flex items-center gap-1">
                                            🗑 <span class="hidden sm:inline">Eliminar</span>
                                        </button>
                                    </form>
                                    <!-- Aquí puedes agregar más acciones si lo deseas -->
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
