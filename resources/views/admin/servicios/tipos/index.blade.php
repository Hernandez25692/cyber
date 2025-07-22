@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 bg-gray-50 min-h-screen">
    <!-- Título principal -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center gap-2">
            🛠️ Tipos de Servicio
        </h1>
        <p class="text-sm text-gray-500">Administra los diferentes tipos de servicios disponibles en la plataforma.</p>
    </div>

    <!-- Sección de acciones -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-3">
        <a href="{{ route('admin.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600 flex items-center gap-2">
            ← Regresar
        </a>
        <a href="{{ route('admin.servicios.tipos.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 flex items-center gap-2">
            <span>＋</span> Nuevo Tipo
        </a>
    </div>

    <!-- Tarjetas de tipos de servicio -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($tipos as $tipo)
            <div class="bg-white rounded-xl shadow p-6 flex flex-col justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-700 mb-2 flex items-center gap-2">
                        🏷️ {{ $tipo->nombre }}
                    </h2>
                </div>
                <div class="mt-4 flex gap-2">
                    <form action="{{ route('admin.servicios.tipos.destroy', $tipo) }}" method="POST" onsubmit="return confirm('¿Eliminar este tipo?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 flex items-center gap-1">
                            🗑️ Eliminar
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-xl shadow p-6 text-center text-gray-500">
                No hay tipos de servicio registrados.
            </div>
        @endforelse
    </div>
</div>
@endsection
