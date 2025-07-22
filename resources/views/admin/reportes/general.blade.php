@extends('layouts.admin')

@section('title', 'Reporte General de Actividades')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">📊 Reporte General</h1>
        <p class="text-gray-600">Filtra y visualiza todas las operaciones realizadas por los cajeros</p>
    </div>

    <form method="GET" class="bg-white shadow rounded-lg p-4 mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label for="desde" class="block text-sm font-medium text-gray-700">Desde</label>
            <input type="date" name="desde" id="desde" value="{{ $filtros['desde'] }}"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        </div>
        <div>
            <label for="hasta" class="block text-sm font-medium text-gray-700">Hasta</label>
            <input type="date" name="hasta" id="hasta" value="{{ $filtros['hasta'] }}"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        </div>
        <div>
            <label for="user_id" class="block text-sm font-medium text-gray-700">Cajero</label>
            <select name="user_id" id="user_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                <option value="">Todos</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ $filtros['user_id'] == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="md:col-span-3 text-right">
            <button type="submit"
                class="bg-indigo-600 text-white px-6 py-2 rounded shadow hover:bg-indigo-700 transition">🔍 Filtrar</button>
        </div>
    </form>

    {{-- TABLAS --}}
    @foreach ([
            'remesas' => 'Remesas',
            'retiros' => 'Retiros',
            'servicios' => 'Servicios',
            'recargas' => 'Recargas',
            'impresiones' => 'Impresiones',
        ] as $variable => $titulo)
        @php $items = $$variable; @endphp
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-6 py-4 border-b flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-800">📂 {{ $titulo }}</h2>
                <span class="text-sm text-gray-500">Total: {{ $items->count() }}</span>
            </div>

            @if ($items->count())
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-gray-100 text-gray-600">
                            <tr>
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Cajero</th>
                                <th class="px-4 py-2">Fecha</th>
                                <th class="px-4 py-2">Monto/Comisión</th>
                                <th class="px-4 py-2">Detalles</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach ($items as $item)
                                <tr>
                                    <td class="px-4 py-2">{{ $item->id }}</td>
                                    <td class="px-4 py-2">{{ $item->user->name ?? '—' }}</td>
                                    <td class="px-4 py-2">{{ $item->created_at->format('Y-m-d H:i') }}</td>
                                    <td class="px-4 py-2">
                                        @if ($variable === 'remesas' || $variable === 'retiros')
                                            L {{ number_format($item->comision, 2) }}
                                        @elseif($variable === 'servicios')
                                            L {{ number_format($item->comision, 2) }}
                                        @elseif($variable === 'recargas')
                                            L {{ number_format($item->monto, 2) }}
                                        @elseif($variable === 'impresiones')
                                            L {{ number_format($item->precio, 2) }}
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 text-gray-600 text-xs">
                                        @if ($variable === 'remesas')
                                            Banco: {{ $item->banco->nombre ?? '' }} | Ref: {{ $item->referencia }}
                                        @elseif($variable === 'retiros')
                                            Banco: {{ $item->banco->nombre ?? '' }} | Ref: {{ $item->referencia }}
                                        @elseif($variable === 'servicios')
                                            Tipo: {{ $item->tipoServicio->nombre ?? '' }}
                                        @elseif($variable === 'recargas')
                                            Proveedor: {{ $item->proveedor->nombre ?? '' }}
                                        @elseif($variable === 'impresiones')
                                            Servicio: {{ $item->servicio->nombre ?? '' }} | Tipo:
                                            {{ $item->tipo->nombre ?? '' }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-4 text-sm text-gray-500">No hay registros en este rango.</div>
            @endif
        </div>
    @endforeach
@endsection
