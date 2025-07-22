@extends('layouts.admin')
@section('title', 'Reporte de Impresiones')

@section('content')
<div class="min-h-screen bg-gray-50 py-6">
    <div class="max-w-7xl mx-auto px-4 py-6">
        <!-- Título principal y subtítulo -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center gap-2">
                📊 Reporte de Impresiones Realizadas
            </h1>
            <p class="text-sm text-gray-500">Visualiza el historial de impresiones realizadas por los usuarios del sistema.</p>
        </div>

        <!-- Sección de acciones -->
        <div class="mb-6 flex items-center gap-3">
            <a href="{{ route('admin.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600 flex items-center gap-2">
                ← Regresar
            </a>
        </div>

        <!-- Tarjeta principal de reporte -->
        <div class="bg-white rounded-xl shadow p-6">
            <div class="mb-4 flex items-center gap-2">
                <span class="text-lg font-semibold text-gray-700">🖨️ Impresiones Registradas</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">Servicio</th>
                            <th class="px-4 py-2 text-left">Tipo</th>
                            <th class="px-4 py-2 text-left">Precio</th>
                            <th class="px-4 py-2 text-left">Descripción</th>
                            <th class="px-4 py-2 text-left">Cajero</th>
                            <th class="px-4 py-2 text-left">Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($impresiones as $i)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="px-4 py-2">{{ $i->servicio->nombre }}</td>
                                <td class="px-4 py-2">{{ $i->tipo->nombre }}</td>
                                <td class="px-4 py-2">L {{ number_format($i->precio, 2) }}</td>
                                <td class="px-4 py-2">{{ $i->descripcion ?? '—' }}</td>
                                <td class="px-4 py-2">{{ $i->usuario->name }}</td>
                                <td class="px-4 py-2">{{ $i->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-gray-500 py-4">No se han registrado impresiones.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
