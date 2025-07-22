@extends('layouts.admin')
@section('title', 'Tipos de Impresión')

@section('content')
    <div class="max-w-3xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">🎨 Tipos de Impresión</h1>

        <a href="{{ route('admin.impresiones.tipos.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">➕ Nuevo Tipo</a>

        <div class="mt-6 bg-white p-4 shadow rounded">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left px-3 py-2">ID</th>
                        <th class="text-left px-3 py-2">Nombre</th>
                        <th class="text-left px-3 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tipos as $tipo)
                        <tr class="border-b">
                            <td class="px-3 py-2">{{ $tipo->id }}</td>
                            <td class="px-3 py-2">{{ $tipo->nombre }}</td>
                            <td class="px-3 py-2">
                                <form action="{{ route('admin.impresiones.tipos.destroy', $tipo) }}" method="POST"
                                    onsubmit="return confirm('¿Eliminar este tipo?')">
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
