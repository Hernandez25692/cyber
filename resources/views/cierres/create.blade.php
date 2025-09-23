<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Cierre de Turno</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CSS CDN (opcional, si usas Tailwind) -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded-xl shadow">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">🔴 Cierre de Turno</h2>

        <form action="{{ route('cierres.store') }}" method="POST">
            @csrf

            <div class="mb-6 bg-gray-50 border border-gray-200 p-4 rounded-lg">
                <h3 class="font-bold text-lg text-gray-700 mb-2">💼 Datos de Apertura</h3>

                <p class="mb-2"><strong>Fecha:</strong> {{ $apertura->created_at->format('d/m/Y H:i') }}</p>
                <p class="mb-2"><strong>Efectivo inicial:</strong> L
                    {{ number_format($apertura->efectivo_inicial, 2) }}</p>

                <div class="grid md:grid-cols-2 gap-4 mt-4">
                    @if (is_array($apertura->pos_inicial))
                        <div class="grid md:grid-cols-2 gap-4 mt-4">
                            @foreach ($apertura->pos_inicial as $banco_id => $monto)
                                @php $banco = $bancos->firstWhere('id', $banco_id); @endphp
                                <div class="p-3 border rounded bg-white">
                                    <p class="text-sm text-gray-600 font-medium">
                                        {{ $banco->nombre ?? 'Banco eliminado' }}
                                    </p>
                                    <p class="text-lg font-semibold text-gray-800">L {{ number_format($monto, 2) }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-red-600">⚠ No se encontraron datos de POS inicial.</p>
                    @endif


                </div>
            </div>

            <hr class="my-6">

            <h3 class="font-bold text-lg mb-4 text-gray-800">📥 Ingreso de valores finales</h3>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Efectivo final</label>
                <input type="number" name="efectivo_final" step="0.01" required class="w-full border rounded p-2"
                    value="{{ $cierre_pendiente->efectivo_final ?? '' }}">

            </div>

            <h3 class="font-semibold text-gray-700 mt-6 mb-3">POS por banco (valores finales)</h3>

            @foreach ($bancos as $banco)
                <div class="grid grid-cols-2 gap-4 mb-3">
                    <input type="hidden" name="banco_id[]" value="{{ $banco->id }}">
                    <div>
                        <label class="block font-semibold">{{ $banco->nombre }}</label>
                    </div>
                    <div>
                        @php
                            $monto_guardado = '';
                            if ($cierre_pendiente && is_array(json_decode($cierre_pendiente->pos_final, true))) {
                                $monto_guardado = json_decode($cierre_pendiente->pos_final, true)[$banco->id] ?? '';
                            }
                        @endphp
                        <input type="number" name="pos_monto[]" step="0.01" class="w-full border rounded p-2"
                            required placeholder="Monto final" value="{{ $monto_guardado }}">

                    </div>
                </div>
            @endforeach

            <div class="mt-6 text-right">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    Validar y ver Reporte Z
                </button>
            </div>

        </form>
    </div>

</body>

</html>
