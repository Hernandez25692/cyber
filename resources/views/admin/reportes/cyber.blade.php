@extends('layouts.admin')

@section('title', '📊 Reporte General Cyber')

@section('content')
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="mb-10">
            <div class="flex items-center space-x-4">
                <span class="inline-flex items-center justify-center rounded-full bg-indigo-100 p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </span>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Reporte General Cyber</h1>
                    <p class="text-gray-600 mt-1">Visualiza todos los servicios: ventas, remesas, retiros, etc.</p>
                </div>
            </div>
        </div>

        {{-- FILTROS --}}
        <div class="bg-white shadow rounded-2xl border p-6 mb-8">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
                <div>
                    <label for="desde" class="block text-sm font-medium text-gray-700 mb-1">Desde</label>
                    <input type="date" name="desde" value="{{ $filtros['desde'] }}"
                        class="w-full border rounded-lg px-3 py-2 shadow-sm focus:ring focus:ring-indigo-200" />
                </div>
                <div>
                    <label for="hasta" class="block text-sm font-medium text-gray-700 mb-1">Hasta</label>
                    <input type="date" name="hasta" value="{{ $filtros['hasta'] }}"
                        class="w-full border rounded-lg px-3 py-2 shadow-sm focus:ring focus:ring-indigo-200" />
                </div>
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Cajero</label>
                    <select name="user_id"
                        class="w-full border rounded-lg px-3 py-2 shadow-sm focus:ring focus:ring-indigo-200">
                        <option value="">Todos</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ $filtros['user_id'] == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="modulo" class="block text-sm font-medium text-gray-700 mb-1">Módulo</label>
                    <select name="modulo"
                        class="w-full border rounded-lg px-3 py-2 shadow-sm focus:ring focus:ring-indigo-200">
                        <option value="todos" {{ $filtros['modulo'] == 'todos' ? 'selected' : '' }}>Todos</option>
                        <option value="remesas" {{ $filtros['modulo'] == 'remesas' ? 'selected' : '' }}>Remesas</option>
                        <option value="retiros" {{ $filtros['modulo'] == 'retiros' ? 'selected' : '' }}>Retiros</option>
                        <option value="servicios" {{ $filtros['modulo'] == 'servicios' ? 'selected' : '' }}>Servicios
                        </option>
                        <option value="recargas" {{ $filtros['modulo'] == 'recargas' ? 'selected' : '' }}>Recargas</option>
                        <option value="impresiones" {{ $filtros['modulo'] == 'impresiones' ? 'selected' : '' }}>Impresiones
                        </option>
                        <option value="productos" {{ $filtros['modulo'] == 'productos' ? 'selected' : '' }}>Productos
                        </option>
                    </select>
                </div>
                <div class="md:col-span-4 flex gap-3 mt-4">
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow font-medium">
                        Aplicar Filtros
                    </button>
                    <a href="{{ route('admin.reportes.cyber') }}"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg shadow font-medium">
                        Limpiar
                    </a>
                </div>
            </form>
        </div>

        {{-- AQUI VAN LAS SECCIONES DINÁMICAS --}}
        @php
            $modulo = $filtros['modulo'];
        @endphp

        @if ($modulo === 'todos' || $modulo === 'remesas')
            <div class="mb-10">
            @include('admin.reportes.partials.remesas')
            </div>
        @endif

        @if ($modulo === 'todos' || $modulo === 'retiros')
            <div class="mb-10 border-t pt-8">
            @include('admin.reportes.partials.retiros')
            </div>
        @endif

        @if ($modulo === 'todos' || $modulo === 'servicios')
            <div class="mb-10 border-t pt-8">
            @include('admin.reportes.partials.servicios')
            </div>
        @endif

        @if ($modulo === 'todos' || $modulo === 'recargas')
            <div class="mb-10 border-t pt-8">
            @include('admin.reportes.partials.recargas')
            </div>
        @endif

        @if ($modulo === 'todos' || $modulo === 'impresiones')
            <div class="mb-10 border-t pt-8">
            @include('admin.reportes.partials.impresiones')
            </div>
        @endif

        @if ($modulo === 'todos' || $modulo === 'productos')
            <div class="mb-10 border-t pt-8">
            @include('admin.reportes.partials.productos')
            </div>
        @endif
    </div>
@endsection
