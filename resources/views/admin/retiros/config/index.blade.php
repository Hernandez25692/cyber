@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 bg-gray-50 min-h-screen">
    <!-- Título principal -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center gap-2">
            ⚙️ Configuración de Comisiones para Retiros
        </h1>
        <p class="text-sm text-gray-500">Administra los rangos y comisiones aplicadas a los retiros de usuarios.</p>
    </div>

    <!-- Sección de acciones -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-3">
        <a href="{{ route('admin.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600 flex items-center gap-2">
            ← Regresar
        </a>
        <a href="{{ route('admin.retiros.config.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 flex items-center gap-2">
            ➕ Nuevo Rango
        </a>
    </div>

    <!-- Mensaje de éxito -->
    @if (session('success'))
        <div class="mb-6">
            <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg shadow">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <!-- Tarjetas de rangos -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($rangos as $rango)
            <div class="bg-white rounded-xl shadow p-6 flex flex-col justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                        🏷️ {{ $rango->nombre }}
                    </h2>
                    <ul class="mb-4 text-gray-600 space-y-1">
                        <li><span class="font-medium">Monto Mínimo:</span> <span class="ml-1">L {{ number_format($rango->monto_min, 2) }}</span></li>
                        <li><span class="font-medium">Monto Máximo:</span> <span class="ml-1">L {{ number_format($rango->monto_max, 2) }}</span></li>
                        <li><span class="font-medium">Comisión:</span> <span class="ml-1">L {{ number_format($rango->comision, 2) }}</span></li>
                    </ul>
                </div>
                <div class="flex gap-2 mt-4">
                    <form action="{{ route('admin.retiros.config.destroy', $rango->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este rango?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-3 py-2 rounded hover:bg-red-600 shadow flex items-center gap-1 text-sm">
                            🗑️ Eliminar
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-xl shadow p-6 text-center text-gray-500">
                No hay rangos configurados aún.
            </div>
        @endforelse
    </div>
</div>
@endsection
