@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 bg-gradient-to-br from-gray-50 via-white to-gray-100 min-h-screen">
    <!-- Título principal y subtítulo -->
    <div class="mb-10">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-2 flex items-center gap-3 drop-shadow">
            <span class="text-indigo-600">📊</span> Reporte de Retiros Realizados
        </h1>
        <p class="text-base text-gray-500">Visualiza el historial de retiros realizados por los usuarios del sistema.</p>
    </div>

    <!-- Sección de acciones -->
    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('admin.index') }}" class="bg-indigo-500 text-white px-5 py-2 rounded-lg shadow hover:bg-indigo-600 transition flex items-center gap-2 font-semibold">
            ← Regresar
        </a>
        <!-- Puedes agregar más acciones aquí si lo deseas -->
    </div>

    <!-- Tarjeta principal de reporte -->
    <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
        <div class="mb-6 flex items-center gap-2">
            <span class="text-xl font-bold text-indigo-700 flex items-center gap-2">🗂️ Retiros registrados</span>
        </div>
        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-indigo-50">
                        <th class="px-6 py-4 text-left text-xs font-bold text-indigo-700 uppercase tracking-wider">Usuario</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-indigo-700 uppercase tracking-wider">Monto</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-indigo-700 uppercase tracking-wider">Comisión</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-indigo-700 uppercase tracking-wider">Referencia</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-indigo-700 uppercase tracking-wider">Fecha</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($retiros as $retiro)
                        <tr class="hover:bg-indigo-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900 font-medium flex items-center gap-2">
                                <span class="inline-block w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold">
                                    {{ strtoupper(substr($retiro->usuario->name, 0, 1)) }}
                                </span>
                                {{ $retiro->usuario->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-green-600 font-bold">L {{ number_format($retiro->monto, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-blue-600 font-semibold">L {{ number_format($retiro->comision, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $retiro->referencia ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $retiro->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-400">No hay retiros registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
