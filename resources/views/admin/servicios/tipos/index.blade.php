@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 bg-gray-100 min-h-screen font-sans">
    <!-- Título principal -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2 flex items-center gap-2 tracking-tight">
            <span class="text-blue-700">🛠️</span> Tipos de Servicio
        </h1>
        <p class="text-base text-gray-600">Administra los diferentes tipos de servicios disponibles en la plataforma.</p>
    </div>

    <!-- Sección de acciones -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-3">
        <a href="{{ route('admin.index') }}" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded shadow-sm hover:bg-gray-50 flex items-center gap-2 transition">
            ← Regresar
        </a>
        <a href="{{ route('admin.servicios.tipos.create') }}" class="bg-blue-700 text-white px-4 py-2 rounded shadow-sm hover:bg-blue-800 flex items-center gap-2 transition">
            <span class="font-bold text-lg">＋</span> Nuevo Tipo
        </a>
    </div>

    <!-- Tarjetas de tipos de servicio -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($tipos as $tipo)
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800 mb-2 flex items-center gap-2">
                        <span class="text-blue-600">🏷️</span> {{ $tipo->nombre }}
                    </h2>
                </div>
                <div class="mt-4 flex gap-2">
                    <form action="{{ route('admin.servicios.tipos.destroy', $tipo) }}" method="POST" onsubmit="return confirm('¿Eliminar este tipo?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="bg-white border border-red-400 text-red-600 px-4 py-2 rounded hover:bg-red-50 flex items-center gap-1 transition">
                            🗑️ Eliminar
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white border border-gray-200 rounded-lg shadow-sm p-6 text-center text-gray-500">
                No hay tipos de servicio registrados.
            </div>
        @endforelse
    </div>
</div>
@endsection
