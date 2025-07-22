@extends('layouts.admin')
@section('title', 'Nuevo Tipo de Impresión')

@section('content')
    <div class="max-w-md mx-auto py-8">
        <h1 class="text-xl font-bold mb-4">➕ Nuevo Tipo</h1>

        <form action="{{ route('admin.impresiones.tipos.store') }}" method="POST" class="bg-white p-4 shadow rounded">
            @csrf
            <label class="block font-semibold mb-1">Nombre del Tipo</label>
            <input type="text" name="nombre" class="w-full border px-3 py-2 rounded mb-4" required placeholder="Ej: Color">

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 w-full">
                Guardar Tipo
            </button>
        </form>
    </div>
@endsection
