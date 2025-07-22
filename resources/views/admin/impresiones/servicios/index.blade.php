@extends('layouts.admin')
@section('title', 'Servicios de Impresión')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 bg-gray-50 min-h-screen">
    <!-- Título principal y subtítulo -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center gap-2">
            🖨️ Servicios de Impresión
        </h1>
        <p class="text-sm text-gray-500">Administra los servicios de impresión disponibles en el sistema.</p>
    </div>

    <!-- Sección de acciones -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <a href="{{ route('admin.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600 flex items-center gap-2">
            ← Regresar
        </a>
        <a href="{{ route('admin.impresiones.servicios.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 flex items-center gap-2">
            ➕ Nuevo Servicio
        </a>
    </div>

    <!-- Tarjetas de servicios -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($servicios as $servicio)
            <div class="bg-white rounded-xl shadow p-6 flex flex-col justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                        📝 {{ $servicio->nombre }}
                    </h2>
                    <p class="text-sm text-gray-500 mb-2">ID: <span class="font-mono">{{ $servicio->id }}</span></p>
                </div>
                <div class="mt-4 flex gap-3">
                    <form action="{{ route('admin.impresiones.servicios.destroy', $servicio) }}" method="POST" onsubmit="return confirm('¿Eliminar este servicio?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-3 py-1.5 rounded hover:bg-red-600 flex items-center gap-1">
                            🗑 Eliminar
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-xl shadow p-6 text-center text-gray-500">
                No hay servicios registrados.
            </div>
        @endforelse
    </div>
</div>
@endsection
