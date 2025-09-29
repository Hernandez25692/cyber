@extends('layouts.admin')
@section('title', 'Reporte de Impresiones')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 py-8">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Título principal y subtítulo -->
        <div class="mb-10">
            <h1 class="text-4xl font-extrabold text-blue-900 mb-2 flex items-center gap-3">
                <span class="text-3xl">📊</span>
                Reporte de Impresiones Realizadas
            </h1>
            <p class="text-base text-gray-600">Visualiza el historial de impresiones realizadas por los usuarios del sistema.</p>
        </div>

        <!-- Sección de acciones -->
        <div class="mb-8 flex items-center gap-4">
            <a href="{{ route('admin.index') }}" class="bg-blue-600 text-white px-5 py-2 rounded-lg shadow hover:bg-blue-700 transition flex items-center gap-2">
                ← Regresar
            </a>
        </div>

        <!-- Tarjeta principal de reporte -->
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-blue-100">
            <div class="mb-6 flex items-center gap-3">
                <span class="text-xl font-bold text-blue-700">🖨️ Impresiones Registradas</span>
            </div>
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full text-sm">
                    <thead class="bg-blue-50">
                        <tr>
                            <th class="px-5 py-3 text-left font-semibold text-blue-800">Servicio</th>
                            <th class="px-5 py-3 text-left font-semibold text-blue-800">Tipo</th>
                            <th class="px-5 py-3 text-left font-semibold text-blue-800">Precio</th>
                            <th class="px-5 py-3 text-left font-semibold text-blue-800">Descripción</th>
                            <th class="px-5 py-3 text-left font-semibold text-blue-800">Cajero</th>
                            <th class="px-5 py-3 text-left font-semibold text-blue-800">Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($impresiones as $i)
                            <tr class="border-b last:border-b-0 hover:bg-blue-50 transition">
                                <td class="px-5 py-3">{{ $i->servicio->nombre }}</td>
                                <td class="px-5 py-3">{{ $i->tipo->nombre }}</td>
                                <td class="px-5 py-3">
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded font-semibold">L {{ number_format($i->precio, 2) }}</span>
                                </td>
                                <td class="px-5 py-3 text-gray-700">{{ $i->descripcion ?? '—' }}</td>
                                <td class="px-5 py-3">
                                    <span class="inline-flex items-center gap-1">
                                        <svg class="w-4 h-4 text-blue-400" fill="currentColor" viewBox="0 0 20 20"><path d="M10 10a4 4 0 100-8 4 4 0 000 8zm-7 8a7 7 0 1114 0H3z"/></svg>
                                        {{ $i->usuario->name }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-gray-600">{{ $i->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-gray-500 py-6">No se han registrado impresiones.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
