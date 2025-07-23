@extends('layouts.admin')

@section('title', 'Ajuste de Inventario')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6 bg-gray-100 min-h-screen">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">🧾 Ajuste de Inventario</h1>
            <p class="text-sm text-gray-600">Compara el inventario físico con el sistema y ajusta automáticamente.</p>
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('inventario.ajuste.store') }}">
            @csrf

            <div class="overflow-auto">
                <table class="w-full bg-white shadow-md rounded-lg overflow-hidden text-sm">
                    <thead class="bg-gray-200 text-gray-700">
                        <tr>
                            <th class="px-4 py-2 text-left">Código</th>
                            <th class="px-4 py-2 text-left">Nombre</th>
                            <th class="px-4 py-2 text-center">Stock Sistema</th>
                            <th class="px-4 py-2 text-center">Stock Físico</th>
                            <th class="px-4 py-2 text-center">Diferencia</th>
                            <th class="px-4 py-2 text-left">Observación</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos as $producto)
                            <tr class="border-t">
                                <td class="px-4 py-2">
                                    {{ $producto->codigo }}
                                    <input type="hidden" name="producto_id[]" value="{{ $producto->id }}">
                                </td>
                                <td class="px-4 py-2">{{ $producto->nombre }}</td>
                                <td class="px-4 py-2 text-center">
                                    <input type="number"
                                        class="border border-gray-300 rounded w-20 text-center bg-gray-100"
                                        value="{{ $producto->stock }}" readonly>
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <input type="number" name="stock_fisico[]"
                                        class="border border-gray-300 rounded w-20 text-center bg-white"
                                        value="" min="0" oninput="calcularDiferencia(this)">
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <input type="number"
                                        class="border border-gray-300 rounded w-20 text-center bg-gray-100" readonly>
                                </td>
                                <td class="px-4 py-2">
                                    <input type="text" name="observacion[]"
                                        class="w-full border border-gray-300 rounded p-1" placeholder="Opcional...">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end mt-6">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded shadow hover:bg-blue-700 transition">
                    Guardar Ajustes
                </button>
            </div>
        </form>
    </div>

    <script>
        function calcularDiferencia(input) {
            const row = input.closest('tr');
            const stockSistema = parseInt(row.querySelector('td:nth-child(3) input').value) || 0;
            const stockFisico = parseInt(input.value) || 0;
            const diferencia = stockFisico - stockSistema;
            row.querySelector('td:nth-child(5) input').value = diferencia;
        }
    </script>
@endsection
