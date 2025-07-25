@extends('layouts.admin')

@section('title', 'Reporte de Utilidad de Productos')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Encabezado -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Reporte de Utilidad de Productos</h1>
                <p class="mt-1 text-sm text-gray-600">Análisis detallado de rentabilidad por producto</p>
            </div>
            
        </div>

        <!-- Filtros -->
        <form method="GET" class="bg-white shadow rounded-lg p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <label for="desde" class="block text-sm font-medium text-gray-700 mb-1">Fecha Inicial</label>
                    <input type="date" name="desde" id="desde" value="{{ $filtros['desde'] }}"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="hasta" class="block text-sm font-medium text-gray-700 mb-1">Fecha Final</label>
                    <input type="date" name="hasta" id="hasta" value="{{ $filtros['hasta'] }}"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Cajero</label>
                    <select name="user_id" id="user_id" class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                        <option value="">Todos los cajeros</option>
                        @foreach ($usuarios as $user)
                            <option value="{{ $user->id }}" {{ $filtros['user_id'] == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end space-x-2 col-span-2">
                    <button type="submit" class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 w-full">
                        <i data-feather="filter" class="w-4 h-4 mr-2"></i>
                        Filtrar
                    </button>
                    <a href="{{ route('admin.reportes.utilidad.productos') }}" class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 w-full">
                        <i data-feather="refresh-cw" class="w-4 h-4 mr-2"></i>
                        Limpiar
                    </a>
                </div>
            </div>
        </form>

        <!-- Resumen Estadístico -->
        @php
            $total_ventas = 0;
            $total_utilidad = 0;
            $total_productos = 0;
            
            foreach ($detalles as $d) {
                $subtotal = $d->cantidad * $d->precio_unitario;
                $costo = $d->cantidad * $d->producto->precio_compra;
                $utilidad = $subtotal - $costo;
                $total_ventas += $subtotal;
                $total_utilidad += $utilidad;
                $total_productos += $d->cantidad;
            }
            
            $margen_ganancia = $total_ventas > 0 ? ($total_utilidad / $total_ventas) * 100 : 0;
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white p-4 rounded-lg shadow border-l-4 border-blue-500">
                <div class="flex items-center">
                    <div class="p-2 rounded-full bg-blue-100 text-blue-600 mr-4">
                        <i data-feather="dollar-sign" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Ventas Totales</p>
                        <p class="text-xl font-semibold text-gray-900">L {{ number_format($total_ventas, 2) }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="p-2 rounded-full bg-green-100 text-green-600 mr-4">
                        <i data-feather="trending-up" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Ganancia Total</p>
                        <p class="text-xl font-semibold text-green-600">L {{ number_format($total_utilidad, 2) }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow border-l-4 border-purple-500">
                <div class="flex items-center">
                    <div class="p-2 rounded-full bg-purple-100 text-purple-600 mr-4">
                        <i data-feather="box" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Productos Vendidos</p>
                        <p class="text-xl font-semibold text-gray-900">{{ number_format($total_productos) }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow border-l-4 border-yellow-500">
                <div class="flex items-center">
                    <div class="p-2 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                        <i data-feather="percent" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Margen de Ganancia</p>
                        <p class="text-xl font-semibold text-yellow-600">{{ number_format($margen_ganancia, 2) }}%</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Detalles -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha/Hora</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cajero</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Cant.</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Precio Venta</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Precio Compra</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ganancia</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($detalles as $d)
                            @php
                                $venta = $d->precio_unitario;
                                $compra = $d->producto->precio_compra;
                                $subtotal = $d->cantidad * $venta;
                                $utilidad = $subtotal - $d->cantidad * $compra;
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $d->venta->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $d->producto->nombre }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $d->venta->user->name ?? '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">{{ $d->cantidad }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">L {{ number_format($venta, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">L {{ number_format($compra, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">L {{ number_format($subtotal, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right {{ $utilidad >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    L {{ number_format($utilidad, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    @if($detalles->isEmpty())
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                                No se encontraron registros con los filtros seleccionados
                            </td>
                        </tr>
                    @endif
                </table>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $detalles->links() }}
            </div>
        </div>

        <!-- Gráfico de Resumen (opcional) -->
        <div class="mt-6 bg-white shadow rounded-lg p-6 hidden print:hidden">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Resumen Gráfico</h2>
            <div class="h-64 flex items-center justify-center bg-gray-50 rounded-lg">
                <p class="text-gray-500">Gráfico de utilidades por producto (implementación futura)</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
            
            // Inicializar datepickers (ejemplo con flatpickr)
            flatpickr("#desde", {
                dateFormat: "Y-m-d",
                maxDate: "today"
            });
            
            flatpickr("#hasta", {
                dateFormat: "Y-m-d",
                minDate: document.getElementById('desde').value,
                maxDate: "today"
            });
            
            document.getElementById('desde').addEventListener('change', function() {
                flatpickr("#hasta", {
                    dateFormat: "Y-m-d",
                    minDate: this.value,
                    maxDate: "today"
                });
            });
        });
    </script>
@endsection