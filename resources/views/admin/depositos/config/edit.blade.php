@extends('layouts.admin')

@section('title', 'Editar Rango de Comisión - Depósitos')

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <nav class="text-sm text-gray-500 mb-4" aria-label="Breadcrumb">
            <ol class="list-reset flex items-center space-x-2">
                <li>
                    <a href="{{ route('admin.depositos.config.index') }}" class="hover:underline text-gray-600">
                        Configuración Depósitos
                    </a>
                </li>
                <li class="text-gray-400">/</li>
                <li class="text-gray-700 font-medium">Editar rango</li>
            </ol>
        </nav>

        <header class="mb-6 flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-bold text-blue-600 flex items-center gap-2">
                    <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V4m0 16v-4">
                        </path>
                    </svg>
                    Editar Rango de Comisión - Depósitos
                </h1>
                <p class="text-sm text-gray-500 mt-1">Ajusta los valores del rango y la comisión aplicable.</p>
            </div>
        </header>

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                <div class="font-semibold">Hay errores en el formulario:</div>
                <ul class="list-disc list-inside text-sm mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.depositos.config.update', $deposito) }}" method="POST" class="space-y-6 bg-white shadow-sm border rounded-lg p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="col-span-1 md:col-span-2">
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                    <input id="nombre" type="text" name="nombre" value="{{ old('nombre', $deposito->nombre) }}"
                        class="block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                        required aria-required="true" />
                </div>

                <div>
                    <label for="monto_min" class="block text-sm font-medium text-gray-700 mb-1">Monto Mínimo</label>
                    <div class="flex items-center">
                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-600">
                            L
                        </span>
                        <input id="monto_min" type="number" name="monto_min" step="0.01"
                            value="{{ old('monto_min', $deposito->monto_min) }}"
                            class="block w-full border border-gray-300 rounded-r-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                            required aria-required="true" />
                    </div>
                    <p class="mt-1 text-xs text-gray-400">Valor mínimo permitido para este rango.</p>
                </div>

                <div>
                    <label for="monto_max" class="block text-sm font-medium text-gray-700 mb-1">Monto Máximo</label>
                    <div class="flex items-center">
                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-600">
                            L
                        </span>
                        <input id="monto_max" type="number" name="monto_max" step="0.01"
                            value="{{ old('monto_max', $deposito->monto_max) }}"
                            class="block w-full border border-gray-300 rounded-r-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                            required aria-required="true" />
                    </div>
                    <p class="mt-1 text-xs text-gray-400">Valor máximo permitido para este rango.</p>
                </div>

                <div class="md:col-span-2">
                    <label for="comision" class="block text-sm font-medium text-gray-700 mb-1">Comisión</label>
                    <div class="flex items-center">
                        <input id="comision" type="number" name="comision" step="0.01"
                            value="{{ old('comision', $deposito->comision) }}"
                            class="block w-full border border-gray-300 rounded-l-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                            required aria-required="true" />
                        
                    </div>
                    
                </div>
            </div>

            <div class="flex flex-col md:flex-row items-center justify-between gap-3 mt-2">
                <div class="text-sm text-gray-500">
                    <span class="font-medium">ID:</span> {{ $deposito->id ?? '-' }}
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.depositos.config.index') }}"
                        class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Guardar cambios
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
