@extends('layouts.admin')

@section('title', 'Reporte de Remesas')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 bg-gray-50 min-h-screen">
    <!-- Título principal y subtítulo -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center gap-2">
            📊 Reporte de Remesas Realizadas
        </h1>
        <p class="text-sm text-gray-500">Visualiza el historial de remesas procesadas por los cajeros del sistema.</p>
    </div>

    <!-- Sección de acciones -->
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('admin.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600 flex items-center gap-2">
            ← Regresar
        </a>
        <!-- Puedes agregar más acciones aquí si lo deseas -->
    </div>

    <!-- Tarjeta principal de reporte -->
    <div class="grid grid-cols-1">
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center gap-2 mb-4">
                <span class="text-lg font-semibold text-gray-700">📄 Detalle de Remesas</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white text-sm">
                    <thead class="bg-purple-100 text-gray-700">
                        <tr>
                            <th class="p-2 text-left">Fecha</th>
                            <th class="p-2 text-left">Cajero</th>
                            <th class="p-2 text-left">Monto</th>
                            <th class="p-2 text-left">Comisión</th>
                            <th class="p-2 text-left">Referencia</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($remesas as $r)
                            <tr class="border-b hover:bg-purple-50 transition-colors">
                                <td class="p-2">{{ $r->created_at->format('Y-m-d H:i') }}</td>
                                <td class="p-2">{{ $r->usuario->name }}</td>
                                <td class="p-2">L. {{ number_format($r->monto, 2) }}</td>
                                <td class="p-2 text-purple-700">L. {{ number_format($r->comision, 2) }}</td>
                                <td class="p-2">{{ $r->referencia ?? '---' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-gray-500 py-4">No hay registros</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
