@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 bg-gradient-to-br from-blue-50 to-gray-100 min-h-screen">
    <!-- Título principal -->
    <div class="mb-8">
        <h1 class="text-4xl font-extrabold text-blue-900 mb-2 flex items-center gap-3">
            <span class="bg-blue-100 rounded-full p-2 text-2xl">🏦</span>
            Bancos
        </h1>
        <p class="text-base text-gray-600">Gestión de bancos registrados en el sistema</p>
    </div>

    <!-- Sección de acciones -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-10 gap-4">
        <a href="{{ route('admin.index') }}" class="bg-gray-200 text-gray-700 px-5 py-2 rounded-lg shadow hover:bg-gray-300 flex items-center gap-2 transition">
            ← Regresar
        </a>
        <a href="{{ route('admin.servicios.bancos.create') }}" class="bg-blue-600 text-white px-5 py-2 rounded-lg shadow hover:bg-blue-700 flex items-center gap-2 transition">
            <span class="text-xl">＋</span> Nuevo Banco
        </a>
    </div>

    <!-- Tarjetas de bancos -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse ($bancos as $banco)
            <div class="bg-white rounded-2xl shadow-lg p-7 flex flex-col justify-between border border-blue-100 hover:shadow-xl transition">
                <div>
                    <h2 class="text-xl font-bold text-blue-800 mb-3 flex items-center gap-2">
                        <span class="bg-blue-50 rounded-full p-1">🏦</span>
                        {{ $banco->nombre }}
                    </h2>
                </div>
                
            </div>
        @empty
            <div class="col-span-full text-center text-gray-400 py-16">
                <div class="flex flex-col items-center gap-2">
                    <span class="text-5xl">🏦</span>
                    <span class="text-lg">No hay bancos registrados.</span>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
