@extends('layouts.admin')
@section('title', 'Reporte de Recargas')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 bg-gray-50 min-h-screen">
    <!-- Título principal y subtítulo -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center gap-2">
            📊 Reporte de Recargas Realizadas
        </h1>
        <p class="text-sm text-gray-500">Consulta el historial de recargas realizadas por los cajeros del sistema.</p>
    </div>

    <!-- Sección de acciones -->
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('admin.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600 flex items-center gap-2">
            <span>←</span> Regresar
        </a>
        <!-- Puedes agregar más acciones aquí si lo deseas -->
    </div>

    <!-- Tarjeta principal de reporte -->
    <div class="grid grid-cols-1">
        <div class="bg-white rounded-xl shadow p-6">
            <div class="mb-4 flex items-center gap-2">
                <span class="text-lg font-semibold text-gray-700">📄 Detalle de Recargas</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left text-gray-600 font-medium">Proveedor</th>
                            <th class="px-4 py-2 text-left text-gray-600 font-medium">Paquete</th>
                            <th class="px-4 py-2 text-left text-gray-600 font-medium">Número</th>
                            <th class="px-4 py-2 text-left text-gray-600 font-medium">Precio</th>
                            <th class="px-4 py-2 text-left text-gray-600 font-medium">Cajero</th>
                            <th class="px-4 py-2 text-left text-gray-600 font-medium">Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recargas as $r)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="px-4 py-2">{{ $r->paquete->proveedor->nombre }}</td>
                                <td class="px-4 py-2">{{ $r->paquete->descripcion }}</td>
                                <td class="px-4 py-2">{{ $r->numero ?? '—' }}</td>
                                <td class="px-4 py-2">L {{ number_format($r->paquete->precio, 2) }}</td>
                                <td class="px-4 py-2">{{ $r->usuario->name }}</td>
                                <td class="px-4 py-2">{{ $r->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
