@extends('layouts.admin')
@section('title', 'Servicios de Impresión')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <!-- Título principal y subtítulo -->
    <div class="mb-10">
        <h1 class="text-4xl font-extrabold text-blue-800 mb-2 flex items-center gap-3 drop-shadow">
            🖨️ Servicios de Impresión
        </h1>
        <p class="text-base text-gray-600">Administra los servicios de impresión disponibles en el sistema.</p>
    </div>

    <!-- Sección de acciones -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-10">
        <a href="{{ route('admin.index') }}" class="bg-gray-500 text-white px-5 py-2 rounded-lg shadow hover:bg-gray-700 transition flex items-center gap-2">
            ← Regresar
        </a>
        <a href="{{ route('admin.impresiones.servicios.create') }}" class="bg-blue-600 text-white px-5 py-2 rounded-lg shadow hover:bg-blue-800 transition flex items-center gap-2">
            ➕ Nuevo Servicio
        </a>
    </div>

    <!-- Tarjetas de servicios -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse ($servicios as $servicio)
            <div class="bg-white rounded-2xl shadow-lg p-7 flex flex-col justify-between border border-blue-100 hover:scale-105 transition-transform duration-200">
                <div>
                    <h2 class="text-xl font-bold text-blue-700 mb-4 flex items-center gap-2">
                        📝 {{ $servicio->nombre }}
                    </h2>
                    <p class="text-sm text-gray-500 mb-2">ID: <span class="font-mono text-blue-600">{{ $servicio->id }}</span></p>
                </div>
                
            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl shadow-lg p-8 text-center text-gray-500 border border-blue-100">
                No hay servicios registrados.
            </div>
        @endforelse
    </div>
</div>
@endsection
