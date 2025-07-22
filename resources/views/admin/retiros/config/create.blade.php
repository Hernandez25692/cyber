@extends('layouts.admin')

@section('title', 'Nuevo Rango de Retiro')

@section('content')
    <h2 class="text-xl font-bold text-yellow-600 mb-4">➕ Nuevo Rango de Retiro</h2>

    <form action="{{ route('admin.retiros.config.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block font-semibold">Nombre del Rango</label>
            <input type="text" name="nombre" class="w-full border p-2 rounded" required>
        </div>
        <div>
            <label class="block font-semibold">Monto Mínimo</label>
            <input type="number" name="monto_min" class="w-full border p-2 rounded" step="0.01" required>
        </div>
        <div>
            <label class="block font-semibold">Monto Máximo</label>
            <input type="number" name="monto_max" class="w-full border p-2 rounded" step="0.01" required>
        </div>
        <div>
            <label class="block font-semibold">Comisión</label>
            <input type="number" name="comision" class="w-full border p-2 rounded" step="0.01" required>
        </div>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Guardar Rango</button>
    </form>
@endsection
