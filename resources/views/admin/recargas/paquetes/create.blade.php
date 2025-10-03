@extends('layouts.admin')
@section('title', 'Nuevo Paquete')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 bg-gray-50 min-h-screen">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center gap-2">
            📦 Nuevo Paquete
        </h1>
        <p class="text-sm text-gray-500">Registra un nuevo paquete de recarga para tus proveedores.</p>
    </div>

    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('admin.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600 flex items-center gap-2">
            ← Regresar
        </a>
    </div>

    <div class="flex justify-center">
        <div class="w-full max-w-lg bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                📝 Registrar Paquete
            </h2>

            @if ($errors->any())
                <div class="mb-4 rounded border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.recargas.paquetes.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block mb-1 font-semibold text-gray-600">Proveedor</label>
                    <select name="proveedor_id" class="w-full border border-gray-300 px-3 py-2 rounded focus:ring-2 focus:ring-blue-200" required>
                        <option value="">-- Selecciona --</option>
                        @foreach ($proveedores as $proveedor)
                            <option value="{{ $proveedor->id }}" @selected(old('proveedor_id')==$proveedor->id)>{{ $proveedor->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-1 font-semibold text-gray-600">Descripción</label>
                    <input type="text" name="descripcion" value="{{ old('descripcion') }}" required
                           class="w-full border border-gray-300 px-3 py-2 rounded focus:ring-2 focus:ring-blue-200"
                           placeholder="Ej: Paquete L50 - 500MB">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block mb-1 font-semibold text-gray-600">Precio de compra (L)</label>
                        <input type="number" name="precio_compra" step="0.01" min="0" value="{{ old('precio_compra') }}"
                               required class="w-full border border-gray-300 px-3 py-2 rounded focus:ring-2 focus:ring-blue-200"
                               placeholder="Ej: 47.00">
                        <p class="text-xs text-gray-500 mt-1">Lo que te cuesta a ti.</p>
                    </div>
                    <div>
                        <label class="block mb-1 font-semibold text-gray-600">Precio de venta (L)</label>
                        <input type="number" name="precio_venta" step="0.01" min="0" value="{{ old('precio_venta') }}"
                               required class="w-full border border-gray-300 px-3 py-2 rounded focus:ring-2 focus:ring-blue-200"
                               placeholder="Ej: 50.00">
                        <p class="text-xs text-gray-500 mt-1">Lo que cobras al cliente (POS mostrará este valor).</p>
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700 flex items-center gap-2">
                        💾 Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
