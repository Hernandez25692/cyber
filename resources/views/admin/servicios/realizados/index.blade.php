@extends('layouts.admin')

@section('title', 'Reporte de Servicios Realizados')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 bg-gray-50 min-h-screen">
    <!-- Título principal y subtítulo -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center gap-2">
            📝 Reporte de Servicios Realizados
        </h1>
        <p class="text-sm text-gray-500">Visualiza el historial de servicios realizados en la plataforma.</p>
    </div>

    <!-- Sección de acciones -->
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('admin.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600 flex items-center gap-2">
            <span>←</span> Regresar
        </a>
        <!-- Puedes agregar más botones de acción aquí si lo necesitas -->
    </div>

    <!-- Tarjeta principal de reporte -->
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 014-4h3m4 4v6a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6"></path>
            </svg>
            Servicios realizados
        </h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left text-gray-700 border">
                <thead class="text-xs text-gray-100 uppercase bg-blue-700">
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Tipo de Servicio</th>
                        <th class="px-4 py-2">Banco</th>
                        <th class="px-4 py-2">Comisión</th>
                        <th class="px-4 py-2">Referencia / ID</th>
                        <th class="px-4 py-2">Realizado por</th>
                        <th class="px-4 py-2">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($servicios as $servicio)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $servicio->id }}</td>
                            <td class="px-4 py-2">{{ $servicio->tipoServicio->nombre ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $servicio->banco->nombre ?? '-' }}</td>
                            <td class="px-4 py-2">L {{ number_format($servicio->comision, 2) }}</td>
                            <td class="px-4 py-2">{{ $servicio->referencia ?? '—' }}</td>
                            <td class="px-4 py-2">{{ $servicio->usuario->name ?? 'Desconocido' }}</td>
                            <td class="px-4 py-2">{{ $servicio->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-gray-500">No hay servicios registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Ejemplo de tarjetas adicionales (opcional, para múltiples elementos) -->
    {{-- 
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-2 flex items-center gap-2">📊 Estadísticas</h3>
            <p class="text-gray-500 text-sm">Contenido de ejemplo para otra tarjeta.</p>
            <div class="mt-4 flex gap-2">
                <button class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 shadow">Ver más</button>
                <button class="bg-gray-200 text-gray-700 px-3 py-1 rounded hover:bg-gray-300 shadow">Acción</button>
            </div>
        </div>
        <!-- Más tarjetas aquí si es necesario -->
    </div>
    --}}
</div>
@endsection
