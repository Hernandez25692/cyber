@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 bg-gradient-to-br from-blue-50 via-white to-gray-100 min-h-screen font-sans">
    <!-- Título principal -->
    <div class="mb-10">
        <h1 class="text-4xl font-extrabold text-blue-800 mb-2 flex items-center gap-3 tracking-tight drop-shadow">
            <span class="text-blue-700 animate-bounce">🛠️</span> Tipos de Servicio
        </h1>
        <p class="text-lg text-gray-600">Administra los diferentes tipos de servicios disponibles en la plataforma.</p>
    </div>

    <!-- Sección de acciones -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4">
        <a href="{{ route('admin.index') }}" class="bg-white border border-gray-300 text-gray-700 px-5 py-2.5 rounded-lg shadow hover:bg-gray-50 flex items-center gap-2 transition font-medium">
            ← Regresar
        </a>
        <a href="{{ route('admin.servicios.tipos.create') }}" class="bg-gradient-to-r from-blue-700 to-blue-500 text-white px-5 py-2.5 rounded-lg shadow hover:from-blue-800 hover:to-blue-600 flex items-center gap-2 transition font-semibold">
            <span class="font-bold text-xl">＋</span> Nuevo Tipo
        </a>
    </div>

    <!-- Tarjetas de tipos de servicio -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse ($tipos as $tipo)
            <div class="bg-white border border-gray-200 rounded-xl shadow-lg p-7 flex flex-col justify-between hover:shadow-xl transition group relative overflow-hidden">
                <div>
                    <h2 class="text-xl font-bold text-blue-700 mb-2 flex items-center gap-2">
                        <span class="text-blue-600">🏷️</span> {{ $tipo->nombre }}
                    </h2>
                </div>
                
                <div class="absolute top-0 right-0 opacity-10 text-7xl pointer-events-none select-none group-hover:opacity-20 transition">🛠️</div>
            </div>
        @empty
            <div class="col-span-full bg-white border border-gray-200 rounded-xl shadow-lg p-8 text-center text-gray-500 text-lg">
                No hay tipos de servicio registrados.
            </div>
        @endforelse
    </div>
</div>
@endsection
