@extends('layouts.admin')
@section('title', 'Tipos de Impresión')

@section('content')
<div class="min-h-screen bg-gray-50 py-6">
    <div class="max-w-7xl mx-auto px-4 py-6">
        <!-- Título principal -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center gap-2">
                🎨 Tipos de Impresión
            </h1>
            <p class="text-sm text-gray-500">Gestiona los diferentes tipos de impresión disponibles en el sistema.</p>
        </div>

        <!-- Sección de acciones -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-3">
            <a href="{{ route('admin.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600 flex items-center gap-2">
                ← Regresar
            </a>
            <a href="{{ route('admin.impresiones.tipos.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 flex items-center gap-2">
                <span>➕</span> Nuevo Tipo
            </a>
        </div>

        <!-- Tarjeta de listado -->
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                📋 Lista de Tipos de Impresión
            </h2>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="text-left px-4 py-3 font-medium text-gray-600">ID</th>
                            <th class="text-left px-4 py-3 font-medium text-gray-600">Nombre</th>
                            <th class="text-left px-4 py-3 font-medium text-gray-600">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($tipos as $tipo)
                            <tr>
                                <td class="px-4 py-3">{{ $tipo->id }}</td>
                                <td class="px-4 py-3">{{ $tipo->nombre }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-2">
                                        <form action="{{ route('admin.impresiones.tipos.destroy', $tipo) }}" method="POST" onsubmit="return confirm('¿Eliminar este tipo?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="bg-red-100 text-red-600 px-3 py-1 rounded hover:bg-red-200 flex items-center gap-1">
                                                🗑 <span class="hidden sm:inline">Eliminar</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-6 text-center text-gray-400">No hay tipos de impresión registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
