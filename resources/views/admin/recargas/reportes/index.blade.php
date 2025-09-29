@extends('layouts.admin')
@section('title', 'Reporte de Recargas')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 bg-gradient-to-br from-blue-50 via-white to-purple-50 min-h-screen">
    <!-- Título principal y subtítulo -->
    <div class="mb-10">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-2 flex items-center gap-3 drop-shadow">
            <span class="bg-gradient-to-r from-blue-500 to-purple-500 text-white px-3 py-1 rounded-lg">📊</span>
            Reporte de Recargas Realizadas
        </h1>
        <p class="text-base text-gray-600">Consulta el historial de recargas realizadas por los cajeros del sistema.</p>
    </div>

    <!-- Sección de acciones -->
    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('admin.index') }}" class="bg-gradient-to-r from-gray-600 to-gray-800 text-white px-5 py-2 rounded-lg shadow-lg hover:scale-105 transition flex items-center gap-2 font-semibold">
            <span>←</span> Regresar
        </a>
        <!-- Puedes agregar más acciones aquí si lo deseas -->
    </div>

    <!-- Tarjeta principal de reporte -->
    <div class="grid grid-cols-1">
        <div class="bg-white rounded-2xl shadow-2xl p-8 border border-gray-200">
            <div class="mb-6 flex items-center gap-3">
                <span class="text-xl font-bold text-purple-700 flex items-center gap-2">
                    <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2a4 4 0 004 4h2a4 4 0 004-4zM15 7V5a4 4 0 00-4-4H9a4 4 0 00-4 4v2a4 4 0 004 4h2a4 4 0 004-4z" /></svg>
                    Detalle de Recargas
                </span>
            </div>
            <div class="overflow-x-auto rounded-lg border border-gray-100 shadow">
                <table class="min-w-full text-sm bg-white">
                    <thead class="bg-gradient-to-r from-blue-100 to-purple-100">
                        <tr>
                            <th class="px-5 py-3 text-left text-gray-700 font-bold">Proveedor</th>
                            <th class="px-5 py-3 text-left text-gray-700 font-bold">Paquete</th>
                            <th class="px-5 py-3 text-left text-gray-700 font-bold">Número</th>
                            <th class="px-5 py-3 text-left text-gray-700 font-bold">Precio</th>
                            <th class="px-5 py-3 text-left text-gray-700 font-bold">Cajero</th>
                            <th class="px-5 py-3 text-left text-gray-700 font-bold">Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recargas as $r)
                            <tr class="border-b hover:bg-purple-50 transition">
                                <td class="px-5 py-3 font-semibold text-blue-700">{{ $r->paquete->proveedor->nombre }}</td>
                                <td class="px-5 py-3">{{ $r->paquete->descripcion }}</td>
                                <td class="px-5 py-3">{{ $r->numero ?? '—' }}</td>
                                <td class="px-5 py-3 text-green-600 font-bold">L {{ number_format($r->paquete->precio, 2) }}</td>
                                <td class="px-5 py-3">{{ $r->usuario->name }}</td>
                                <td class="px-5 py-3">{{ $r->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-8 text-center text-gray-400">No hay recargas registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
