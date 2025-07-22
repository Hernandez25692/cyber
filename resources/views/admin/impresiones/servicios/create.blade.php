@extends('layouts.admin')
@section('title', 'Nuevo Servicio de Impresión')

@section('content')
    <div class="max-w-md mx-auto py-8">
        <h1 class="text-xl font-bold mb-4">➕ Nuevo Servicio</h1>

        <form action="{{ route('admin.impresiones.servicios.store') }}" method="POST" class="bg-white p-4 shadow rounded">
            @csrf
            <label class="block font-semibold mb-1">Nombre del Servicio</label>
            <input type="text" name="nombre" class="w-full border px-3 py-2 rounded mb-4" required
                placeholder="Ej: Curriculum">

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 w-full">
                Guardar Servicio
            </button>
        </form>
    </div>
@endsection
