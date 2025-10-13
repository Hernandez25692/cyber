@extends('layouts.admin')

@section('title', 'Editar Rango de Retiro')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-600 mb-4" aria-label="Breadcrumb">
            <ol class="list-reset flex items-center gap-2">
                <li>
                    <a href="{{ route('admin.retiros.config.index') }}" class="hover:underline flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Volver
                    </a>
                </li>
                <li class="text-gray-400">/</li>
                <li class="font-semibold text-amber-700">Editar Rango</li>
            </ol>
        </nav>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <!-- Card header -->
            <div class="bg-gradient-to-r from-amber-50 to-white border-b border-amber-100 px-6 py-5 flex items-center gap-4">
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-amber-100 text-amber-700 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M11 5h6M11 9h6M7 5v14a2 2 0 002 2h6" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-amber-700">✏️ Editar Rango de Retiro</h2>
                    <p class="text-sm text-gray-500">Actualiza los valores del rango. Los cambios serán aplicados inmediatamente.</p>
                </div>
            </div>

            <div class="p-6">
                @if (session('success'))
                    <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li class="text-sm">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.retiros.config.update', $retiro) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="nombre" class="block font-semibold text-gray-700 mb-1">Nombre del Rango</label>
                        <input id="nombre" type="text" name="nombre" value="{{ old('nombre', $retiro->nombre) }}"
                            class="w-full rounded-md px-3 py-2 transition-shadow duration-150
                                focus:outline-none focus:shadow-outline
                                {{ $errors->has('nombre') ? 'border-red-400 ring-1 ring-red-200' : 'border-gray-200' }} border"
                            required>
                        @error('nombre')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @else
                            <p class="mt-1 text-xs text-gray-400">Ej: Rango Básico / Rango Avanzado</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="monto_min" class="block font-semibold text-gray-700 mb-1">Monto Mínimo</label>
                            <div class="relative">
                                <input id="monto_min" type="number" name="monto_min" step="0.01"
                                    value="{{ old('monto_min', $retiro->monto_min) }}"
                                    class="w-full rounded-md px-3 py-2 transition-shadow duration-150
                                        focus:outline-none focus:shadow-outline
                                        {{ $errors->has('monto_min') ? 'border-red-400 ring-1 ring-red-200' : 'border-gray-200' }} border"
                                    required>
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-400">L</span>
                            </div>
                            @error('monto_min')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @else
                                <p class="mt-1 text-xs text-gray-400">Valor mínimo permitido para este rango.</p>
                            @enderror
                        </div>

                        <div>
                            <label for="monto_max" class="block font-semibold text-gray-700 mb-1">Monto Máximo</label>
                            <div class="relative">
                                <input id="monto_max" type="number" name="monto_max" step="0.01"
                                    value="{{ old('monto_max', $retiro->monto_max) }}"
                                    class="w-full rounded-md px-3 py-2 transition-shadow duration-150
                                        focus:outline-none focus:shadow-outline
                                        {{ $errors->has('monto_max') ? 'border-red-400 ring-1 ring-red-200' : 'border-gray-200' }} border"
                                    required>
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-400">L</span>
                            </div>
                            @error('monto_max')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @else
                                <p class="mt-1 text-xs text-gray-400">Valor máximo permitido para este rango.</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="comision" class="block font-semibold text-gray-700 mb-1">Comisión</label>
                        <div class="relative">
                            <input id="comision" type="number" name="comision" step="0.01"
                                value="{{ old('comision', $retiro->comision) }}"
                                class="w-full rounded-md px-3 py-2 pr-14 transition-shadow duration-150
                                    focus:outline-none focus:shadow-outline
                                    {{ $errors->has('comision') ? 'border-red-400 ring-1 ring-red-200' : 'border-gray-200' }} border"
                                required>
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-sm text-gray-500">L</span>
                        </div>
                        @error('comision')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @else
                            
                        @enderror
                    </div>

                    <div class="flex items-center justify-between gap-3 pt-2">
                        <a href="{{ route('admin.retiros.config.index') }}"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-800 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7"></path>
                            </svg>
                            ← Cancelar
                        </a>

                        <div class="ml-auto flex items-center gap-3">
                            <button type="submit"
                                class="px-5 py-2 rounded-lg text-white bg-amber-600 hover:bg-amber-700 shadow transition flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                💾 Guardar Cambios
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
