@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center gap-2">
                🏦 Crear Banco
            </h1>
            <p class="text-sm text-gray-500">Agrega un nuevo banco al sistema administrativo.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('admin.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600 flex items-center gap-2">
                ← Regresar
            </a>
        </div>
    </div>

    <!-- Content Card -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow p-6 col-span-1 md:col-span-2 lg:col-span-1">
            <h2 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10l9-7 9 7v7a2 2 0 01-2 2H5a2 2 0 01-2-2v-7z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 21V9h6v12" />
                </svg>
                Datos del Banco
            </h2>
            <form action="{{ route('admin.servicios.bancos.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block font-semibold text-gray-600 mb-1">Nombre</label>
                    <input type="text" name="nombre" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 transition">
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded shadow flex items-center gap-2 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        Guardar
                    </button>
                    <a href="{{ route('admin.servicios.bancos.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded shadow flex items-center gap-2 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
