@extends('layouts.admin')

@section('title', 'Nuevo Rango de Comisión - Depósitos')

@section('content')
    <h1 class="text-2xl font-bold text-blue-600 mb-6">Nuevo Rango de Comisión - Depósitos</h1>

    <form action="{{ route('admin.depositos.config.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block font-semibold">Nombre</label>
            <input type="text" name="nombre" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block font-semibold">Monto Mínimo</label>
            <input type="number" name="monto_min" step="0.01" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block font-semibold">Monto Máximo</label>
            <input type="number" name="monto_max" step="0.01" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block font-semibold">Comisión</label>
            <input type="number" name="comision" step="0.01" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.depositos.config.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Cancelar</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Guardar</button>
        </div>
    </form>
@endsection
