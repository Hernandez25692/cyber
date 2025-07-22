@extends('layouts.admin')
@section('title', 'Nuevo Proveedor')

@section('content')
    <div class="max-w-md mx-auto py-8">
        <h1 class="text-xl font-bold mb-4">➕ Registrar Proveedor</h1>

        <form action="{{ route('admin.recargas.proveedores.store') }}" method="POST" class="bg-white shadow p-4 rounded">
            @csrf
            <label class="block mb-2 font-semibold">Nombre del Proveedor</label>
            <input type="text" name="nombre" required class="w-full border px-3 py-2 rounded mb-4"
                placeholder="Ej: Claro, Tigo">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Guardar</button>
        </form>
    </div>
@endsection
