@extends('layouts.admin')

@section('title', 'Historial de Órdenes de Entrada')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6 bg-gray-50 min-h-screen">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">📦 Historial de Órdenes de Entrada</h1>
        <form method="GET" class="bg-white rounded-lg p-4 mb-6 shadow flex flex-wrap items-end gap-4">
            <div>
                <label class="text-sm text-gray-700 font-semibold">Desde:</label>
                <input type="date" name="desde" value="{{ request('desde') }}" class="border-gray-300 rounded px-3 py-1">
            </div>
            <div>
                <label class="text-sm text-gray-700 font-semibold">Hasta:</label>
                <input type="date" name="hasta" value="{{ request('hasta') }}"
                    class="border-gray-300 rounded px-3 py-1">
            </div>
            <div>
                <label class="text-sm text-gray-700 font-semibold">Producto:</label>
                <input type="text" name="producto" value="{{ request('producto') }}" placeholder="Nombre del producto"
                    class="border-gray-300 rounded px-3 py-1">
            </div>
            <div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Filtrar</button>
                <a href="{{ route('ordenes-entrada.index') }}" class="ml-2 text-sm text-gray-600 underline">Limpiar</a>
            </div>
        </form>

        @foreach ($ordenes as $orden)
            <div class="bg-white shadow rounded-lg mb-6 p-4">
                <div class="flex justify-between items-center mb-3">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-700">Orden: <span
                                class="text-blue-600">{{ $orden->codigo }}</span></h2>
                        <p class="text-sm text-gray-500">Registrado por: <strong>{{ $orden->usuario->name }}</strong> |
                            {{ $orden->created_at->format('d/m/Y H:i') }}</p>
                        @if ($orden->descripcion)
                            <p class="text-gray-600 italic mt-1">📄 {{ $orden->descripcion }}</p>
                        @endif
                    </div>
                </div>

                <table class="w-full table-auto border text-sm text-left">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600">
                            <th class="px-4 py-2 border">#</th>
                            <th class="px-4 py-2 border">Producto</th>
                            <th class="px-4 py-2 border">Código</th>
                            <th class="px-4 py-2 border">Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orden->detalles as $i => $detalle)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border">{{ $i + 1 }}</td>
                                <td class="px-4 py-2 border">{{ $detalle->producto->nombre }}</td>
                                <td class="px-4 py-2 border">{{ $detalle->producto->codigo }}</td>
                                <td class="px-4 py-2 border">{{ $detalle->cantidad }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach

        <div class="mt-4">
            {{ $ordenes->links() }}
        </div>
    </div>
@endsection
