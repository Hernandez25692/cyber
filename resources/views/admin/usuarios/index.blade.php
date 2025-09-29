@extends('layouts.admin')

@section('title', 'Gestión de Usuarios')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 bg-gradient-to-br from-gray-50 via-white to-gray-100 min-h-screen">
    <!-- Título principal y subtítulo -->
    <div class="mb-10">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-2 flex items-center gap-3">
            <span class="inline-block bg-green-100 text-green-700 rounded-full p-2 shadow">
                👤
            </span>
            Gestión de Usuarios
        </h1>
        <p class="text-base text-gray-500">Administra los usuarios registrados en el sistema.</p>
    </div>

    <!-- Sección de acciones -->
    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('admin.index') }}"
            class="bg-gray-100 text-gray-700 px-5 py-2 rounded-lg shadow hover:bg-gray-200 transition flex items-center gap-2 font-medium border border-gray-300">
            ← Regresar
        </a>
        <a href="{{ route('admin.usuarios.create') }}"
            class="bg-gradient-to-r from-green-500 to-green-600 text-white px-5 py-2 rounded-lg shadow hover:from-green-600 hover:to-green-700 transition flex items-center gap-2 font-semibold">
            <span class="text-lg">➕</span> Nuevo Usuario
        </a>
    </div>

    <!-- Tarjeta de usuarios -->
    <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-3">
            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-7a4 4 0 11-8 0 4 4 0 018 0zm6 4a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            Lista de Usuarios
        </h2>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[600px] bg-white rounded-xl shadow text-sm">
                <thead class="bg-gradient-to-r from-green-100 to-green-200 text-gray-700">
                    <tr>
                        <th class="p-4 text-left font-semibold">Nombre</th>
                        <th class="p-4 text-left font-semibold">Email</th>
                        <th class="p-4 text-left font-semibold">Rol</th>
                        <th class="p-4 text-left font-semibold">Estado</th>
                        <th class="p-4 text-center font-semibold">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $user)
                        <tr class="border-b last:border-b-0 hover:bg-green-50 transition-colors">
                            <td class="p-4 text-gray-900 font-medium">{{ $user->name }}</td>
                            <td class="p-4 text-gray-700">{{ $user->email }}</td>
                            <td class="p-4 capitalize text-gray-700">
                                <span class="inline-block px-2 py-1 bg-gray-100 rounded text-xs font-semibold">{{ $user->rol }}</span>
                            </td>
                            <td class="p-4">
                                @if ($user->activo)
                                    <span class="px-3 py-1 bg-green-200 text-green-800 rounded-full text-xs font-bold shadow">Activo</span>
                                @else
                                    <span class="px-3 py-1 bg-red-200 text-red-800 rounded-full text-xs font-bold shadow">Inactivo</span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                <a href="{{ route('admin.usuarios.edit', $user->id) }}"
                                   class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 font-semibold hover:underline transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 112.828 2.828L11.828 15.828a2 2 0 01-2.828 0L9 13z" /></svg>
                                    Editar
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
