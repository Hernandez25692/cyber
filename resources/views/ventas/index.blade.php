@extends('layouts.admin')

@section('title', 'Historial de Ventas')

@section('content')
    <div class="max-w-6xl mx-auto px-6 py-10 bg-gradient-to-br from-gray-50 via-green-50 to-gray-100 rounded-2xl shadow-2xl border border-green-200">
        {{-- Header --}}
        <div class="flex items-center gap-4 mb-10">
            <span class="bg-green-600 text-white rounded-full p-3 shadow-lg flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17v-2a4 4 0 014-4h3m4 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </span>
            <h1 class="text-3xl font-extrabold text-green-800 tracking-tight">🧾 Historial de Ventas</h1>
        </div>

        {{-- Filtros --}}
        <form method="GET" class="bg-white rounded-xl shadow px-8 py-6 mb-8 flex flex-wrap gap-6 items-end">
            <div class="flex flex-col w-full sm:w-40">
                <label class="block text-sm font-medium text-gray-700 mb-1">Cajero</label>
                <select name="user_id" class="form-select rounded-md w-full">
                    <option value="">Todos</option>
                    @foreach ($cajeros as $cajero)
                        <option value="{{ $cajero->id }}" {{ request('user_id') == $cajero->id ? 'selected' : '' }}>
                            {{ $cajero->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col w-full sm:w-40">
                <label class="block text-sm font-medium text-gray-700 mb-1">Desde</label>
                <input 
                    type="date" 
                    name="desde" 
                    class="form-input rounded-md w-full" 
                    value="{{ request('desde') }}"
                    id="desde"
                    max="{{ request('hasta') }}"
                >
            </div>
            <div class="flex flex-col w-full sm:w-40">
                <label class="block text-sm font-medium text-gray-700 mb-1">Hasta</label>
                <input 
                    type="date" 
                    name="hasta" 
                    class="form-input rounded-md w-full" 
                    value="{{ request('hasta') }}"
                    id="hasta"
                    min="{{ request('desde') }}"
                >
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const desde = document.getElementById('desde');
                    const hasta = document.getElementById('hasta');
                    desde.addEventListener('change', function() {
                        hasta.min = desde.value;
                    });
                    hasta.addEventListener('change', function() {
                        desde.max = hasta.value;
                    });
                });
            </script>
            <div class="flex flex-col w-full sm:w-48">
                <label class="block text-sm font-medium text-gray-700 mb-1">Código Producto</label>
                <input type="text" name="codigo" class="form-input rounded-md w-full" placeholder="Ej: P001"
                    value="{{ request('codigo') }}">
            </div>
            <div class="flex gap-2 w-full sm:w-auto">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md shadow hover:bg-blue-700 transition">
                    🔍 Filtrar
                </button>
                <a href="{{ route('ventas.index') }}" class="text-sm text-gray-500 hover:underline px-2 py-2">Limpiar</a>
            </div>
        </form>

        {{-- Tabla de Ventas --}}
        <div class="overflow-x-auto rounded-lg shadow-inner border border-green-200 bg-white">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-gradient-to-r from-green-200 via-green-100 to-green-50 text-green-900 uppercase tracking-wider">
                    <tr>
                        <th class="p-4 font-semibold border-b border-green-300 text-left">ID</th>
                        <th class="p-4 font-semibold border-b border-green-300 text-left">Usuario</th>
                        <th class="p-4 font-semibold border-b border-green-300 text-left">Total</th>
                        <th class="p-4 font-semibold border-b border-green-300 text-left">Recibido</th>
                        <th class="p-4 font-semibold border-b border-green-300 text-left">Cambio</th>
                        <th class="p-4 font-semibold border-b border-green-300 text-left">Fecha</th>
                        <th class="p-4 font-semibold border-b border-green-300 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ventas as $venta)
                        <tr class="border-b border-green-100 hover:bg-green-50 transition-colors duration-150">
                            <td class="p-4 font-mono text-green-800 font-bold">#{{ $venta->id }}</td>
                            <td class="p-4">
                                <span class="inline-block bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-semibold">
                                    {{ $venta->user->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="p-4 font-bold text-green-700 bg-green-50 rounded-lg">L. {{ number_format($venta->total, 2) }}</td>
                            <td class="p-4 text-green-600">L. {{ number_format($venta->monto_recibido, 2) }}</td>
                            <td class="p-4 text-green-600">L. {{ number_format($venta->cambio, 2) }}</td>
                            <td class="p-4 text-gray-500 font-mono">{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                            <td class="p-4">
                                <a href="{{ route('ventas.show', $venta) }}"
                                    class="inline-block bg-gradient-to-r from-green-400 to-green-600 text-white px-4 py-2 rounded-lg shadow hover:from-green-500 hover:to-green-700 font-semibold transition">
                                    Ver Detalle
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-6 text-center text-gray-400">No hay ventas registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        <div class="mt-2 flex justify-center">
            {{ $ventas->appends(request()->query())->links('pagination::tailwind') }}
        </div>
            </div>
        </div>
    </div>
@endsection
