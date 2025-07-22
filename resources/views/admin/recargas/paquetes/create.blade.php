@extends('layouts.admin')
@section('title', 'Nuevo Paquete')

@section('content')
    <div class="max-w-md mx-auto py-8">
        <h1 class="text-xl font-bold mb-4">➕ Registrar Paquete</h1>

        <form action="{{ route('admin.recargas.paquetes.store') }}" method="POST" class="bg-white shadow p-4 rounded">
            @csrf

            <label class="block mb-2 font-semibold">Proveedor</label>
            <select name="proveedor_id" class="w-full border px-3 py-2 rounded mb-4" required>
                <option value="">-- Selecciona --</option>
                @foreach ($proveedores as $proveedor)
                    <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                @endforeach
            </select>

            <label class="block mb-2 font-semibold">Descripción</label>
            <input type="text" name="descripcion" required class="w-full border px-3 py-2 rounded mb-4"
                placeholder="Ej: Paquete L50 - 500MB">

            <label class="block mb-2 font-semibold">Precio</label>
            <input type="number" name="precio" step="0.01" required class="w-full border px-3 py-2 rounded mb-4">

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Guardar</button>
        </form>
    </div>
@endsection
