@extends('layouts.admin')
@section('title', 'Editar Paquete')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6 bg-gray-50 min-h-screen">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center gap-2">
                ✏️ Editar Paquete
            </h1>
            <p class="text-sm text-gray-500">Actualiza los valores de compra y venta del paquete.</p>
        </div>

        <div class="mb-6 flex items-center gap-4">
            <a href="{{ route('admin.recargas.paquetes.index') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600 flex items-center gap-2">
                ← Regresar
            </a>
        </div>

        <div class="flex justify-center">
            <div class="w-full max-w-lg bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    📝 Datos del Paquete
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

                <form action="{{ route('admin.recargas.paquetes.update', $paquete->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block mb-1 font-semibold text-gray-600">Proveedor</label>
                        <select name="proveedor_id"
                            class="w-full border border-gray-300 px-3 py-2 rounded focus:ring-2 focus:ring-blue-200"
                            required>
                            @foreach ($proveedores as $prov)
                                <option value="{{ $prov->id }}" @selected(old('proveedor_id', $paquete->proveedor_id) == $prov->id)>
                                    {{ $prov->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block mb-1 font-semibold text-gray-600">Descripción</label>
                        <input type="text" name="descripcion" value="{{ old('descripcion', $paquete->descripcion) }}"
                            required
                            class="w-full border border-gray-300 px-3 py-2 rounded focus:ring-2 focus:ring-blue-200">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block mb-1 font-semibold text-gray-600">Precio de compra (L)</label>
                            <input type="number" name="precio_compra" step="0.01" min="0"
                                value="{{ old('precio_compra', $paquete->precio_compra) }}" required
                                class="w-full border border-gray-300 px-3 py-2 rounded focus:ring-2 focus:ring-blue-200">
                            <p class="text-xs text-gray-500 mt-1">Lo que te cuesta a ti.</p>
                        </div>
                        <div>
                            <label class="block mb-1 font-semibold text-gray-600">Precio de venta (L)</label>
                            <input type="number" name="precio_venta" step="0.01" min="0"
                                value="{{ old('precio_venta', $paquete->precio_venta) }}" required
                                class="w-full border border-gray-300 px-3 py-2 rounded focus:ring-2 focus:ring-blue-200">
                            <p class="text-xs text-gray-500 mt-1">Lo que cobras al cliente.</p>
                        </div>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="submit"
                            class="bg-yellow-500 text-white px-4 py-2 rounded shadow hover:bg-yellow-600 flex items-center gap-2">
                            💾 Guardar cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
