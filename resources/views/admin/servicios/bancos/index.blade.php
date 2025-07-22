@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 bg-gray-50 min-h-screen">
    <!-- Título principal -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-1 flex items-center gap-2">
            🏦 Bancos
        </h1>
        <p class="text-sm text-gray-500">Gestión de bancos registrados en el sistema</p>
    </div>

    <!-- Sección de acciones -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-3">
        <a href="{{ route('admin.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600 flex items-center gap-2">
            ← Regresar
        </a>
        <a href="{{ route('admin.servicios.bancos.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 flex items-center gap-2">
            <span>＋</span> Nuevo Banco
        </a>
    </div>

    <!-- Tarjetas de bancos -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($bancos as $banco)
            <div class="bg-white rounded-xl shadow p-6 flex flex-col justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-700 mb-2 flex items-center gap-2">
                        🏦 {{ $banco->nombre }}
                    </h2>
                </div>
                <div class="mt-4 flex gap-2">
                    <form action="{{ route('admin.servicios.bancos.destroy', $banco) }}" method="POST" onsubmit="return confirm('¿Eliminar este banco?')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center text-gray-500 py-12">
                No hay bancos registrados.
            </div>
        @endforelse
    </div>
</div>
@endsection
