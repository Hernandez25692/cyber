@extends('layouts.admin')

@section('title', 'Gestión de Usuarios')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 bg-gray-50 min-h-screen">
    <!-- Título principal y subtítulo -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center gap-2">
            👤 Gestión de Usuarios
        </h1>
        <p class="text-sm text-gray-500">Administra los usuarios registrados en el sistema.</p>
    </div>

    <!-- Sección de acciones -->
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('admin.index') }}"
            class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600 flex items-center gap-2">
            ← Regresar
        </a>
        <a href="{{ route('admin.usuarios.create') }}"
            class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700 flex items-center gap-2">
            <span>➕</span> Nuevo Usuario
        </a>
    </div>

    <!-- Tarjeta de usuarios -->
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-7a4 4 0 11-8 0 4 4 0 018 0zm6 4a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            Lista de Usuarios
        </h2>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[600px] bg-white rounded shadow text-sm">
                <thead class="bg-green-100 text-gray-700">
                    <tr>
                        <th class="p-3 text-left">Nombre</th>
                        <th class="p-3 text-left">Email</th>
                        <th class="p-3 text-left">Rol</th>
                        <th class="p-3 text-left">Estado</th>
                        <th class="p-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $user)
                        <tr class="border-b hover:bg-green-50 transition-colors">
                            <td class="p-3">{{ $user->name }}</td>
                            <td class="p-3">{{ $user->email }}</td>
                            <td class="p-3 capitalize">{{ $user->rol }}</td>
                            <td class="p-3">
                                @if ($user->activo)
                                    <span class="px-2 py-1 bg-green-200 text-green-800 rounded text-xs">Activo</span>
                                @else
                                    <span class="px-2 py-1 bg-red-200 text-red-800 rounded text-xs">Inactivo</span>
                                @endif
                            </td>
                            <td class="p-3 text-center">
                                <a href="{{ route('admin.usuarios.edit', $user->id) }}"
                                   class="text-blue-600 hover:underline">✏️ Editar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
