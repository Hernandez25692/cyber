@extends('layouts.admin')

@section('title', 'Retiros y Comisiones')

@section('content')
    <h2 class="text-2xl font-bold text-purple-700 mb-6">💸 Comisiones de Retiros</h2>

    <a href="{{ route('admin.retiros.create') }}"
        class="bg-purple-600 text-white px-4 py-2 rounded shadow hover:bg-purple-700 mb-4 inline-block">
        ➕ Nueva Comisión
    </a>

    <table class="w-full bg-white shadow rounded text-sm">
        <thead class="bg-purple-100 text-gray-700">
            <tr>
                <th class="p-3">Nombre</th>
                <th class="p-3">Monto Mínimo</th>
                <th class="p-3">Monto Máximo</th>
                <th class="p-3">Comisión</th>
            </tr>
        </thead>
        <tbody>
            @forelse($retiros as $r)
                <tr class="border-b hover:bg-purple-50">
                    <td class="p-3">{{ $r->nombre }}</td>
                    <td class="p-3">L. {{ number_format($r->monto_min, 2) }}</td>
                    <td class="p-3">L. {{ number_format($r->monto_max, 2) }}</td>
                    <td class="p-3">L. {{ number_format($r->comision, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-gray-500 py-4">Sin registros</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
