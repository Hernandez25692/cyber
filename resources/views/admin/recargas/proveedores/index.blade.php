@extends('layouts.admin')
@section('title', 'Proveedores de Recarga')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10 bg-gradient-to-br from-blue-100 to-gray-50 min-h-screen">
    <!-- Título principal y subtítulo -->
    <div class="mb-12 text-center">
        <h1 class="text-5xl font-extrabold text-blue-900 mb-3 flex items-center justify-center gap-3 drop-shadow-lg">
            <span class="text-4xl">📱</span> Proveedores de Recarga
        </h1>
        <p class="text-lg text-gray-700">Administra los proveedores disponibles para recargas en la plataforma.</p>
    </div>

    <!-- Sección de acciones -->
    <div class="flex flex-col sm:flex-row items-center justify-between mb-10 gap-4">
        <a href="{{ route('admin.index') }}" class="bg-white border border-gray-300 text-gray-700 px-6 py-2 rounded-xl shadow hover:bg-gray-100 transition flex items-center gap-2 font-semibold">
            ← Regresar
        </a>
        <a href="{{ route('admin.recargas.proveedores.create') }}"
           class="bg-gradient-to-r from-blue-600 to-blue-400 text-white px-6 py-2 rounded-xl shadow hover:from-blue-700 hover:to-blue-500 transition flex items-center gap-2 font-semibold">
            ➕ Nuevo Proveedor
        </a>
    </div>

    <!-- Tarjeta principal de proveedores -->
    <div class="bg-white rounded-3xl shadow-xl p-10 border border-blue-200">
        <h2 class="text-2xl font-bold text-blue-800 mb-8 flex items-center gap-2">
            <span class="text-xl">📋</span> Lista de Proveedores
        </h2>
        <div class="overflow-x-auto">
            <table class="min-w-full text-base rounded-xl overflow-hidden">
                <thead class="bg-blue-200">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold text-blue-800">#</th>
                        <th class="px-6 py-4 text-left font-semibold text-blue-800">Nombre</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-blue-100">
                    @forelse ($proveedores as $item)
                        <tr class="hover:bg-blue-50 transition">
                            <td class="px-6 py-4">{{ $item->id }}</td>
                            <td class="px-6 py-4 font-semibold text-gray-900">{{ $item->nombre }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-6 py-8 text-center text-gray-400">No hay proveedores registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
