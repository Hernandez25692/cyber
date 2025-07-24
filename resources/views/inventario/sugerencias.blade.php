@extends('layouts.admin')

@section('title', 'Sugerencia de Pedido por Bajo Stock')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold text-red-700 mb-6">📦 Sugerencias de Pedido (Stock &lt; 10)</h1>

        @if ($productos->isEmpty())
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded">
                ✅ Todos los productos tienen suficiente stock.
            </div>
        @else
            <div class="overflow-auto rounded-lg shadow">
                <table class="min-w-full bg-white">
                    <thead class="bg-red-100 text-red-800">
                        <tr>
                            <th class="px-4 py-2 text-left">Código</th>
                            <th class="px-4 py-2 text-left">Nombre</th>
                            <th class="px-4 py-2 text-left">Categoría</th>
                            <th class="px-4 py-2 text-center">Stock Actual</th>
                            <th class="px-4 py-2 text-center">Sugerido a Pedir</th>
                            <th class="px-4 py-2 text-center">Última Modificación</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos as $producto)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-4 py-2 text-sm">{{ $producto->codigo }}</td>
                                <td class="px-4 py-2 font-semibold">{{ $producto->nombre }}</td>
                                <td class="px-4 py-2">{{ $producto->categoria ?? '—' }}</td>
                                <td class="px-4 py-2 text-center text-red-600 font-bold">{{ $producto->stock }}</td>
                                <td class="px-4 py-2 text-center text-blue-600">
                                    {{ max(10 - $producto->stock, 5) }}
                                </td>
                                <td class="px-4 py-2 text-center text-sm text-gray-500">
                                    {{ $producto->updated_at ? $producto->updated_at->format('d/m/Y H:i') : '—' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
