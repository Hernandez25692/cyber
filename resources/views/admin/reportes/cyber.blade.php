@extends('layouts.admin')

@section('title', '📊 Reporte General Cyber')

@section('content')
    <div class="container mx-auto px-4 max-w-7xl py-6">
        {{-- HEADER --}}
        <div class="mb-10">
            <div class="flex items-center space-x-5">
                <div class="flex-shrink-0">
                    <div class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 p-4 shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Reporte General Cyber</h1>
                    <p class="text-gray-600 text-lg">Visualiza todos los servicios: ventas, remesas, retiros, etc.</p>
                </div>
            </div>
        </div>

        {{-- FILTROS --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-8 transition-all duration-200 hover:shadow-xl">
            <div class="mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Filtros de Búsqueda</h2>
                <p class="text-gray-500 text-sm mt-1">Selecciona los criterios para filtrar los reportes</p>
            </div>
            
            <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 items-end">
                <div class="space-y-2">
                    <label for="desde" class="block text-sm font-medium text-gray-700">Desde</label>
                    <input type="date" name="desde" value="{{ $filtros['desde'] }}"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" />
                </div>
                <div class="space-y-2">
                    <label for="hasta" class="block text-sm font-medium text-gray-700">Hasta</label>
                    <input type="date" name="hasta" value="{{ $filtros['hasta'] }}"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" />
                </div>
                <div class="space-y-2">
                    <label for="user_id" class="block text-sm font-medium text-gray-700">Cajero</label>
                    <select name="user_id"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                        <option value="">Todos los cajeros</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ $filtros['user_id'] == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-2">
                    <label for="modulo" class="block text-sm font-medium text-gray-700">Módulo</label>
                    <select name="modulo"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                        <option value="todos" {{ $filtros['modulo'] == 'todos' ? 'selected' : '' }}>Todos los módulos</option>
                        <option value="remesas" {{ $filtros['modulo'] == 'remesas' ? 'selected' : '' }}>Remesas</option>
                        <option value="retiros" {{ $filtros['modulo'] == 'retiros' ? 'selected' : '' }}>Retiros</option>
                        <option value="depositos" {{ $filtros['modulo'] == 'depositos' ? 'selected' : '' }}>Depósitos</option>
                        <option value="servicios" {{ $filtros['modulo'] == 'servicios' ? 'selected' : '' }}>Servicios</option>
                        <option value="recargas" {{ $filtros['modulo'] == 'recargas' ? 'selected' : '' }}>Recargas</option>
                        <option value="impresiones" {{ $filtros['modulo'] == 'impresiones' ? 'selected' : '' }}>Impresiones</option>
                        <option value="productos" {{ $filtros['modulo'] == 'productos' ? 'selected' : '' }}>Productos</option>
                        <option value="salidas" {{ $filtros['modulo'] == 'salidas' ? 'selected' : '' }}>Salidas de efectivo</option>
                        <option value="consumos" {{ $filtros['modulo'] == 'consumos' ? 'selected' : '' }}>Consumos</option>
                    </select>
                </div>
                <div class="md:col-span-2 lg:col-span-4 flex gap-3 mt-2 pt-4 border-t border-gray-200">
                    <button type="submit"
                        class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl shadow font-medium transition-all duration-200 transform hover:scale-105 focus:ring-2 focus:ring-indigo-300">
                        Aplicar Filtros
                    </button>
                    <a href="{{ route('admin.reportes.cyber') }}"
                        class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-6 py-3 rounded-xl shadow font-medium transition-all duration-200 transform hover:scale-105 focus:ring-2 focus:ring-gray-300">
                        Limpiar Filtros
                    </a>
                </div>
            </form>
        </div>

        {{-- SECCIONES DINÁMICAS --}}
        @php
            $modulo = $filtros['modulo'];
        @endphp

        <div class="space-y-8">
            @if ($modulo === 'todos' || $modulo === 'remesas')
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden transition-all duration-200 hover:shadow-xl">
                    @include('admin.reportes.partials.remesas')
                </div>
            @endif

            @if ($modulo === 'todos' || $modulo === 'retiros')
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden transition-all duration-200 hover:shadow-xl">
                    @include('admin.reportes.partials.retiros')
                </div>
            @endif

            @if ($modulo === 'todos' || $modulo === 'salidas')
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden transition-all duration-200 hover:shadow-xl">
                    @include('admin.reportes.partials.salidas')
                </div>
            @endif

            @if ($modulo === 'todos' || $modulo === 'consumos')
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden transition-all duration-200 hover:shadow-xl">
                    @include('admin.reportes.partials.consumos')
                </div>
            @endif

            @if ($modulo === 'todos' || $modulo === 'depositos')
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden transition-all duration-200 hover:shadow-xl">
                    @include('admin.reportes.partials.depositos')
                </div>
            @endif

            @if ($modulo === 'todos' || $modulo === 'servicios')
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden transition-all duration-200 hover:shadow-xl">
                    @include('admin.reportes.partials.servicios')
                </div>
            @endif

            @if ($modulo === 'todos' || $modulo === 'recargas')
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden transition-all duration-200 hover:shadow-xl">
                    @include('admin.reportes.partials.recargas')
                </div>
            @endif

            @if ($modulo === 'todos' || $modulo === 'impresiones')
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden transition-all duration-200 hover:shadow-xl">
                    @include('admin.reportes.partials.impresiones')
                </div>
            @endif

            @if ($modulo === 'todos' || $modulo === 'productos')
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden transition-all duration-200 hover:shadow-xl">
                    @include('admin.reportes.partials.productos')
                </div>
            @endif
        </div>
    </div>
@endsection