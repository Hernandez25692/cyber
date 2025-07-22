@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 bg-gray-50 min-h-screen">
    <!-- Título principal y subtítulo -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center gap-2">
            🛠️ Crear Tipo de Servicio
        </h1>
        <p class="text-sm text-gray-500">Agrega un nuevo tipo de servicio para tu catálogo administrativo.</p>
    </div>

    <!-- Sección de acciones -->
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('admin.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600 flex items-center gap-2">
            ← Regresar
        </a>
    </div>

    <!-- Tarjeta de formulario -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Nuevo Tipo de Servicio
            </h2>
            <form action="{{ route('admin.servicios.tipos.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block font-semibold text-gray-600 mb-1">Nombre</label>
                    <input type="text" name="nombre" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 transition">
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="bg-green-600 text-white px-5 py-2 rounded shadow hover:bg-green-700 transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Guardar
                    </button>
                    <a href="{{ route('admin.servicios.tipos.index') }}" class="bg-gray-200 text-gray-700 px-5 py-2 rounded shadow hover:bg-gray-300 transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
