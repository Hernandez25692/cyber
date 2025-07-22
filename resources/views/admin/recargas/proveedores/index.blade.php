@extends('layouts.admin')
@section('title', 'Proveedores de Recarga')

@section('content')
    <div class="max-w-3xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">📱 Proveedores de Recarga</h1>

        <a href="{{ route('admin.recargas.proveedores.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            ➕ Nuevo Proveedor
        </a>

        <div class="mt-6 bg-white shadow rounded p-4">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">#</th>
                        <th class="px-4 py-2 text-left">Nombre</th>
                        <th class="px-4 py-2 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($proveedores as $item)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $item->id }}</td>
                            <td class="px-4 py-2">{{ $item->nombre }}</td>
                            <td class="px-4 py-2">
                                <form action="{{ route('admin.recargas.proveedores.destroy', $item) }}" method="POST"
                                    onsubmit="return confirm('¿Eliminar proveedor?')">
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
