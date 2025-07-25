@extends('layouts.admin')
@section('title', 'Proveedores de Recarga')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 bg-gradient-to-br from-blue-50 to-gray-100 min-h-screen">
    <!-- Título principal y subtítulo -->
    <div class="mb-10">
        <h1 class="text-4xl font-extrabold text-blue-800 mb-2 flex items-center gap-3 drop-shadow">
            <span class="text-3xl">📱</span> Proveedores de Recarga
        </h1>
        <p class="text-base text-gray-600">Administra los proveedores disponibles para recargas en la plataforma.</p>
    </div>

    <!-- Sección de acciones -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4">
        <a href="{{ route('admin.index') }}" class="bg-gray-600 text-white px-5 py-2 rounded-lg shadow-md hover:bg-gray-700 transition flex items-center gap-2 font-medium">
            ← Regresar
        </a>
        <a href="{{ route('admin.recargas.proveedores.create') }}"
           class="bg-gradient-to-r from-blue-600 to-blue-400 text-white px-5 py-2 rounded-lg shadow-md hover:from-blue-700 hover:to-blue-500 transition flex items-center gap-2 font-medium">
            ➕ Nuevo Proveedor
        </a>
    </div>

    <!-- Tarjeta principal de proveedores -->
    <div class="bg-white rounded-2xl shadow-lg p-8 border border-blue-100">
        <h2 class="text-xl font-bold text-blue-700 mb-6 flex items-center gap-2">
            <span class="text-lg">📋</span> Lista de Proveedores
        </h2>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm rounded-xl overflow-hidden">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="px-5 py-3 text-left font-semibold text-blue-700">#</th>
                        <th class="px-5 py-3 text-left font-semibold text-blue-700">Nombre</th>
                        <th class="px-5 py-3 text-left font-semibold text-blue-700">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-blue-50">
                    @forelse ($proveedores as $item)
                        <tr class="hover:bg-blue-50 transition">
                            <td class="px-5 py-3">{{ $item->id }}</td>
                            <td class="px-5 py-3 font-medium text-gray-800">{{ $item->nombre }}</td>
                            <td class="px-5 py-3">
                                <div class="flex gap-2">
                                    <form action="{{ route('admin.recargas.proveedores.destroy', $item) }}" method="POST"
                                        onsubmit="return confirm('¿Eliminar proveedor?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-100 text-red-700 px-4 py-1.5 rounded-lg hover:bg-red-200 transition flex items-center gap-1 font-semibold shadow-sm">
                                            🗑 <span class="hidden sm:inline">Eliminar</span>
                                        </button>
                                    </form>
                                    <!-- Aquí puedes agregar más acciones si lo deseas -->
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-5 py-6 text-center text-gray-400">No hay proveedores registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
