@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 bg-gray-50 min-h-screen">
    <!-- Título principal y subtítulo -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center gap-2">
            📊 Reporte de Retiros Realizados
        </h1>
        <p class="text-sm text-gray-500">Visualiza el historial de retiros realizados por los usuarios del sistema.</p>
    </div>

    <!-- Sección de acciones -->
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('admin.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600 flex items-center gap-2">
            ← Regresar
        </a>
        <!-- Puedes agregar más acciones aquí si lo deseas -->
    </div>

    <!-- Tarjeta principal de reporte -->
    <div class="bg-white rounded-xl shadow p-6">
        <div class="mb-4 flex items-center gap-2">
            <span class="text-lg font-semibold text-gray-700">🗂️ Retiros registrados</span>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Usuario</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Monto</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Comisión</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Referencia</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Fecha</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach ($retiros as $retiro)
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap text-gray-800">{{ $retiro->usuario->name }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-green-600 font-semibold">L {{ number_format($retiro->monto, 2) }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-blue-600">L {{ number_format($retiro->comision, 2) }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-gray-700">{{ $retiro->referencia ?? 'N/A' }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-gray-500">{{ $retiro->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
