@extends('layouts.admin')
@section('title', 'Paquetes de Recarga')

@section('content')
    <div class="max-w-5xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">💳 Paquetes de Recarga</h1>

        <a href="{{ route('admin.recargas.paquetes.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            ➕ Nuevo Paquete
        </a>

        <div class="mt-6 bg-white shadow rounded p-4">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2">Proveedor</th>
                        <th class="px-4 py-2">Descripción</th>
                        <th class="px-4 py-2">Precio</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paquetes as $item)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $item->proveedor->nombre }}</td>
                            <td class="px-4 py-2">{{ $item->descripcion }}</td>
                            <td class="px-4 py-2">L {{ number_format($item->precio, 2) }}</td>
                            <td class="px-4 py-2">
                                <form action="{{ route('admin.recargas.paquetes.destroy', $item) }}" method="POST"
                                    onsubmit="return confirm('¿Eliminar paquete?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:underline">🗑 Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
