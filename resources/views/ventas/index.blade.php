@extends('layouts.admin')

@section('title', 'Historial de Ventas')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-6 bg-white rounded-lg shadow">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">🧾 Historial de Ventas</h1>

        <table class="w-full table-auto text-sm border">
            <thead class="bg-green-100 text-left">
                <tr>
                    <th class="p-3">ID</th>
                    <th class="p-3">Usuario</th>
                    <th class="p-3">Total</th>
                    <th class="p-3">Recibido</th>
                    <th class="p-3">Cambio</th>
                    <th class="p-3">Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ventas as $venta)
                    <tr class="border-b hover:bg-green-50">
                        <td class="p-3">#{{ $venta->id }}</td>
                        <td class="p-3">{{ $venta->user->name ?? 'N/A' }}</td>
                        <td class="p-3 font-bold text-green-700">L. {{ number_format($venta->total, 2) }}</td>
                        <td class="p-3">L. {{ number_format($venta->monto_recibido, 2) }}</td>
                        <td class="p-3">L. {{ number_format($venta->cambio, 2) }}</td>
                        <td class="p-3 text-gray-600">{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-6">
            {{ $ventas->links() }}
        </div>
    </div>
@endsection
