<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Apertura de Turno</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">
    <div class="max-w-4xl mx-auto mt-12 p-6">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="px-6 py-5 border-b">
                <h1 class="text-2xl font-semibold flex items-center gap-3">
                    <span class="inline-block bg-green-100 text-green-700 rounded-full px-2 py-1 text-sm">🟢</span>
                    Apertura de Turno
                </h1>
                <p class="text-sm text-gray-500 mt-1">Registra el efectivo inicial y montos por POS (banco).</p>
            </div>

            <div class="p-6">
                {{-- Global validation errors --}}
                @if ($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 p-3 rounded">
                        <strong class="block">Hay errores en el formulario:</strong>
                        <ul class="mt-2 list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('aperturas.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="efectivo_inicial" class="block text-sm font-medium text-gray-700">Efectivo inicial</label>
                        <div class="mt-1 relative">
                            <input
                                id="efectivo_inicial"
                                name="efectivo_inicial"
                                type="number"
                                step="0.01"
                                inputmode="decimal"
                                value="{{ old('efectivo_inicial') }}"
                                required
                                class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-300 focus:border-green-500"
                                aria-describedby="efectivo_help"
                                placeholder="0.00"
                            />
                        </div>
                        <p id="efectivo_help" class="mt-1 text-xs text-gray-500">Ingresa el monto inicial en efectivo (dos decimales).</p>
                        @error('efectivo_inicial')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-medium text-gray-800">POS por banco</h2>
                            <p class="text-sm text-gray-500">Ingresa el monto por cada banco mostrado</p>
                        </div>

                        <div class="mt-4 space-y-4">
                            @foreach ($bancos as $index => $banco)
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 items-end">
                                    <div class="sm:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Banco</label>
                                        <select
                                            name="banco_id[]"
                                            class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 bg-gray-50"
                                            required
                                            aria-label="Banco {{ $banco->nombre }}"
                                        >
                                            <option value="{{ $banco->id }}" {{ old('banco_id.'.$index) == $banco->id ? 'selected' : '' }}>
                                                {{ $banco->nombre }}
                                            </option>
                                        </select>
                                        @error('banco_id.'.$index)
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Monto</label>
                                        <input
                                            name="pos_monto[]"
                                            type="number"
                                            step="0.01"
                                            inputmode="decimal"
                                            value="{{ old('pos_monto.'.$index, '0.00') }}"
                                            class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500"
                                            placeholder="0.00"
                                            required
                                            aria-label="Monto POS {{ $banco->nombre }}"
                                            min="0"
                                        />
                                        @error('pos_monto.'.$index)
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="pt-4 border-t flex items-center justify-end gap-3">
                        <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 border rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Cancelar
                        </a>
                        <button
                            type="submit"
                            class="inline-flex items-center px-6 py-2 bg-green-600 text-white rounded-md text-sm font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-300"
                        >
                            Registrar Apertura
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
