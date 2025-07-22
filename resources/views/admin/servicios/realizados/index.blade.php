@extends('layouts.admin')

@section('title', 'Reporte de Servicios Realizados')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">📝 Reporte de Servicios Realizados</h1>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white shadow rounded-lg p-4">
            <table class="min-w-full text-sm text-left text-gray-700 border">
                <thead class="text-xs text-gray-100 uppercase bg-blue-700">
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Tipo de Servicio</th>
                        <th class="px-4 py-2">Banco</th>
                        <th class="px-4 py-2">Comisión</th>
                        <th class="px-4 py-2">Referencia / ID</th>
                        <th class="px-4 py-2">Realizado por</th>
                        <th class="px-4 py-2">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($servicios as $servicio)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $servicio->id }}</td>
                            <td class="px-4 py-2">{{ $servicio->tipoServicio->nombre ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $servicio->banco->nombre ?? '-' }}</td>
                            <td class="px-4 py-2">L {{ number_format($servicio->comision, 2) }}</td>
                            <td class="px-4 py-2">{{ $servicio->referencia ?? '—' }}</td>
                            <td class="px-4 py-2">{{ $servicio->usuario->name ?? 'Desconocido' }}</td>
                            <td class="px-4 py-2">{{ $servicio->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-gray-500">No hay servicios registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
