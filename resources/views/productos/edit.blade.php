@extends('layouts.admin')

@section('title', 'Inventario - Editar Producto')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-gray-100 py-8">
    <div class="max-w-3xl mx-auto px-4 py-8">
        <!-- Título principal -->
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-extrabold text-blue-700 mb-2 flex items-center justify-center gap-2">
                🛒 Editar Producto
            </h1>
            <p class="text-base text-gray-500">Actualiza la información del producto en el inventario.</p>
        </div>

        <!-- Sección de acciones -->
        <div class="mb-6 flex items-center gap-3">
            <a href="{{ route('admin.index') }}" class="bg-white border border-gray-300 text-blue-700 px-4 py-2 rounded-lg shadow hover:bg-blue-50 flex items-center gap-2 transition">
                <span>←</span> Regresar
            </a>
        </div>

        <!-- Tarjeta de formulario -->
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-blue-100">
            <h2 class="text-xl font-semibold text-blue-600 mb-6 flex items-center gap-2">
                ✏️ Información del Producto
            </h2>
            <form action="{{ route('productos.update', $producto) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block font-semibold text-gray-700 mb-2">Código:</label>
                    <input type="text" name="codigo" required class="w-full border border-blue-200 p-3 rounded-lg focus:ring-2 focus:ring-blue-300 bg-blue-50"
                        value="{{ old('codigo', $producto->codigo) }}">
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-2">Nombre:</label>
                    <input type="text" name="nombre" required class="w-full border border-blue-200 p-3 rounded-lg focus:ring-2 focus:ring-blue-300 bg-blue-50"
                        value="{{ old('nombre', $producto->nombre) }}">
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-2">Categoría <span class="text-gray-400">(opcional)</span>:</label>
                    <input type="text" name="categoria" class="w-full border border-blue-200 p-3 rounded-lg focus:ring-2 focus:ring-blue-300 bg-blue-50"
                        value="{{ old('categoria', $producto->categoria) }}">
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-2">Precio Compra (L):</label>
                    <input type="number" step="0.01" name="precio_compra" required class="w-full border border-blue-200 p-3 rounded-lg focus:ring-2 focus:ring-blue-300 bg-blue-50"
                        value="{{ old('precio_compra', $producto->precio_compra) }}">
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-2">Precio Venta (L):</label>
                    <input type="number" step="0.01" name="precio_venta" required class="w-full border border-blue-200 p-3 rounded-lg focus:ring-2 focus:ring-blue-300 bg-blue-50"
                        value="{{ old('precio_venta', $producto->precio_venta) }}">
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-2">Agregar cantidad al stock:</label>
                    <input type="number" name="cantidad" required min="1" value="1"
                        class="w-full border border-blue-200 p-3 rounded-lg focus:ring-2 focus:ring-blue-300 bg-blue-50">
                    <p class="text-sm text-gray-500 mt-2">Stock actual: <strong class="text-blue-700">{{ $producto->stock }}</strong></p>
                </div>

                <!-- Botones de acción -->
                <div class="md:col-span-2 flex justify-end gap-4 mt-6">
                    <a href="{{ route('productos.index') }}" class="bg-gray-100 text-gray-700 px-5 py-2 rounded-lg shadow hover:bg-gray-200 flex items-center gap-2 transition">
                        <span>✖️</span> Cancelar
                    </a>
                    <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg shadow hover:bg-blue-700 flex items-center gap-2 transition font-semibold">
                        <span>💾</span> Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
