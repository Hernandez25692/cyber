@extends('layouts.admin')
@section('title', 'Servicios de Impresión')

@section('content')
    <div class="max-w-3xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">🖨️ Servicios de Impresión</h1>

        <a href="{{ route('admin.impresiones.servicios.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">➕ Nuevo Servicio</a>

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
                    @foreach ($servicios as $servicio)
                        <tr class="border-b">
                            <td class="px-3 py-2">{{ $servicio->id }}</td>
                            <td class="px-3 py-2">{{ $servicio->nombre }}</td>
                            <td class="px-3 py-2">
                                <form action="{{ route('admin.impresiones.servicios.destroy', $servicio) }}" method="POST"
                                    onsubmit="return confirm('¿Eliminar este servicio?')">
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
