@extends('layouts.admin')

@section('title', 'Reporte de Depósitos')

@section('content')
    <h1 class="text-2xl font-bold text-blue-600 mb-6">Reporte de Depósitos</h1>

    @if ($depositos->isEmpty())
        <p class="text-gray-500">No hay depósitos registrados aún.</p>
    @else
        <table class="min-w-full bg-white border rounded-lg shadow">
            <thead class="bg-blue-100">
                <tr>
                    <th class="px-4 py-2 text-left">Usuario</th>
                    <th class="px-4 py-2 text-left">Banco</th>
                    <th class="px-4 py-2 text-right">Monto</th>
                    <th class="px-4 py-2 text-right">Comisión</th>
                    <th class="px-4 py-2 text-center">Referencia</th>
                    <th class="px-4 py-2 text-center">Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($depositos as $dep)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $dep->usuario->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ $dep->banco->nombre ?? 'N/A' }}</td>
                        <td class="px-4 py-2 text-right">L. {{ number_format($dep->monto, 2) }}</td>
                        <td class="px-4 py-2 text-right text-blue-600 font-bold">L. {{ number_format($dep->comision, 2) }}
                        </td>
                        <td class="px-4 py-2 text-center">{{ $dep->referencia ?? '-' }}</td>
                        <td class="px-4 py-2 text-center">{{ $dep->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
