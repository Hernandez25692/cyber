@extends('layouts.admin')
@section('title', 'Reporte de Impresiones')

@section('content')
    <div class="max-w-6xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">📊 Reporte de Impresiones Realizadas</h1>

        <div class="bg-white shadow p-4 rounded">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2">Servicio</th>
                        <th class="px-4 py-2">Tipo</th>
                        <th class="px-4 py-2">Precio</th>
                        <th class="px-4 py-2">Descripción</th>
                        <th class="px-4 py-2">Cajero</th>
                        <th class="px-4 py-2">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($impresiones as $i)
                        <tr class="border-b">
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
@endsection
