@extends('layouts.admin')

@section('title', 'Inventario - Lista de Productos')

@section('content')
    <div class="mb-6">
        <a href="{{ route('productos.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">➕
            Nuevo Producto</a>
        <a href="{{ route('admin.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            ← Regresar
        </a>
    </div>

    <table class="w-full border bg-white rounded-lg shadow text-sm">
        <thead class="bg-green-100 text-gray-700">
            <tr>
                <th class="p-3 border">Código</th>
                <th class="p-3 border">Nombre</th>
                <th class="p-3 border">Categoría</th>
                <th class="p-3 border">Precio Compra</th>
                <th class="p-3 border">Precio Venta</th>
                <th class="p-3 border">Stock</th>
                <th class="p-3 border">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productos as $producto)
                <tr class="hover:bg-green-50 border-b">
                    <td class="p-3">{{ $producto->codigo }}</td>
                    <td class="p-3">{{ $producto->nombre }}</td>
                    <td class="p-3">{{ $producto->categoria }}</td>
                    <td class="p-3">L. {{ $producto->precio_compra }}</td>
                    <td class="p-3">L. {{ $producto->precio_venta }}</td>
                    <td class="p-3">{{ $producto->stock }}</td>
                    <td class="p-3">
                        <a href="{{ route('productos.edit', $producto) }}" class="text-blue-600 hover:underline">Editar</a>
                        <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 ml-2 hover:underline"
                                onclick="return confirm('¿Eliminar producto?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
