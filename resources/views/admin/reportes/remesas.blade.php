@extends('layouts.admin')

@section('title', 'Reporte de Remesas')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 bg-gradient-to-br from-gray-100 via-blue-50 to-gray-200 min-h-screen font-sans">
    <!-- Header estilo SAP -->
    <div class="mb-8 flex items-center justify-between border-b-4 border-blue-700 pb-4">
        <div>
            <h1 class="text-4xl font-extrabold text-blue-900 flex items-center gap-3 tracking-tight">
                <svg class="w-8 h-8 text-blue-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="3" width="18" height="18" rx="4" stroke="currentColor" fill="#e3e8f0"/>
                    <path d="M7 7h10M7 12h10M7 17h6" stroke="#3b82f6" stroke-width="2" stroke-linecap="round"/>
                </svg>
                Reporte de Remesas Realizadas
            </h1>
            <p class="text-base text-blue-700 mt-1">Visualiza el historial de remesas procesadas por los cajeros del sistema.</p>
        </div>
        <a href="{{ route('admin.index') }}" class="bg-blue-700 text-white px-6 py-2 rounded-lg shadow-lg hover:bg-blue-800 transition flex items-center gap-2 font-semibold">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M15 19l-7-7 7-7" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Regresar
        </a>
    </div>

    <!-- Filtros estilo SAP (placeholder) -->
    <div class="mb-6 flex flex-wrap items-center gap-4 bg-white rounded-xl shadow p-4 border border-blue-100">
        <div>
            <label class="block text-xs text-blue-900 font-semibold mb-1">Buscar por Cajero</label>
            <input type="text" placeholder="Nombre del cajero..." class="border border-blue-200 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 bg-blue-50 text-blue-900"/>
        </div>
        <div>
            <label class="block text-xs text-blue-900 font-semibold mb-1">Fecha</label>
            <input type="date" class="border border-blue-200 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 bg-blue-50 text-blue-900"/>
        </div>
        <button class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition font-semibold mt-6">Filtrar</button>
    </div>

    <!-- Tarjeta principal de reporte -->
    <div class="grid grid-cols-1">
        <div class="bg-white rounded-2xl shadow-xl border border-blue-200 p-0 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-700 to-blue-500 px-6 py-4 flex items-center gap-2">
                <span class="text-xl font-bold text-white flex items-center gap-2">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="4" y="4" width="16" height="16" rx="3" stroke="currentColor"/>
                        <path d="M8 8h8M8 12h8M8 16h4" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    Detalle de Remesas
                </span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-blue-900">
                    <thead class="bg-blue-100 text-blue-900 uppercase text-xs font-bold border-b-2 border-blue-300">
                        <tr>
                            <th class="p-3 text-left">Fecha</th>
                            <th class="p-3 text-left">Cajero</th>
                            <th class="p-3 text-left">Monto</th>
                            <th class="p-3 text-left">Comisión</th>
                            <th class="p-3 text-left">Referencia</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($remesas as $r)
                            <tr class="border-b border-blue-100 hover:bg-blue-50 transition-colors">
                                <td class="p-3 whitespace-nowrap">{{ $r->created_at->format('Y-m-d H:i') }}</td>
                                <td class="p-3 whitespace-nowrap font-semibold">{{ $r->usuario->name }}</td>
                                <td class="p-3 whitespace-nowrap">L. {{ number_format($r->monto, 2) }}</td>
                                <td class="p-3 whitespace-nowrap text-blue-700">L. {{ number_format($r->comision, 2) }}</td>
                                <td class="p-3 whitespace-nowrap">{{ $r->referencia ?? '---' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-blue-400 py-6 font-semibold">No hay registros</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
