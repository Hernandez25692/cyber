@extends('layouts.admin')

@section('title', 'Reporte de Depósitos')

@section('content')
    <h1 class="text-2xl font-bold text-blue-600 mb-6">Reporte de Depósitos</h1>

    {{-- Filtros --}}
    <form method="GET" class="mb-6 flex flex-wrap gap-4 items-end bg-blue-50 p-4 rounded shadow">
        <div>
            <label for="desde" class="block text-sm font-medium text-gray-700">Desde</label>
            <input type="date" name="desde" id="desde" value="{{ request('desde') }}"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        </div>
        <div>
            <label for="hasta" class="block text-sm font-medium text-gray-700">Hasta</label>
            <input type="date" name="hasta" id="hasta" value="{{ request('hasta') }}"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        </div>
        <div>
            <label for="banco_id" class="block text-sm font-medium text-gray-700">Banco</label>
            <select name="banco_id" id="banco_id"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                <option value="">Todos</option>
                @foreach ($bancos as $banco)
                    <option value="{{ $banco->id }}" @selected(request('banco_id') == $banco->id)>
                        {{ $banco->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="user_id" class="block text-sm font-medium text-gray-700">Usuario</label>
            <select name="user_id" id="user_id"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                <option value="">Todos</option>
                @foreach ($usuarios as $usuario)
                    <option value="{{ $usuario->id }}" @selected(request('user_id') == $usuario->id)>
                        {{ $usuario->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Filtrar
            </button>
            <a href="{{ route('admin.reportes.depositos.index') }}"
                class="ml-2 inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                Limpiar
            </a>
        </div>
    </form>

    {{-- Totales --}}
    <div class="mb-4 flex flex-wrap gap-6">
        <div class="bg-blue-100 px-4 py-2 rounded shadow">
            <span class="font-semibold text-blue-700">Total Monto:</span>
            <span class="font-bold">L. {{ number_format($totales['monto'], 2) }}</span>
        </div>
        <div class="bg-blue-100 px-4 py-2 rounded shadow">
            <span class="font-semibold text-blue-700">Total Comisión:</span>
            <span class="font-bold">L. {{ number_format($totales['comision'], 2) }}</span>
        </div>
        <div class="bg-blue-100 px-4 py-2 rounded shadow">
            <span class="font-semibold text-blue-700">Total Neto:</span>
            <span class="font-bold">L. {{ number_format($totales['neto'], 2) }}</span>
        </div>
    </div>

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
                        <td class="px-4 py-2 text-right text-blue-600 font-bold">L. {{ number_format($dep->comision, 2) }}</td>
                        <td class="px-4 py-2 text-center">{{ $dep->referencia ?? '-' }}</td>
                        <td class="px-4 py-2 text-center">{{ $dep->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
