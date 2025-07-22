@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 bg-gray-50 min-h-screen">
    <!-- Título principal y subtítulo -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center gap-2">
            ⚙️ Nueva Configuración de Servicio
        </h1>
        <p class="text-sm text-gray-500">Agrega una nueva configuración para los servicios disponibles en la plataforma.</p>
    </div>

    <!-- Sección de acciones -->
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('admin.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600 flex items-center gap-2">
            ← Regresar
        </a>
    </div>

    <!-- Tarjeta de formulario centrado -->
    <div class="flex justify-center">
        <div class="bg-white rounded-xl shadow p-6 w-full max-w-lg">
            <h2 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                📝 Datos de la Configuración
            </h2>
            <form action="{{ route('admin.servicios.config.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block font-semibold text-gray-600 mb-1">Tipo de Servicio</label>
                    <select name="tipo_servicio_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-green-100" required>
                        @foreach ($tipos as $tipo)
                            <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-semibold text-gray-600 mb-1">Banco</label>
                    <select name="banco_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-green-100" required>
                        @foreach ($bancos as $banco)
                            <option value="{{ $banco->id }}">{{ $banco->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-semibold text-gray-600 mb-1">Comisión</label>
                    <input type="number" name="comision" step="0.01" required class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-green-100">
                </div>

                <div class="flex gap-3 mt-4">
                    <button type="submit" class="bg-green-600 text-white px-5 py-2 rounded shadow hover:bg-green-700 flex items-center gap-2">
                        💾 Guardar
                    </button>
                    <a href="{{ route('admin.servicios.config.index') }}" class="bg-gray-200 text-gray-700 px-5 py-2 rounded shadow hover:bg-gray-300 flex items-center gap-2">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
