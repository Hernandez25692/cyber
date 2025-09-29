@extends('layouts.admin')

@section('title', 'Agregar Inventario')

@section('content')
    <div class="max-w-xl mx-auto mt-12 bg-white shadow-2xl rounded-xl p-8 border border-gray-100">
        <div class="flex items-center mb-6">
            <div class="bg-green-100 text-green-700 rounded-full p-2 mr-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v4a1 1 0 001 1h3v6a1 1 0 001 1h8a1 1 0 001-1v-6h3a1 1 0 001-1V7a1 1 0 00-1-1H4a1 1 0 00-1 1z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-800">Agregar inventario a: <span class="text-green-700">{{ $producto->nombre }}</span></h2>
        </div>
        <form method="POST" action="{{ route('productos.registrarEntrada', $producto->id) }}">
            @csrf
            <div class="mb-5">
                <label class="block text-gray-600 font-medium mb-1">Cantidad a agregar</label>
                <input type="number" name="cantidad" min="1" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400 transition">
            </div>
            <div class="mb-5">
                <label class="block text-gray-600 font-medium mb-1">Descripción <span class="text-gray-400">(opcional)</span></label>
                <textarea name="descripcion" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400 transition"></textarea>
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <a href="{{ route('productos.index') }}"
                    class="px-5 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-semibold shadow-sm">Cancelar</a>
                <button type="submit"
                    class="px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold shadow-sm flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    Registrar
                </button>
            </div>
        </form>
    </div>
@endsection