@extends('layouts.admin')

@section('title', 'Detalle de Ajuste ' . $ajuste->codigo)

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold text-gray-700 mb-4">🧾 Detalle del Ajuste: {{ $ajuste->codigo }}</h1>

        <div class="mb-4">
            <p><strong>Realizado por:</strong> {{ $ajuste->usuario->name }}</p>
            <p><strong>Fecha:</strong> {{ $ajuste->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Descripción:</strong> {{ $ajuste->descripcion ?? '—' }}</p>
        </div>

        <div class="overflow-x-auto bg-white shadow rounded p-4">
            <table class="w-full text-sm border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-2 py-1 border">Código</th>
                        <th class="px-2 py-1 border">Producto</th>
                        <th class="px-2 py-1 border">Stock Sistema</th>
                        <th class="px-2 py-1 border">Stock Físico</th>
                        <th class="px-2 py-1 border">Diferencia</th>
                        <th class="px-2 py-1 border">Observación</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ajuste->detalles as $detalle)
                        <tr>
                            <td class="border px-2 py-1">{{ $detalle->producto->codigo }}</td>
                            <td class="border px-2 py-1">{{ $detalle->producto->nombre }}</td>
                            <td class="border px-2 py-1">{{ $detalle->stock_sistema }}</td>
                            <td class="border px-2 py-1">{{ $detalle->stock_fisico }}</td>
                            <td class="border px-2 py-1">{{ $detalle->diferencia }}</td>
                            <td class="border px-2 py-1">{{ $detalle->observacion ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
