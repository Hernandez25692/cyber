@extends('layouts.admin')

@section('title', 'Registrar nuevo producto')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10 bg-gradient-to-br from-green-50 to-gray-100 min-h-screen flex flex-col items-center">
    <!-- Título principal y subtítulo -->
    <div class="mb-8 w-full max-w-xl text-center">
        <h1 class="text-4xl font-extrabold text-green-700 mb-2 flex items-center justify-center gap-2 drop-shadow">
            🛒 Registrar nuevo producto
        </h1>
        <p class="text-base text-gray-600">Agrega productos al inventario y gestiona tu catálogo fácilmente.</p>
    </div>

    <!-- Sección de acciones -->
    <div class="mb-8 w-full max-w-xl flex items-center gap-4">
        <a href="{{ route('admin.index') }}" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg shadow hover:bg-gray-100 flex items-center gap-2 transition">
            ← Regresar
        </a>
    </div>

    <!-- Tarjeta de formulario centrada -->
    <div class="w-full max-w-xl">
        <div class="bg-white rounded-2xl shadow-xl p-8 border border-green-100">
            <h2 class="text-xl font-bold text-green-700 mb-6 flex items-center gap-2">
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Datos del producto
            </h2>
            <form action="{{ route('productos.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="flex flex-col gap-1">
                    <label class="block font-semibold text-gray-700">Código:</label>
                    <input type="text" name="codigo" required class="w-full border border-green-200 p-3 rounded-lg focus:ring-2 focus:ring-green-300 focus:border-green-400 transition" value="{{ old('codigo') }}" placeholder="Ej: 12345">
                </div>

                <div class="flex flex-col gap-1">
                    <label class="block font-semibold text-gray-700">Nombre:</label>
                    <input type="text" name="nombre" required class="w-full border border-green-200 p-3 rounded-lg focus:ring-2 focus:ring-green-300 focus:border-green-400 transition" value="{{ old('nombre') }}" placeholder="Ej: Audífonos Bluetooth">
                </div>

                <div class="flex flex-col gap-1">
                    <label class="block font-semibold text-gray-700">Categoría <span class="text-gray-400 text-xs">(opcional)</span>:</label>
                    <input type="text" name="categoria" class="w-full border border-green-200 p-3 rounded-lg focus:ring-2 focus:ring-green-300 focus:border-green-400 transition" value="{{ old('categoria') }}" placeholder="Ej: Electrónica">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex flex-col gap-1">
                        <label class="block font-semibold text-gray-700">Precio Compra (L):</label>
                        <input type="number" step="0.01" name="precio_compra" required class="w-full border border-green-200 p-3 rounded-lg focus:ring-2 focus:ring-green-300 focus:border-green-400 transition" value="{{ old('precio_compra') }}" placeholder="Ej: 500.00">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="block font-semibold text-gray-700">Precio Venta (L):</label>
                        <input type="number" step="0.01" name="precio_venta" required class="w-full border border-green-200 p-3 rounded-lg focus:ring-2 focus:ring-green-300 focus:border-green-400 transition" value="{{ old('precio_venta') }}" placeholder="Ej: 650.00">
                    </div>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="block font-semibold text-gray-700">Cantidad a ingresar:</label>
                    <input type="number" name="cantidad" required min="1" value="1" class="w-full border border-green-200 p-3 rounded-lg focus:ring-2 focus:ring-green-300 focus:border-green-400 transition" placeholder="Ej: 10">
                </div>

                <div class="flex justify-end gap-4 pt-6">
                    <a href="{{ route('productos.index') }}" class="bg-white border border-gray-300 text-gray-700 px-5 py-2 rounded-lg shadow hover:bg-gray-100 flex items-center gap-2 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Cancelar
                    </a>
                    <button type="submit" class="bg-gradient-to-r from-green-500 to-green-700 text-white px-6 py-2 rounded-lg shadow hover:from-green-600 hover:to-green-800 flex items-center gap-2 font-semibold transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
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
