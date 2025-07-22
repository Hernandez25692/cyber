@extends('layouts.admin')

@section('title', 'Inventario - Editar Producto')

@section('content')
<div class="min-h-screen bg-gray-50 py-6">
    <div class="max-w-7xl mx-auto px-4 py-6">
        <!-- Título principal -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-1 flex items-center gap-2">
                🛒 Editar Producto
            </h1>
            <p class="text-sm text-gray-500">Actualiza la información del producto en el inventario.</p>
        </div>

        <!-- Sección de acciones -->
        <div class="mb-6 flex items-center gap-3">
            <a href="{{ route('admin.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600 flex items-center gap-2">
                <span>←</span> Regresar
            </a>
        </div>

        <!-- Tarjeta de formulario -->
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                ✏️ Información del Producto
            </h2>
            <form action="{{ route('productos.update', $producto) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block font-medium text-gray-700 mb-1">Código:</label>
                    <input type="text" name="codigo" required class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-200"
                        value="{{ old('codigo', $producto->codigo) }}">
                </div>

                <div>
                    <label class="block font-medium text-gray-700 mb-1">Nombre:</label>
                    <input type="text" name="nombre" required class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-200"
                        value="{{ old('nombre', $producto->nombre) }}">
                </div>

                <div>
                    <label class="block font-medium text-gray-700 mb-1">Categoría <span class="text-gray-400">(opcional)</span>:</label>
                    <input type="text" name="categoria" class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-200"
                        value="{{ old('categoria', $producto->categoria) }}">
                </div>

                <div>
                    <label class="block font-medium text-gray-700 mb-1">Precio Compra (L):</label>
                    <input type="number" step="0.01" name="precio_compra" required class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-200"
                        value="{{ old('precio_compra', $producto->precio_compra) }}">
                </div>

                <div>
                    <label class="block font-medium text-gray-700 mb-1">Precio Venta (L):</label>
                    <input type="number" step="0.01" name="precio_venta" required class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-200"
                        value="{{ old('precio_venta', $producto->precio_venta) }}">
                </div>

                <div>
                    <label class="block font-medium text-gray-700 mb-1">Agregar cantidad al stock:</label>
                    <input type="number" name="cantidad" required min="1" value="1"
                        class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-200">
                    <p class="text-sm text-gray-500 mt-1">Stock actual: <strong>{{ $producto->stock }}</strong></p>
                </div>

                <!-- Botones de acción -->
                <div class="md:col-span-2 flex justify-end gap-3 mt-4">
                    <a href="{{ route('productos.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded shadow hover:bg-gray-500 flex items-center gap-2">
                        <span>✖️</span> Cancelar
                    </a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 flex items-center gap-2">
                        <span>💾</span> Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
