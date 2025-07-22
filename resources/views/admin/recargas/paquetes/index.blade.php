@extends('layouts.admin')
@section('title', 'Paquetes de Recarga')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 bg-gray-50 min-h-screen">
    <!-- Título principal y subtítulo -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center gap-2">
            💳 Paquetes de Recarga
        </h1>
        <p class="text-sm text-gray-500">Gestiona y administra los paquetes de recarga disponibles para tus clientes.</p>
    </div>

    <!-- Sección de acciones -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-3">
        <a href="{{ route('admin.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600 flex items-center gap-2">
            ← Regresar
        </a>
        <a href="{{ route('admin.recargas.paquetes.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 flex items-center gap-2">
            ➕ Nuevo Paquete
        </a>
    </div>

    <!-- Tarjetas de paquetes -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($paquetes as $item)
            <div class="bg-white rounded-xl shadow p-6 flex flex-col justify-between h-full">
                <div>
                    <h2 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                        🏷️ {{ $item->descripcion }}
                    </h2>
                    <div class="mb-2">
                        <span class="text-gray-500 text-sm">Proveedor:</span>
                        <span class="font-medium text-gray-800">{{ $item->proveedor->nombre }}</span>
                    </div>
                    <div class="mb-2">
                        <span class="text-gray-500 text-sm">Precio:</span>
                        <span class="font-semibold text-green-600">L {{ number_format($item->precio, 2) }}</span>
                    </div>
                </div>
                <div class="mt-6 flex gap-3">
                    <form action="{{ route('admin.recargas.paquetes.destroy', $item) }}" method="POST" onsubmit="return confirm('¿Eliminar paquete?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 flex items-center gap-1">
                            🗑 Eliminar
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-xl shadow p-6 text-center text-gray-500">
                No hay paquetes registrados.
            </div>
        @endforelse
    </div>
</div>
@endsection
