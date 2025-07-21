<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Inventario - Lista de Productos</h2>
    </x-slot>

    <div class="p-4">
        <a href="{{ route('productos.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Nuevo Producto</a>

        <table class="w-full mt-4 border">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-2 border">Código</th>
                    <th class="p-2 border">Nombre</th>
                    <th class="p-2 border">Categoría</th>
                    <th class="p-2 border">Precio Compra</th>
                    <th class="p-2 border">Precio Venta</th>
                    <th class="p-2 border">Stock</th>
                    <th class="p-2 border">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $producto)
                    <tr>
                        <td class="border p-2">{{ $producto->codigo }}</td>
                        <td class="border p-2">{{ $producto->nombre }}</td>
                        <td class="border p-2">{{ $producto->categoria }}</td>
                        <td class="border p-2">L. {{ $producto->precio_compra }}</td>
                        <td class="border p-2">L. {{ $producto->precio_venta }}</td>
                        <td class="border p-2">{{ $producto->stock }}</td>
                        <td class="border p-2">
                            <a href="{{ route('productos.edit', $producto) }}" class="text-blue-600">Editar</a>
                            <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 ml-2"
                                    onclick="return confirm('¿Eliminar producto?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
