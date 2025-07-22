@extends('layouts.admin')

@section('title', 'Inventario - Lista de Productos')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 bg-gray-50 min-h-screen">
    <!-- Título principal -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center gap-2">
            📦 Inventario de Productos
        </h1>
        <p class="text-sm text-gray-500">Administra y visualiza todos los productos registrados en el sistema.</p>
    </div>

    <!-- Sección de acciones -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-3">
        <div class="flex gap-3">
            <a href="{{ route('productos.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Nuevo Producto
            </a>
        </div>
        <a href="{{ route('admin.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Regresar
        </a>
    </div>

    <!-- Tarjeta de productos -->
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
            🗂️ Lista de Productos
        </h2>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-green-100 text-gray-700">
                    <tr>
                        <th class="p-3 text-left">Código</th>
                        <th class="p-3 text-left">Nombre</th>
                        <th class="p-3 text-left">Categoría</th>
                        <th class="p-3 text-left">Precio Compra</th>
                        <th class="p-3 text-left">Precio Venta</th>
                        <th class="p-3 text-left">Stock</th>
                        <th class="p-3 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($productos as $producto)
                        <tr class="hover:bg-green-50 border-b last:border-0">
                            <td class="p-3">{{ $producto->codigo }}</td>
                            <td class="p-3">{{ $producto->nombre }}</td>
                            <td class="p-3">{{ $producto->categoria }}</td>
                            <td class="p-3">L. {{ $producto->precio_compra }}</td>
                            <td class="p-3">L. {{ $producto->precio_venta }}</td>
                            <td class="p-3">{{ $producto->stock }}</td>
                            <td class="p-3 flex gap-2">
                                <a href="{{ route('productos.edit', $producto) }}" class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded hover:bg-yellow-200 flex items-center gap-1">
                                    ✏️ Editar
                                </a>
                                <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="bg-red-100 text-red-700 px-3 py-1 rounded hover:bg-red-200 flex items-center gap-1"
                                        onclick="return confirm('¿Eliminar producto?')">
                                        🗑️ Eliminar
                                    </button>
                                </form>
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
    </div>
</div>
@endsection
