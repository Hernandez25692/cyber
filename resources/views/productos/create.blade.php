@extends('layouts.admin')

@section('title', 'Registrar nuevo producto')

@section('content')
    <div class="max-w-xl mx-auto bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-6">Registrar nuevo producto</h2>
        <form action="{{ route('productos.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block font-medium">Código:</label>
                <input type="text" name="codigo" required class="w-full border p-2 rounded"
                    value="{{ old('codigo') }}">
            </div>

            <div>
                <label class="block font-medium">Nombre:</label>
                <input type="text" name="nombre" required class="w-full border p-2 rounded"
                    value="{{ old('nombre') }}">
            </div>

            <div>
                <label class="block font-medium">Categoría (opcional):</label>
                <input type="text" name="categoria" class="w-full border p-2 rounded" value="{{ old('categoria') }}">
            </div>

            <div>
                <label class="block font-medium">Precio Compra (L):</label>
                <input type="number" step="0.01" name="precio_compra" required class="w-full border p-2 rounded"
                    value="{{ old('precio_compra') }}">
            </div>

            <div>
                <label class="block font-medium">Precio Venta (L):</label>
                <input type="number" step="0.01" name="precio_venta" required class="w-full border p-2 rounded"
                    value="{{ old('precio_venta') }}">
            </div>

            <div>
                <label class="block font-medium">Cantidad a ingresar:</label>
                <input type="number" name="cantidad" required min="1" value="1"
                    class="w-full border p-2 rounded">
            </div>

            <div class="text-right">
                <a href="{{ route('productos.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Cancelar</a>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Guardar</button>
            </div>
        </form>
    </div>
@endsection
