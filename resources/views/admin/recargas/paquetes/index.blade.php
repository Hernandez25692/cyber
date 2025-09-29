@extends('layouts.admin')
@section('title', 'Paquetes de Recarga')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 bg-gradient-to-br from-blue-50 to-gray-100 min-h-screen">
    <!-- Título principal y subtítulo -->
    <div class="mb-10">
        <h1 class="text-4xl font-extrabold text-blue-800 mb-2 flex items-center gap-3">
            <span class="bg-blue-100 rounded-full p-2">💳</span> Paquetes de Recarga
        </h1>
        <p class="text-base text-gray-600">Gestiona y administra los paquetes de recarga disponibles para tus clientes.</p>
    </div>

    <!-- Sección de acciones -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4">
        <a href="{{ route('admin.index') }}" class="bg-gray-200 text-gray-700 px-5 py-2 rounded-lg shadow hover:bg-gray-300 flex items-center gap-2 transition">
            ← Regresar
        </a>
        <a href="{{ route('admin.recargas.paquetes.create') }}" class="bg-blue-600 text-white px-5 py-2 rounded-lg shadow hover:bg-blue-700 flex items-center gap-2 transition">
            ➕ Nuevo Paquete
        </a>
    </div>

    <!-- Tarjetas de paquetes -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse ($paquetes as $item)
            <div class="bg-white rounded-2xl shadow-lg p-7 flex flex-col justify-between h-full border border-blue-100 hover:shadow-xl transition">
                <div>
                    <h2 class="text-xl font-bold text-blue-700 mb-4 flex items-center gap-2">
                        <span class="bg-blue-50 rounded p-1">🏷️</span> {{ $item->descripcion }}
                    </h2>
                    <div class="mb-3 flex items-center gap-2">
                        <span class="text-gray-500 text-sm">Proveedor:</span>
                        <span class="font-medium text-gray-800">{{ $item->proveedor->nombre }}</span>
                    </div>
                    <div class="mb-3 flex items-center gap-2">
                        <span class="text-gray-500 text-sm">Precio:</span>
                        <span class="font-semibold text-green-600 bg-green-50 px-2 py-1 rounded">L {{ number_format($item->precio, 2) }}</span>
                    </div>
                </div>
                <div class="mt-6 flex gap-2">
                    <a href="{{ route('admin.recargas.paquetes.edit', $item->id) }}" class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500 transition text-sm font-medium">
                        ✏️ Editar
                    </a>
                    
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl shadow-lg p-8 text-center text-gray-500 border border-gray-200">
                <span class="text-2xl">😕</span>
                <div class="mt-2">No hay paquetes registrados.</div>
            </div>
        @endforelse
    </div>
</div>
@endsection
