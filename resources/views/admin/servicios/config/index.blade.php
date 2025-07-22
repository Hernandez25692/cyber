@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-6">
    <div class="max-w-7xl mx-auto px-4 py-6">
        <!-- Título principal -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-1 flex items-center gap-2">
                ⚙️ Configuración de Servicios
            </h1>
            <p class="text-sm text-gray-500">Administra las configuraciones y comisiones de los servicios disponibles.</p>
        </div>

        <!-- Sección de acciones -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-3">
            <a href="{{ route('admin.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600 flex items-center gap-2">
                ← Regresar
            </a>
            <a href="{{ route('admin.servicios.config.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 flex items-center gap-2">
                <span>＋</span> Nueva Configuración
            </a>
        </div>

        <!-- Tarjetas de configuración -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($configs as $config)
                <div class="bg-white rounded-xl shadow p-6 flex flex-col justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                            🏷️ {{ $config->tipo->nombre }}
                        </h2>
                        <div class="mb-2 flex items-center gap-2">
                            <span class="text-gray-500">🏦 Banco:</span>
                            <span class="font-medium text-gray-800">{{ $config->banco->nombre }}</span>
                        </div>
                        <div class="mb-4 flex items-center gap-2">
                            <span class="text-gray-500">💸 Comisión:</span>
                            <span class="font-medium text-green-600">L {{ number_format($config->comision, 2) }}</span>
                        </div>
                    </div>
                    <div class="flex gap-2 mt-4">
                        <form action="{{ route('admin.servicios.config.destroy', $config) }}" method="POST" onsubmit="return confirm('¿Eliminar configuración?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 flex items-center gap-1">
                                🗑️ Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-xl shadow p-6 text-center text-gray-500">
                    No hay configuraciones registradas.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
