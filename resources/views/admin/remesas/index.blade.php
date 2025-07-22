@extends('layouts.admin')

@section('title', 'Remesas y Comisiones')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 bg-gray-50 min-h-screen">
    <!-- Título principal y subtítulo -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center gap-2">
            💸 Remesas y Comisiones
        </h1>
        <p class="text-sm text-gray-500">Gestión de comisiones para remesas en el sistema administrativo.</p>
    </div>

    <!-- Sección de acciones -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-3">
        <a href="{{ route('admin.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600 flex items-center gap-2">
            ← Regresar
        </a>
        <a href="{{ route('admin.remesas.create') }}" class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700 flex items-center gap-2">
            ➕ Nueva Comisión
        </a>
    </div>

    <!-- Tarjeta de listado de remesas -->
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
            📋 Comisiones registradas
        </h2>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-green-100 text-gray-700">
                    <tr>
                        <th class="p-3 text-left">Nombre</th>
                        <th class="p-3 text-left">Monto Mínimo</th>
                        <th class="p-3 text-left">Monto Máximo</th>
                        <th class="p-3 text-left">Comisión</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($remesas as $r)
                        <tr class="border-b hover:bg-green-50 transition-colors">
                            <td class="p-3">{{ $r->nombre }}</td>
                            <td class="p-3">L. {{ number_format($r->monto_min, 2) }}</td>
                            <td class="p-3">L. {{ number_format($r->monto_max, 2) }}</td>
                            <td class="p-3">L. {{ number_format($r->comision, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-4 text-center text-gray-500">Sin registros</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
