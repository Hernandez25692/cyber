@extends('layouts.admin')

@section('title', 'Inventario - Lista de Productos')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 bg-gray-100 min-h-screen">
    <!-- Título -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                <svg class="w-8 h-8 text-blue-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="16" rx="2" stroke="currentColor" stroke-width="2" fill="#e5e7eb"/>
                    <path d="M3 8h18" stroke="currentColor" stroke-width="2"/>
                </svg>
                Inventario de Productos
            </h1>
            <p class="text-sm text-gray-500 mt-1">Administra y visualiza todos los productos registrados en el sistema.</p>
        </div>
        <a href="{{ route('admin.index') }}"
            class="bg-gray-200 text-gray-700 px-4 py-2 rounded shadow hover:bg-gray-300 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Regresar
        </a>
    </div>

    <!-- Acciones -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-3">
        <div class="flex gap-3">
            <a href="{{ route('productos.create') }}"
                class="bg-blue-700 text-white px-5 py-2 rounded shadow hover:bg-blue-800 flex items-center gap-2 font-semibold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Nuevo Producto
            </a>
        </div>
    </div>

    <!-- Filtros -->
    <form method="GET" class="bg-white p-4 rounded-lg shadow mb-6 grid grid-cols-1 md:grid-cols-5 gap-4 text-sm border border-gray-200">
        <input type="text" name="busqueda" value="{{ request('busqueda') }}" placeholder="Buscar por código o nombre"
            class="border border-gray-300 rounded px-3 py-2 w-full focus:ring-blue-500 focus:border-blue-500">

        <select name="categoria" class="border border-gray-300 rounded px-3 py-2 w-full focus:ring-blue-500 focus:border-blue-500">
            <option value="">Todas las Categorías</option>
            @foreach ($categorias as $cat)
                <option value="{{ $cat }}" {{ request('categoria') == $cat ? 'selected' : '' }}>
                    {{ $cat }}
                </option>
            @endforeach
        </select>

        <select name="stock" class="border border-gray-300 rounded px-3 py-2 w-full focus:ring-blue-500 focus:border-blue-500">
            <option value="">Todos los Stocks</option>
            <option value="bajo" {{ request('stock') == 'bajo' ? 'selected' : '' }}>Stock Bajo (&lt;= 10)</option>
            <option value="sin" {{ request('stock') == 'sin' ? 'selected' : '' }}>Sin Stock</option>
            <option value="disponible" {{ request('stock') == 'disponible' ? 'selected' : '' }}>Disponible (&gt; 5)</option>
        </select>

        <input type="number" step="0.01" name="min_precio" value="{{ request('min_precio') }}"
            placeholder="Precio min." class="border border-gray-300 rounded px-3 py-2 w-full focus:ring-blue-500 focus:border-blue-500">

        <input type="number" step="0.01" name="max_precio" value="{{ request('max_precio') }}"
            placeholder="Precio máx." class="border border-gray-300 rounded px-3 py-2 w-full focus:ring-blue-500 focus:border-blue-500">

        <div class="md:col-span-5 flex justify-end gap-3">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 font-semibold">🔍 Filtrar</button>
            <a href="{{ route('productos.index') }}"
                class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 font-semibold">♻ Limpiar</a>
        </div>
    </form>

    <!-- Tabla de productos estilo SAP -->
    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
        <h2 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect x="3" y="4" width="18" height="16" rx="2" stroke="currentColor" stroke-width="2" fill="#d1fae5"/>
            </svg>
            Lista de Productos
        </h2>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm border-separate border-spacing-y-2">
                <thead class="bg-gray-50 text-gray-700">
                    <tr>
                        <th class="p-3 text-left font-semibold">Código</th>
                        <th class="p-3 text-left font-semibold">Nombre</th>
                        <th class="p-3 text-left font-semibold">Categoría</th>
                        <th class="p-3 text-left font-semibold">Precio Compra</th>
                        <th class="p-3 text-left font-semibold">Precio Venta</th>
                        <th class="p-3 text-left font-semibold">Stock</th>
                        <th class="p-3 text-left font-semibold">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($productos as $producto)
                        <tr class="bg-white hover:bg-blue-50 border border-gray-200 rounded-lg shadow-sm transition-all">
                            <td class="p-3 font-mono text-blue-800">{{ $producto->codigo }}</td>
                            <td class="p-3 font-semibold text-gray-800">{{ $producto->nombre }}</td>
                            <td class="p-3 text-gray-600">{{ $producto->categoria }}</td>
                            <td class="p-3 text-right text-gray-700">L. {{ number_format($producto->precio_compra, 2) }}</td>
                            <td class="p-3 text-right text-green-700 font-semibold">L. {{ number_format($producto->precio_venta, 2) }}</td>
                            <td class="p-3 text-center">
                                @if($producto->stock == 0)
                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-bold">Sin stock</span>
                                @elseif($producto->stock <= 10)
                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs font-bold">Bajo ({{ $producto->stock }})</span>
                                @else
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-bold">{{ $producto->stock }}</span>
                                @endif
                            </td>
                            <td class="p-3 flex gap-2">
                                <a href="{{ route('productos.edit', $producto) }}"
                                    class="bg-yellow-50 text-yellow-700 px-3 py-1 rounded hover:bg-yellow-100 flex items-center gap-1 border border-yellow-200 shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 13l6-6m2 2l-6 6m-2 2h2v2H7v-2h2z" />
                                    </svg>
                                    Editar
                                </a>
                                <a href="{{ route('productos.entrada', $producto->id) }}"
                                    class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 flex items-center gap-1 border border-green-700 shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                    </svg>
                                    + Inventario
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-6 text-center text-gray-400">No hay productos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="mt-6">
            {{ $productos->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
