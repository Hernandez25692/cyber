@extends('layouts.admin')
@section('title', 'Reporte de Recargas')

@section('content')
    <div class="max-w-6xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">📊 Reporte de Recargas Realizadas</h1>

        <div class="bg-white shadow p-4 rounded">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2">Proveedor</th>
                        <th class="px-4 py-2">Paquete</th>
                        <th class="px-4 py-2">Número</th>
                        <th class="px-4 py-2">Precio</th>
                        <th class="px-4 py-2">Cajero</th>
                        <th class="px-4 py-2">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recargas as $r)
                        <tr class="border-b">
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
@endsection
