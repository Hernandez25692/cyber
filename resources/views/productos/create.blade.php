@extends('layouts.admin')

@section('title', 'Registrar nuevo producto')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 bg-gray-50 min-h-screen flex flex-col items-center">
    <!-- Título principal y subtítulo -->
    <div class="mb-8 w-full max-w-xl">
        <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center gap-2">
            🛒 Registrar nuevo producto
        </h1>
        <p class="text-sm text-gray-500">Agrega productos al inventario y gestiona tu catálogo fácilmente.</p>
    </div>

    <!-- Sección de acciones -->
    <div class="mb-8 w-full max-w-xl flex items-center gap-4">
        <a href="{{ route('admin.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600 flex items-center gap-2">
            ← Regresar
        </a>
    </div>

    <!-- Tarjeta de formulario centrada -->
    <div class="w-full max-w-xl">
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Datos del producto
            </h2>
            <form action="{{ route('productos.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block font-medium text-gray-700 mb-1">Código:</label>
                    <input type="text" name="codigo" required class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-green-200" value="{{ old('codigo') }}">
                </div>

                <div>
                    <label class="block font-medium text-gray-700 mb-1">Nombre:</label>
                    <input type="text" name="nombre" required class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-green-200" value="{{ old('nombre') }}">
                </div>

                <div>
                    <label class="block font-medium text-gray-700 mb-1">Categoría <span class="text-gray-400 text-xs">(opcional)</span>:</label>
                    <input type="text" name="categoria" class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-green-200" value="{{ old('categoria') }}">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium text-gray-700 mb-1">Precio Compra (L):</label>
                        <input type="number" step="0.01" name="precio_compra" required class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-green-200" value="{{ old('precio_compra') }}">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700 mb-1">Precio Venta (L):</label>
                        <input type="number" step="0.01" name="precio_venta" required class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-green-200" value="{{ old('precio_venta') }}">
                    </div>
                </div>

                <div>
                    <label class="block font-medium text-gray-700 mb-1">Cantidad a ingresar:</label>
                    <input type="number" name="cantidad" required min="1" value="1" class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-green-200">
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('productos.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Cancelar
                    </a>
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
