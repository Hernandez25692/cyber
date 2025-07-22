@extends('layouts.admin')
@section('title', 'Nuevo Tipo de Impresión')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 bg-gray-50 min-h-screen">
    <!-- Título principal -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center gap-2">
                🖨️ Nuevo Tipo de Impresión
            </h1>
            <p class="text-sm text-gray-500">Agrega un nuevo tipo para clasificar las impresiones en el sistema.</p>
        </div>
        <!-- Botón Regresar -->
        <a href="{{ route('admin.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600 flex items-center gap-2 mt-4 md:mt-0">
            ← Regresar
        </a>
    </div>

    <!-- Contenido principal centrado -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 justify-items-center">
        <div class="bg-white rounded-xl shadow p-6 w-full max-w-md flex flex-col justify-center">
            <h2 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                ✏️ Crear nuevo tipo
            </h2>
            <form action="{{ route('admin.impresiones.tipos.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block font-semibold text-gray-600 mb-1" for="nombre">
                        Nombre del Tipo
                    </label>
                    <input
                        type="text"
                        name="nombre"
                        id="nombre"
                        class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500 transition"
                        required
                        placeholder="Ej: Color"
                    >
                </div>
                <button
                    type="submit"
                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 w-full flex items-center justify-center gap-2 transition"
                >
                    💾 Guardar Tipo
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
