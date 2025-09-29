@extends('layouts.admin')

@section('title', 'Reporte de Servicios Realizados')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 bg-gradient-to-br from-blue-50 via-white to-gray-100 min-h-screen">
    <!-- Título principal y subtítulo -->
    <div class="mb-8">
        <h1 class="text-4xl font-extrabold text-blue-900 mb-2 flex items-center gap-3 drop-shadow">
            <span class="bg-blue-600 text-white rounded-full px-3 py-1 text-2xl">📝</span>
            Reporte de Servicios Realizados
        </h1>
        <p class="text-base text-gray-600">Visualiza el historial de servicios realizados en la plataforma.</p>
    </div>

    <!-- Sección de acciones -->
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('admin.index') }}" class="bg-blue-600 text-white px-5 py-2 rounded-lg shadow hover:bg-blue-700 flex items-center gap-2 transition">
            <span class="text-xl">←</span> Regresar
        </a>
        <!-- Puedes agregar más botones de acción aquí si lo necesitas -->
    </div>

    <!-- Tarjeta principal de reporte -->
    <div class="bg-white rounded-2xl shadow-lg p-8 border border-blue-100">
        <h2 class="text-xl font-bold text-blue-700 mb-6 flex items-center gap-2">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 014-4h3m4 4v6a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6"></path>
            </svg>
            Servicios realizados
        </h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4 border border-green-300 shadow">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto rounded-lg border border-blue-100 shadow-sm">
            <table class="min-w-full text-sm text-left text-gray-700">
                <thead class="text-xs text-blue-100 uppercase bg-blue-700">
                    <tr>
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Tipo de Servicio</th>
                        <th class="px-4 py-3">Banco</th>
                        <th class="px-4 py-3">Total Servicio</th>
                        <th class="px-4 py-3">Comisión</th>
                        <th class="px-4 py-3">Referencia / ID</th>
                        <th class="px-4 py-3">Realizado por</th>
                        <th class="px-4 py-3">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($servicios as $servicio)
                        <tr class="border-b hover:bg-blue-50 transition">
                            <td class="px-4 py-3 font-semibold text-blue-700">{{ $servicio->id }}</td>
                            <td class="px-4 py-3">{{ $servicio->tipoServicio->nombre ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $servicio->banco->nombre ?? '-' }}</td>
                            <td class="px-4 py-3 text-green-700 font-bold">L {{ number_format($servicio->total, 2) }}</td>
                            <td class="px-4 py-3 text-yellow-700 font-bold">L {{ number_format($servicio->comision, 2) }}</td>
                            <td class="px-4 py-3">{{ $servicio->referencia ?? '—' }}</td>
                            <td class="px-4 py-3">{{ $servicio->usuario->name ?? 'Desconocido' }}</td>
                            <td class="px-4 py-3">{{ $servicio->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-6 text-gray-500">No hay servicios registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
