@extends('layouts.admin')

@section('title', 'Crear Comisión de Remesa')

@section('content')
    <h2 class="text-2xl font-bold text-green-700 mb-6">➕ Nueva Comisión de Remesa</h2>

    <form action="{{ route('admin.remesas.store') }}" method="POST" class="space-y-4 max-w-xl">
        @csrf

        <div>
            <label class="block font-semibold">Nombre</label>
            <input type="text" name="nombre" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block font-semibold">Monto mínimo</label>
            <input type="number" step="0.01" name="monto_min" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block font-semibold">Monto máximo</label>
            <input type="number" step="0.01" name="monto_max" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block font-semibold">Comisión</label>
            <input type="number" step="0.01" name="comision" class="w-full border rounded p-2" required>
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Guardar Comisión
        </button>
    </form>
@endsection
