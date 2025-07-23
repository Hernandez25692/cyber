@extends('layouts.admin')

@section('title', 'Agregar Inventario')

@section('content')
    <div class="max-w-xl mx-auto mt-10 bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">📦 Agregar inventario a: {{ $producto->nombre }}</h2>
        <form method="POST" action="{{ route('productos.registrarEntrada', $producto->id) }}">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700">Cantidad a agregar</label>
                <input type="number" name="cantidad" min="1" required class="w-full border-gray-300 rounded mt-1">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Descripción (opcional)</label>
                <textarea name="descripcion" rows="3" class="w-full border-gray-300 rounded mt-1"></textarea>
            </div>
            <div class="flex justify-end space-x-2">
                <a href="{{ route('productos.index') }}"
                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Cancelar</a>
                <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Registrar</button>
            </div>
        </form>
    </div>
@endsection
    