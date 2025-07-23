@extends('layouts.admin')

@section('title', 'Reporte General de Actividades')

@section('content')
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="mb-10">
            <div class="flex items-center space-x-4">
                <span class="inline-flex items-center justify-center rounded-full bg-indigo-100 p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </span>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Reporte General de Servicios</h1>
                    <p class="text-gray-600 mt-1">Filtra y visualiza todas las operaciones realizadas por los cajeros</p>
                </div>
            </div>
        </div>

        {{-- RESUMEN GLOBAL --}}
        @php
            $totalGlobal = 0;
            $gananciaGlobal = 0;
            $totales = [
                'remesas' => ['total' => $remesas->sum('monto'), 'comision' => $remesas->sum('comision')],
                'retiros' => ['total' => $retiros->sum('monto'), 'comision' => $retiros->sum('comision')],
                'servicios' => ['total' => $servicios->sum('comision'), 'comision' => $servicios->sum('comision')],
                'recargas' => ['total' => $recargas->sum(fn($r) => $r->paquete->precio ?? 0), 'comision' => 0],
                'impresiones' => ['total' => $impresiones->sum('precio'), 'comision' => $impresiones->sum('precio')],
            ];
            foreach ($totales as $datos) {
                $totalGlobal += $datos['total'];
                $gananciaGlobal += $datos['comision'];
            }
        @endphp

        <div class="bg-white rounded-2xl shadow-lg border border-indigo-100 p-8 mb-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="flex flex-col items-center space-y-2">
                    <span class="inline-flex items-center justify-center rounded-full bg-green-100 p-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-green-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                    <div class="text-center">
                        <p class="text-sm text-gray-500">Total Ingresos</p>
                        <p class="text-2xl font-bold text-gray-800">L {{ number_format($totalGlobal, 2) }}</p>
                    </div>
                </div>
                <div class="flex flex-col items-center space-y-2">
                    <span class="inline-flex items-center justify-center rounded-full bg-blue-100 p-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" />
                        </svg>
                    </span>
                    <div class="text-center">
                        <p class="text-sm text-gray-500">Total Ganancia</p>
                        <p class="text-2xl font-bold text-gray-800">L {{ number_format($gananciaGlobal, 2) }}</p>
                    </div>
                </div>
                <div class="flex flex-col items-center space-y-2">
                    <span class="inline-flex items-center justify-center rounded-full bg-purple-100 p-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-purple-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </span>
                    <div class="text-center">
                        <p class="text-sm text-gray-500">Desde</p>
                        <p class="text-lg font-semibold text-gray-700">
                            {{ \Carbon\Carbon::parse($filtros['desde'])->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>
                <div class="flex flex-col items-center space-y-2">
                    <span class="inline-flex items-center justify-center rounded-full bg-orange-100 p-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-orange-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </span>
                    <div class="text-center">
                        <p class="text-sm text-gray-500">Hasta</p>
                        <p class="text-lg font-semibold text-gray-700">
                            {{ \Carbon\Carbon::parse($filtros['hasta'])->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- FORMULARIO FILTRO --}}
        <div class="bg-white rounded-2xl shadow border border-gray-200 p-8 mb-10">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
                <div>
                    <label for="desde" class="block text-sm font-medium text-gray-700 mb-1">Fecha Inicial</label>
                    <input type="date" name="desde" id="desde" value="{{ $filtros['desde'] }}"
                        class="block w-full pl-4 pr-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        onchange="document.getElementById('hasta').min = this.value;">
                </div>
                <div>
                    <label for="hasta" class="block text-sm font-medium text-gray-700 mb-1">Fecha Final</label>
                    <input type="date" name="hasta" id="hasta" value="{{ $filtros['hasta'] }}"
                        class="block w-full pl-4 pr-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        onchange="document.getElementById('desde').max = this.value;">
                </div>
                <script>
                    // Validación para evitar invertir rangos de fechas
                    document.querySelector('form').addEventListener('submit', function(e) {
                        const desde = document.getElementById('desde').value;
                        const hasta = document.getElementById('hasta').value;
                        if (desde && hasta && desde > hasta) {
                            e.preventDefault();
                            alert('La fecha inicial no puede ser mayor que la fecha final.');
                        }
                    });
                </script>
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Seleccionar Cajero</label>
                    <select name="user_id" id="user_id"
                        class="block w-full pl-4 pr-10 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Todos los cajeros</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ $filtros['user_id'] == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex space-x-3">
                    <button type="submit"
                        class="flex items-center justify-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 w-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Aplicar Filtros
                    </button>
                    <a href="{{ route('admin.reportes.general') }}"
                        class="flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Limpiar
                    </a>
                </div>
            </form>
        </div>

        {{-- SECCIONES INDIVIDUALES --}}
        <div class="space-y-10">
            @foreach ([
            'remesas' => ['title' => 'Remesas', 'icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z', 'color' => 'blue'],
            'retiros' => ['title' => 'Retiros', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'red'],
            'servicios' => ['title' => 'Servicios', 'icon' => 'M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4', 'color' => 'pink'],
            'recargas' => ['title' => 'Recargas', 'icon' => 'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z', 'color' => 'green'],
            'impresiones' => ['title' => 'Impresiones', 'icon' => 'M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z', 'color' => 'yellow'],
        ] as $variable => $config)
                @php
                    $items = $$variable;
                    $title = $config['title'];
                    $icon = $config['icon'];
                    $color = $config['color'];

                    $total = match ($variable) {
                        'recargas' => $items->sum(fn($i) => $i->paquete->precio ?? 0),
                        'impresiones' => $items->sum('precio'),
                        'servicios' => $items->sum('comision'),
                        default => $items->sum('monto'),
                    };

                    $ganancia = match ($variable) {
                        'recargas' => 0,
                        'impresiones' => $items->sum('precio'),
                        'servicios' => $items->sum('comision'),
                        default => $items->sum('comision'),
                    };

                    // Determinar si mostrar columna comisión
                    $mostrarComision = in_array($variable, ['remesas', 'retiros', 'servicios']);
                @endphp

                <div class="bg-white rounded-2xl shadow border-l-8 border-{{ $color }}-500 overflow-hidden">
                    <div
                        class="px-8 py-5 border-b flex justify-between items-center bg-gradient-to-r from-{{ $color }}-50 to-white">
                        <div class="flex items-center space-x-4">
                            <span
                                class="inline-flex items-center justify-center rounded-full bg-{{ $color }}-100 p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-{{ $color }}-600"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="{{ $icon }}" />
                                </svg>
                            </span>
                            <h2 class="text-xl font-semibold text-gray-800">{{ $title }}</h2>
                        </div>
                        <div class="flex space-x-6">
                            <div class="flex flex-col items-center">
                                <span class="inline-flex items-center justify-center rounded-full bg-gray-100 p-2 mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 7h18M3 12h18M3 17h18" />
                                    </svg>
                                </span>
                                <p class="text-xs text-gray-500">Registros</p>
                                <p class="text-base font-semibold text-gray-700">{{ $items->count() }}</p>
                            </div>
                            <div class="flex flex-col items-center">
                                <span
                                    class="inline-flex items-center justify-center rounded-full bg-{{ $color }}-100 p-2 mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-{{ $color }}-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                    </svg>
                                </span>
                                <p class="text-xs text-gray-500">Total</p>
                                <p class="text-base font-semibold text-gray-700">L {{ number_format($total, 2) }}</p>
                            </div>
                            <div class="flex flex-col items-center">
                                <span
                                    class="inline-flex items-center justify-center rounded-full bg-{{ $color }}-100 p-2 mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-{{ $color }}-600"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 14l6-6m-5.5.5h.01m4.99 5h.01" />
                                    </svg>
                                </span>
                                <p class="text-xs text-gray-500">Ganancia</p>
                                <p class="text-base font-semibold text-{{ $color }}-600">L
                                    {{ number_format($ganancia, 2) }}</p>
                            </div>
                        </div>
                    </div>

                    @if ($items->count())
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">
                                            # ID</th>
                                        <th
                                            class="px-6 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">
                                            Cajero</th>
                                        <th
                                            class="px-6 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">
                                            Fecha/Hora</th>
                                        <th
                                            class="px-6 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">
                                            Monto</th>
                                        @if ($mostrarComision)
                                            <th
                                                class="px-6 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">
                                                Comisión</th>
                                        @endif
                                        <th
                                            class="px-6 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">
                                            Detalles</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach ($items as $item)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                                {{ $item->id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div
                                                        class="flex-shrink-0 h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                                        <span
                                                            class="text-indigo-600 text-xs font-medium">{{ substr($item->user->name ?? '—', 0, 1) }}</span>
                                                    </div>
                                                    <div class="ml-3">
                                                        <p class="font-medium text-gray-900">
                                                            {{ $item->user->name ?? '—' }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                                {{ $item->created_at->format('d/m/Y') }}
                                                <span class="text-gray-400">{{ $item->created_at->format('H:i') }}</span>
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap font-medium 
                                            @if ($variable === 'remesas') text-blue-600 @elseif($variable === 'retiros') text-red-600 @else text-gray-900 @endif">
                                                @if ($variable === 'recargas')
                                                    L {{ number_format($item->paquete->precio ?? 0, 2) }}
                                                @elseif($variable === 'impresiones')
                                                    L {{ number_format($item->precio, 2) }}
                                                @elseif($variable === 'servicios')
                                                    L {{ number_format($item->comision, 2) }}
                                                @else
                                                    L {{ number_format($item->monto ?? 0, 2) }}
                                                @endif
                                            </td>
                                            @if ($mostrarComision)
                                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-700">
                                                    L {{ number_format($item->comision ?? 0, 2) }}
                                                </td>
                                            @endif
                                            <td class="px-6 py-4">
                                                @if ($variable === 'remesas')
                                                    <div class="flex items-center space-x-2">
                                                        <span
                                                            class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">Ref:
                                                            {{ $item->referencia }}</span>
                                                        <span
                                                            class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">{{ $item->banco->nombre ?? '' }}</span>
                                                    </div>
                                                @elseif($variable === 'retiros')
                                                    <div class="flex items-center space-x-2">
                                                        <span
                                                            class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded">Ref:
                                                            {{ $item->referencia }}</span>
                                                        <span
                                                            class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">{{ $item->banco->nombre ?? '' }}</span>
                                                    </div>
                                                @elseif($variable === 'servicios')
                                                    <div class="flex items-center space-x-2">
                                                        <span
                                                            class="bg-pink-100 text-pink-800 text-xs px-2 py-1 rounded">{{ $item->tipoServicio->nombre ?? '' }}</span>
                                                        <span
                                                            class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">{{ $item->banco->nombre ?? '' }}</span>
                                                    </div>
                                                @elseif($variable === 'recargas')
                                                    <div class="flex items-center space-x-2">
                                                        <span
                                                            class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">
                                                            {{ $item->paquete->proveedor->nombre ?? '' }}
                                                        </span>
                                                        <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">
                                                            {{ $item->paquete->descripcion ?? '' }}
                                                        </span>
                                                    </div>
                                                @elseif($variable === 'impresiones')
                                                    <div class="flex items-center space-x-2">
                                                        <span
                                                            class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">{{ $item->servicio->nombre ?? '' }}</span>
                                                        <span
                                                            class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">{{ $item->tipo->nombre ?? '' }}</span>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-8 text-center bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">

                            </svg>
                            <img src="{{ asset('storage/logo/logo1.png') }}" alt="Logo Cyber"
                                class="mx-auto mb-5 w-52 h-52 object-contain opacity-80">
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No hay registros</h3>
                            <p class="mt-1 text-sm text-gray-500">No se encontraron {{ strtolower($title) }} en el período
                                seleccionado.</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endsection
