@extends('layouts.admin')

@section('title', 'Reporte de Retiros')

@section('content')
    <h2 class="text-2xl font-bold text-purple-700 mb-6">📋 Reporte de Retiros Realizados</h2>

    <table class="w-full bg-white shadow rounded text-sm">
        <thead class="bg-purple-100 text-gray-700">
            <tr>
                <th class="p-2">Fecha</th>
                <th class="p-2">Cajero</th>
                <th class="p-2">Monto</th>
                <th class="p-2">Comisión</th>
                <th class="p-2">Referencia</th>
            </tr>
        </thead>
        <tbody>
            @forelse($retiros as $r)
                <tr class="border-b hover:bg-purple-50">
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
@endsection
