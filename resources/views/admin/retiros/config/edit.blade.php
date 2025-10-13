@extends('layouts.admin')

@section('title', 'Editar Rango de Retiro')

@section('content')
    <div class="max-w-3xl mx-auto px-4 py-8">
        <h2 class="text-2xl font-extrabold text-amber-700 mb-6 flex items-center gap-2">
            <span class="text-3xl">✏️</span> Editar Rango de Retiro
        </h2>

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.retiros.config.update', $retiro) }}" method="POST"
            class="space-y-5 bg-white p-6 rounded-2xl shadow">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-semibold text-gray-700 mb-1">Nombre del Rango</label>
                <input type="text" name="nombre" value="{{ old('nombre', $retiro->nombre) }}"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Monto Mínimo</label>
                    <input type="number" name="monto_min" step="0.01" value="{{ old('monto_min', $retiro->monto_min) }}"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"
                        required>
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Monto Máximo</label>
                    <input type="number" name="monto_max" step="0.01" value="{{ old('monto_max', $retiro->monto_max) }}"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"
                        required>
                </div>
            </div>

            <div>
                <label class="block font-semibold text-gray-700 mb-1">Comisión</label>
                <input type="number" name="comision" step="0.01" value="{{ old('comision', $retiro->comision) }}"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" required>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <a href="{{ route('admin.retiros.config.index') }}"
                    class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-800">
                    ← Cancelar
                </a>
                <button type="submit" class="px-5 py-2 rounded-lg text-white bg-amber-600 hover:bg-amber-700 shadow">
                    💾 Guardar Cambios
                </button>
            </div>
        </form>
    </div>
@endsection
