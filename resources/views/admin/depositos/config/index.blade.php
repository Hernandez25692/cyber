@extends('layouts.admin')

@section('title', 'Configuración de Comisión - Depósitos')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-blue-600">Configuración de Comisión - Depósitos</h1>
                <p class="mt-1 text-sm text-gray-500">Administra rangos y comisiones aplicables a los depósitos.</p>
            </div>

            <div class="flex items-center gap-3">
                

                <a href="{{ route('admin.depositos.config.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm shadow">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Nuevo Rango
                </a>
            </div>
        </div>

        <div class="bg-white border rounded-lg shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        Total rangos: <span class="font-medium text-gray-800">{{ $rangos->count() }}</span>
                    </div>
                    <div class="text-xs text-gray-500">Los valores monetarios se muestran en Lempiras</div>
                </div>
            </div>

            <div class="p-6">
                @if ($rangos->isEmpty())
                    <div class="flex flex-col items-center justify-center gap-4 py-12">
                        <svg class="w-20 h-20 text-blue-100" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-3.866 0-7 3.134-7 7v1h14v-1c0-3.866-3.134-7-7-7z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4a4 4 0 110 8 4 4 0 010-8z" />
                        </svg>
                        <p class="text-gray-600">No hay rangos configurados aún.</p>
                        <a href="{{ route('admin.depositos.config.create') }}" class="mt-2 inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-amber-600 hover:bg-amber-700 text-white text-sm shadow">
                            ➕ Crear primer rango
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-blue-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Nombre</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Monto Mínimo</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Monto Máximo</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Comisión</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach ($rangos as $rango)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <div class="text-sm font-semibold text-gray-800">{{ $rango->nombre }}</div>
                                            @if(!empty($rango->descripcion ?? null))
                                                <div class="text-xs text-gray-500 mt-0.5">{{ $rango->descripcion }}</div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">L. {{ number_format($rango->monto_min, 2) }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">L. {{ number_format($rango->monto_max, 2) }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-sm font-semibold text-blue-700 bg-blue-50">
                                                L. {{ number_format($rango->comision, 2) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('admin.depositos.config.edit', $rango) }}"
                                                    class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md bg-amber-600 hover:bg-amber-700 text-white text-sm shadow-sm">
                                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M4 20l6.586-1.414L19.88 9.293a1 1 0 000-1.414L16.464 4.464a1 1 0 00-1.414 0L4 15.515V20z" />
                                                    </svg>
                                                    Editar
                                                </a>

                                                <!-- Botón visual de eliminar (sin acción) para mantener consistencia visual -->
                                                <button type="button" disabled
                                                    class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md bg-red-50 text-red-600 text-sm border border-red-100 cursor-not-allowed">
                                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-7 4h10" />
                                                    </svg>
                                                    Eliminar
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
