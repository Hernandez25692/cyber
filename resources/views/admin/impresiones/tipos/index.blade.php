@extends('layouts.admin')
@section('title', 'Tipos de Impresión')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-gray-100 py-8">
    <div class="max-w-5xl mx-auto px-4 py-8">
        <!-- Título principal -->
        <div class="mb-8">
            <h1 class="text-4xl font-extrabold text-blue-800 mb-2 flex items-center gap-3">
                <span class="text-3xl">🎨</span> Tipos de Impresión
            </h1>
            <p class="text-base text-gray-600">Gestiona los diferentes tipos de impresión disponibles en el sistema.</p>
        </div>

        <!-- Sección de acciones -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4">
            <a href="{{ route('admin.index') }}" class="bg-gray-200 text-gray-700 px-5 py-2 rounded-lg shadow hover:bg-gray-300 transition flex items-center gap-2 font-semibold">
                ← Regresar
            </a>
            <a href="{{ route('admin.impresiones.tipos.create') }}" class="bg-blue-700 text-white px-5 py-2 rounded-lg shadow hover:bg-blue-800 transition flex items-center gap-2 font-semibold">
                <span class="text-lg">➕</span> Nuevo Tipo
            </a>
        </div>

        <!-- Tarjeta de listado -->
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-blue-100">
            <h2 class="text-xl font-bold text-blue-700 mb-6 flex items-center gap-2">
                <span class="text-lg">📋</span> Lista de Tipos de Impresión
            </h2>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="bg-blue-50">
                            <th class="text-left px-6 py-4 font-semibold text-blue-700">ID</th>
                            <th class="text-left px-6 py-4 font-semibold text-blue-700">Nombre</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-blue-100">
                        @forelse ($tipos as $tipo)
                            <tr class="hover:bg-blue-50 transition">
                                <td class="px-6 py-4">{{ $tipo->id }}</td>
                                <td class="px-6 py-4 font-medium text-gray-800">{{ $tipo->nombre }}</td>
                                
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-10 text-center text-gray-400">No hay tipos de impresión registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
