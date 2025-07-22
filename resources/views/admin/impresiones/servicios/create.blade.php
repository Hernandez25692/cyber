@extends('layouts.admin')
@section('title', 'Nuevo Servicio de Impresión')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 bg-gray-50 min-h-screen">
    <!-- Título principal -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center gap-2">
            🖨️ Nuevo Servicio de Impresión
        </h1>
        <p class="text-sm text-gray-500">Agrega un nuevo servicio de impresión para tu negocio.</p>
    </div>

    <!-- Sección de acciones -->
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('admin.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600 flex items-center gap-1">
            ← Regresar
        </a>
    </div>

    <!-- Tarjeta de formulario centrada -->
    <div class="flex justify-center">
        <div class="bg-white rounded-xl shadow p-6 flex flex-col justify-between w-full max-w-md">
            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    ✏️ Datos del Servicio
                </h2>
                <form action="{{ route('admin.impresiones.servicios.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block font-semibold text-gray-600 mb-1" for="nombre">
                            Nombre del Servicio
                        </label>
                        <input
                            type="text"
                            name="nombre"
                            id="nombre"
                            class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500"
                            required
                            placeholder="Ej: Curriculum"
                        >
                    </div>
                    <button
                        type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 shadow flex items-center justify-center gap-2 w-full transition"
                    >
                        💾 Guardar Servicio
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
