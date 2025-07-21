@extends('layouts.admin')

@section('title', 'Gestión de Usuarios')

@section('content')
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ url()->previous() }}"
            class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600">← Regresar</a>
        <a href="{{ route('admin.usuarios.create') }}"
            class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700">➕
            Nuevo Usuario</a>
    </div>

    <table class="w-full bg-white rounded shadow overflow-hidden text-sm">
        <thead class="bg-green-100 text-gray-700">
            <tr>
                <th class="p-3">Nombre</th>
                <th class="p-3">Email</th>
                <th class="p-3">Rol</th>
                <th class="p-3 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $user)
                <tr class="border-b hover:bg-green-50">
                    <td class="p-3">{{ $user->name }}</td>
                    <td class="p-3">{{ $user->email }}</td>
                    <td class="p-3 capitalize">{{ $user->rol }}</td>
                    <td class="p-3 text-center">
                        <form method="POST" action="{{ route('admin.usuarios.destroy', $user->id) }}"
                            onsubmit="return confirm('¿Eliminar este usuario?')">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
