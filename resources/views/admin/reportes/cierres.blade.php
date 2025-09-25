@extends('layouts.admin')

@section('title', 'Reportes Z / Cierres')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight mb-2">Reportes Z / Cierres</h1>
        <p class="text-gray-500">Consulta y gestiona los cierres de caja realizados por los cajeros.</p>
    </div>

    {{-- Filtros --}}
    <form method="GET" class="bg-gradient-to-r from-indigo-50 to-white p-6 rounded-2xl shadow-lg border mb-8">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
            <div>
                <label class="block text-xs font-bold text-indigo-700 mb-1 uppercase tracking-wider">Desde</label>
                <input type="date" name="desde" value="{{ $filtros['desde'] }}"
                    class="w-full border-2 border-indigo-200 focus:border-indigo-500 rounded-lg px-3 py-2 bg-white shadow-sm transition">
            </div>
            <div>
                <label class="block text-xs font-bold text-indigo-700 mb-1 uppercase tracking-wider">Hasta</label>
                <input type="date" name="hasta" value="{{ $filtros['hasta'] }}"
                    class="w-full border-2 border-indigo-200 focus:border-indigo-500 rounded-lg px-3 py-2 bg-white shadow-sm transition">
            </div>
            <div>
                <label class="block text-xs font-bold text-indigo-700 mb-1 uppercase tracking-wider">Cajero</label>
                <select name="user_id" class="w-full border-2 border-indigo-200 focus:border-indigo-500 rounded-lg px-3 py-2 bg-white shadow-sm transition">
                    <option value="">-- Todos --</option>
                    @foreach ($users as $u)
                        <option value="{{ $u->id }}" @selected($filtros['user_id'] == $u->id)>
                            {{ $u->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-indigo-700 mb-1 uppercase tracking-wider">Estado</label>
                <select name="estado" class="w-full border-2 border-indigo-200 focus:border-indigo-500 rounded-lg px-3 py-2 bg-white shadow-sm transition">
                    <option value="todos" @selected($filtros['estado'] == 'todos')>Todos</option>
                    <option value="cerrado" @selected($filtros['estado'] == 'cerrado')>Cerrado</option>
                    <option value="pendiente" @selected($filtros['estado'] == 'pendiente')>Pendiente</option>
                </select>
            </div>
            <div class="flex items-end">
                <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-semibold shadow transition">
                    <svg class="inline w-4 h-4 mr-2 -mt-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v16a1 1 0 01-1 1H4a1 1 0 01-1-1V4z" />
                        <path d="M8 10h8M8 14h8" />
                    </svg>
                    Filtrar
                </button>
            </div>
        </div>
    </form>

    {{-- Totales --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white border-2 border-indigo-100 rounded-2xl p-6 shadow flex flex-col items-center">
            <div class="text-xs text-gray-500 uppercase font-semibold tracking-wider mb-1">Registros</div>
            <div class="text-3xl font-extrabold text-indigo-700">{{ number_format($totales['registros']) }}</div>
        </div>
        <div class="bg-white border-2 border-green-100 rounded-2xl p-6 shadow flex flex-col items-center">
            <div class="text-xs text-gray-500 uppercase font-semibold tracking-wider mb-1">Total Ingresos</div>
            <div class="text-3xl font-extrabold text-green-700">L {{ number_format($totales['ingresos'], 2) }}</div>
        </div>
        <div class="bg-white border-2 border-red-100 rounded-2xl p-6 shadow flex flex-col items-center">
            <div class="text-xs text-gray-500 uppercase font-semibold tracking-wider mb-1">Total Egresos</div>
            <div class="text-3xl font-extrabold text-red-700">L {{ number_format($totales['egresos'], 2) }}</div>
        </div>
        <div class="bg-white border-2 border-blue-100 rounded-2xl p-6 shadow flex flex-col items-center">
            <div class="text-xs text-gray-500 uppercase font-semibold tracking-wider mb-1">Suma Diferencias</div>
            @php $dif = $totales['diferencia']; @endphp
            <div class="text-3xl font-extrabold {{ $dif > 0 ? 'text-green-700' : ($dif < 0 ? 'text-red-700' : 'text-blue-700') }}">
                L {{ number_format($dif, 2) }}
            </div>
        </div>
    </div>

    {{-- Tabla --}}
    <div class="bg-white rounded-2xl border-2 border-indigo-100 shadow-lg overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-indigo-50 text-indigo-800 uppercase text-xs font-bold tracking-wider">
                <tr>
                    <th class="px-4 py-3 text-left">Fecha Apertura</th>
                    <th class="px-4 py-3 text-left">Fecha Cierre</th>
                    <th class="px-4 py-3 text-left">Cajero</th>
                    <th class="px-4 py-3 text-right">Ingresos</th>
                    <th class="px-4 py-3 text-right">Egresos</th>
                    <th class="px-4 py-3 text-right">Efectivo Final</th>
                    <th class="px-4 py-3 text-right">Diferencia</th>
                    <th class="px-4 py-3 text-center">Estado</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cierres as $c)
                    @php
                        $ap = $c->apertura;
                        $u = $ap?->usuario;
                    @endphp
                    <tr class="border-t hover:bg-indigo-50 transition">
                        <td class="px-4 py-3">
                            {{ optional($ap?->created_at)->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-4 py-3">
                            {{ optional($c->updated_at)->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-4 py-3">
                            {{ $u?->name ?? '—' }}
                        </td>
                        <td class="px-4 py-3 text-right font-semibold text-green-700">
                            L {{ number_format($c->total_ingresos, 2) }}
                        </td>
                        <td class="px-4 py-3 text-right font-semibold text-red-700">
                            L {{ number_format($c->total_egresos, 2) }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            L {{ number_format($c->efectivo_final, 2) }}
                        </td>
                        <td
                            class="px-4 py-3 text-right font-extrabold
                    {{ $c->diferencia > 0 ? 'text-green-700' : ($c->diferencia < 0 ? 'text-red-700' : 'text-blue-700') }}">
                            L {{ number_format($c->diferencia, 2) }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if ($c->pendiente)
                                <span
                                    class="inline-flex items-center px-3 py-1 text-xs font-bold bg-yellow-100 text-yellow-700 rounded-full shadow">
                                    Pendiente
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-3 py-1 text-xs font-bold bg-green-100 text-green-700 rounded-full shadow">
                                    Cerrado
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            <a href="{{ route('cierres.reporte_z', $c->apertura_id) }}"
                                class="inline-flex items-center px-4 py-1 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold shadow transition">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M15 12H9m12 0A9 9 0 11 3 12a9 9 0 0118 0z" />
                                </svg>
                                Ver Z
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-4 py-8 text-center text-gray-400 font-semibold">
                            No hay cierres con los filtros aplicados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    <div class="mt-6 flex justify-center">
        {{ $cierres->links() }}
    </div>
@endsection
