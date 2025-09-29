@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 bg-gradient-to-br from-blue-50 via-gray-50 to-gray-100 min-h-screen">
    <!-- Título principal -->
    <div class="mb-10">
        <h1 class="text-4xl font-extrabold text-blue-900 mb-2 flex items-center gap-3">
            <span class="bg-blue-100 rounded-full px-3 py-1 text-2xl">⚙️</span>
            Configuración de Comisiones para Retiros
        </h1>
        <p class="text-base text-gray-600">Administra los rangos y comisiones aplicadas a los retiros de usuarios.</p>
    </div>

    <!-- Sección de acciones -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4">
        <a href="{{ route('admin.index') }}" class="bg-gray-600 text-white px-5 py-2 rounded-lg shadow hover:bg-gray-700 flex items-center gap-2 transition">
            ← Regresar
        </a>
        <a href="{{ route('admin.retiros.config.create') }}" class="bg-gradient-to-r from-blue-600 to-blue-400 text-white px-5 py-2 rounded-lg shadow hover:from-blue-700 hover:to-blue-500 flex items-center gap-2 transition">
            ➕ Nuevo Rango
        </a>
    </div>

    <!-- Mensaje de éxito -->
    @if (session('success'))
        <div class="mb-8">
            <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg shadow flex items-center gap-2">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    <!-- Tarjetas de rangos -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse ($rangos as $rango)
            <div class="bg-white rounded-2xl shadow-lg p-7 flex flex-col justify-between border border-blue-100 hover:shadow-xl transition">
                <div>
                    <h2 class="text-xl font-bold text-blue-700 mb-5 flex items-center gap-2">
                        <span class="bg-blue-50 rounded-full px-2 py-1">🏷️</span>
                        {{ $rango->nombre }}
                    </h2>
                    <ul class="mb-4 text-gray-700 space-y-2">
                        <li>
                            <span class="font-semibold text-gray-600">Monto Mínimo:</span>
                            <span class="ml-2 text-blue-800 font-mono">L {{ number_format($rango->monto_min, 2) }}</span>
                        </li>
                        <li>
                            <span class="font-semibold text-gray-600">Monto Máximo:</span>
                            <span class="ml-2 text-blue-800 font-mono">L {{ number_format($rango->monto_max, 2) }}</span>
                        </li>
                        <li>
                            <span class="font-semibold text-gray-600">Comisión:</span>
                            <span class="ml-2 text-blue-800 font-mono">L {{ number_format($rango->comision, 2) }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl shadow-lg p-8 text-center text-gray-500 border border-gray-200">
                <span class="text-2xl mb-2 block">😕</span>
                No hay rangos configurados aún.
            </div>
        @endforelse
    </div>
</div>
@endsection
