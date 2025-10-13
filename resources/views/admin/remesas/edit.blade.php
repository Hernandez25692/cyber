@extends('layouts.admin')

@section('title', 'Editar Comisión de Remesa')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6 bg-gray-50 min-h-screen">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center gap-2">
                ✏️ Editar Comisión de Remesa
            </h1>
            <p class="text-sm text-gray-500">Actualiza la comisión para el rango seleccionado.</p>
        </div>

        <div class="mb-6 flex items-center gap-4">
            <a href="{{ route('admin.remesas.index') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600 flex items-center gap-2">
                ← Regresar
            </a>
        </div>

        <div class="grid grid-cols-1">
            <div class="bg-white rounded-xl shadow p-6 mx-auto w-full max-w-xl">
                @if ($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <h2 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    📝 Datos de la Comisión
                </h2>

                <form action="{{ route('admin.remesas.update', $remesa) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block font-semibold text-gray-600 mb-1">Nombre</label>
                        <input type="text" name="nombre" value="{{ old('nombre', $remesa->nombre) }}"
                            class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-green-400 focus:outline-none"
                            required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-semibold text-gray-600 mb-1">Monto mínimo</label>
                            <input type="number" step="0.01" name="monto_min"
                                value="{{ old('monto_min', $remesa->monto_min) }}"
                                class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-green-400 focus:outline-none"
                                required>
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-600 mb-1">Monto máximo</label>
                            <input type="number" step="0.01" name="monto_max"
                                value="{{ old('monto_max', $remesa->monto_max) }}"
                                class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-green-400 focus:outline-none"
                                required>
                        </div>
                    </div>

                    <div>
                        <label class="block font-semibold text-gray-600 mb-1">Comisión (%)</label>
                        <input type="number" step="0.01" name="comision"
                            value="{{ old('comision', $remesa->comision) }}"
                            class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-green-400 focus:outline-none"
                            required>
                    </div>

                    <div class="flex gap-3 mt-6">
                        <button type="submit"
                            class="bg-green-600 text-white px-5 py-2 rounded-lg shadow hover:bg-green-700 transition flex items-center gap-2">
                            💾 Guardar Cambios
                        </button>
                        <a href="{{ route('admin.remesas.index') }}"
                            class="bg-gray-200 text-gray-700 px-5 py-2 rounded-lg shadow hover:bg-gray-300 transition">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
