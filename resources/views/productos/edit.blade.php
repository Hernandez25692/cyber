<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Editar producto</h2>
    </x-slot>

    <div class="p-4 max-w-xl mx-auto">
        <form action="{{ route('productos.update', $producto) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-medium">Código:</label>
                <input type="text" name="codigo" required class="w-full border p-2 rounded"
                    value="{{ old('codigo', $producto->codigo) }}">
            </div>

            <div>
                <label class="block font-medium">Nombre:</label>
                <input type="text" name="nombre" required class="w-full border p-2 rounded"
                    value="{{ old('nombre', $producto->nombre) }}">
            </div>

            <div>
                <label class="block font-medium">Categoría (opcional):</label>
                <input type="text" name="categoria" class="w-full border p-2 rounded"
                    value="{{ old('categoria', $producto->categoria) }}">
            </div>

            <div>
                <label class="block font-medium">Precio Compra (L):</label>
                <input type="number" step="0.01" name="precio_compra" required class="w-full border p-2 rounded"
                    value="{{ old('precio_compra', $producto->precio_compra) }}">
            </div>

            <div>
                <label class="block font-medium">Precio Venta (L):</label>
                <input type="number" step="0.01" name="precio_venta" required class="w-full border p-2 rounded"
                    value="{{ old('precio_venta', $producto->precio_venta) }}">
            </div>

            <div>
                <label class="block font-medium">Agregar cantidad al stock:</label>
                <input type="number" name="cantidad" required min="1" value="1"
                    class="w-full border p-2 rounded">
                <p class="text-sm text-gray-500 mt-1">Stock actual: <strong>{{ $producto->stock }}</strong></p>
            </div>

            <div class="text-right">
                <a href="{{ route('productos.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Cancelar</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Actualizar</button>
            </div>
        </form>
    </div>
</x-app-layout>
