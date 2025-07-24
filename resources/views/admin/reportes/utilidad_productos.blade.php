@extends('layouts.admin')

@section('title', 'Reporte de Utilidad de Productos')

@section('content')
    <div class="container mx-auto max-w-7xl px-4">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Reporte de Utilidad de Productos</h1>

        {{-- Filtros --}}
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 bg-white p-6 rounded-lg shadow mb-8">
            <div>
                <label for="desde" class="block text-sm font-medium text-gray-700">Desde</label>
                <input type="date" name="desde" id="desde" value="{{ $filtros['desde'] }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label for="hasta" class="block text-sm font-medium text-gray-700">Hasta</label>
                <input type="date" name="hasta" id="hasta" value="{{ $filtros['hasta'] }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-700">Cajero</label>
                <select name="user_id" id="user_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Todos</option>
                    @foreach ($usuarios as $user)
                        <option value="{{ $user->id }}" {{ $filtros['user_id'] == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit"
                    class="w-full bg-indigo-600 text-white px-4 py-2 rounded shadow hover:bg-indigo-700">Aplicar</button>
            </div>
        </form>

        {{-- Resumen --}}
        @php
            $total_ventas = 0;
            $total_utilidad = 0;
            foreach ($detalles as $d) {
                $subtotal = $d->cantidad * $d->precio_unitario;
                $costo = $d->cantidad * $d->producto->precio_compra;
                $utilidad = $subtotal - $costo;
                $total_ventas += $subtotal;
                $total_utilidad += $utilidad;
            }
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-green-100 p-6 rounded-lg text-center shadow">
                <p class="text-gray-600 text-sm">Total Ventas</p>
                <p class="text-2xl font-bold text-green-800">L {{ number_format($total_ventas, 2) }}</p>
            </div>
            <div class="bg-blue-100 p-6 rounded-lg text-center shadow">
                <p class="text-gray-600 text-sm">Ganancia Total</p>
                <p class="text-2xl font-bold text-blue-800">L {{ number_format($total_utilidad, 2) }}</p>
            </div>
        </div>

        {{-- Tabla Detalle --}}
        <div class="overflow-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">Fecha</th>
                        <th class="px-6 py-3">Producto</th>
                        <th class="px-6 py-3">Cajero</th>
                        <th class="px-6 py-3">Cant</th>
                        <th class="px-6 py-3">Venta</th>
                        <th class="px-6 py-3">Compra</th>
                        <th class="px-6 py-3">Subtotal</th>
                        <th class="px-6 py-3">Ganancia</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach ($detalles as $d)
                        @php
                            $venta = $d->precio_unitario;
                            $compra = $d->producto->precio_compra;
                            $subtotal = $d->cantidad * $venta;
                            $utilidad = $subtotal - $d->cantidad * $compra;
                        @endphp
                        <tr>
                            <td class="px-6 py-4">{{ $d->venta->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4">{{ $d->producto->nombre }}</td>
                            <td class="px-6 py-4">{{ $d->venta->user->name ?? '—' }}</td>
                            <td class="px-6 py-4">{{ $d->cantidad }}</td>
                            <td class="px-6 py-4">L {{ number_format($venta, 2) }}</td>
                            <td class="px-6 py-4">L {{ number_format($compra, 2) }}</td>
                            <td class="px-6 py-4">L {{ number_format($subtotal, 2) }}</td>
                            <td class="px-6 py-4 font-bold text-blue-700">L {{ number_format($utilidad, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
