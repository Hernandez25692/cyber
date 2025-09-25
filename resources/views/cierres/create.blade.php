<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Cierre de Turno</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: #f4f6fa;
        }
        .rms-header {
            background: linear-gradient(90deg, #2d3748 0%, #4a5568 100%);
            color: #fff;
            padding: 2rem 0 1rem 0;
            border-radius: 1rem 1rem 0 0;
            box-shadow: 0 2px 8px rgba(44,62,80,0.08);
        }
        .rms-section-title {
            color: #2d3748;
            border-left: 4px solid #3182ce;
            padding-left: 0.75rem;
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .rms-table th {
            background: #e2e8f0;
            color: #2d3748;
            font-weight: 700;
        }
        .rms-table td, .rms-table th {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e2e8f0;
        }
        .rms-summary {
            background: #f7fafc;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
    </style>
</head>

<body>
    <div class="max-w-3xl mx-auto mt-10 bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Header estilo RMS -->
        <div class="rms-header text-center">
            <h1 class="text-3xl font-bold tracking-wide mb-1">Reporte X - Cierre de Turno</h1>
            <p class="text-sm opacity-80">Resumen de operaciones y cierre de caja</p>
        </div>

        <div class="p-8">
            <!-- Datos de Apertura -->
            <div class="rms-section-title mb-4">💼 Datos de Apertura</div>
            
            <div class="rms-summary grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="flex flex-col justify-center items-start">
                    <span class="text-gray-600 font-semibold mb-1">Usuario</span>
                    <span class="font-semibold text-blue-700">
                        {{ auth()->user()->role ?? 'Cajero' }}: {{ auth()->user()->name ?? '' }}
                    </span>
                </div>
                <div>
                    <span class="text-gray-600 font-semibold mb-1 block">Fecha de apertura</span>
                    <span class="text-lg font-bold text-gray-800">{{ $apertura->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div>
                    <span class="text-gray-600 font-semibold mb-1 block">Efectivo inicial</span>
                    <span class="text-lg font-bold text-green-700">L {{ number_format($apertura->efectivo_inicial, 2) }}</span>
                </div>
            </div>
            <div class="mb-8">
                <div class="text-gray-600 font-semibold mb-2">POS inicial por banco</div>
                @if (is_array($apertura->pos_inicial))
                    <table class="rms-table w-full text-left rounded-lg overflow-hidden">
                        <thead>
                            <tr>
                                <th>Banco</th>
                                <th>Monto Inicial (L)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($apertura->pos_inicial as $banco_id => $monto)
                                @php $banco = $bancos->firstWhere('id', $banco_id); @endphp
                                <tr>
                                    <td>{{ $banco->nombre ?? 'Banco eliminado' }}</td>
                                    <td class="font-semibold text-gray-700">L {{ number_format($monto, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-red-600">⚠ No se encontraron datos de POS inicial.</p>
                @endif
            </div>

            <!-- Formulario de cierre -->
            <form action="{{ route('cierres.store') }}" method="POST" class="space-y-8">
                @csrf

                <div class="rms-section-title">📥 Ingreso de valores finales</div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 rms-summary mb-6">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Efectivo final</label>
                        <input type="number" name="efectivo_final" step="0.01" required
                            class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-400"
                            value="{{ $cierre_pendiente->efectivo_final ?? '' }}">
                    </div>
                </div>

                <div class="rms-section-title">🏦 POS por banco (valores finales)</div>
                <table class="rms-table w-full text-left rounded-lg overflow-hidden mb-8">
                    <thead>
                        <tr>
                            <th>Banco</th>
                            <th>Monto Final (L)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bancos as $banco)
                            <tr>
                                <td>
                                    <input type="hidden" name="banco_id[]" value="{{ $banco->id }}">
                                    <span class="font-semibold">{{ $banco->nombre }}</span>
                                </td>
                                <td>
                                    @php
                                        $monto_guardado = '';
                                        if ($cierre_pendiente && is_array(json_decode($cierre_pendiente->pos_final, true))) {
                                            $monto_guardado = json_decode($cierre_pendiente->pos_final, true)[$banco->id] ?? '';
                                        }
                                    @endphp
                                    <input type="number" name="pos_monto[]" step="0.01"
                                        class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-400"
                                        required placeholder="Monto final" value="{{ $monto_guardado }}">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="flex justify-between items-center">
                    <a href="{{ route('pos') }}"
                        class="inline-block bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 font-semibold transition">
                        ← Regresar
                    </a>
                    <button type="submit"
                        class="bg-blue-600 text-white px-8 py-2 rounded font-bold shadow hover:bg-blue-700 transition">
                        Validar y ver Reporte Z
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
