@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="text-2xl font-bold mb-4">Tipos de Servicio</h1>

        <a href="{{ route('admin.servicios.tipos.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">Nuevo Tipo</a>

        <table class="table-auto w-full border mt-4">
            <thead>
                <tr>
                    <th class="border p-2">Nombre</th>
                    <th class="border p-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tipos as $tipo)
                    <tr>
                        <td class="border p-2">{{ $tipo->nombre }}</td>
                        <td class="border p-2">
                            <form action="{{ route('admin.servicios.tipos.destroy', $tipo) }}" method="POST"
                                onsubmit="return confirm('¿Eliminar este tipo?')">
                                @csrf @method('DELETE')
                                <button class="bg-red-500 text-white px-3 py-1 rounded">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
