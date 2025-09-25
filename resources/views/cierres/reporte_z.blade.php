<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte Z - Resumen de Cierre</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
        }

        .receipt-style {
            border-top: 2px dashed #e2e8f0;
            border-bottom: 2px dashed #e2e8f0;
        }

        .total-box {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        }

        .print-only {
            display: none;
        }

        @media print {
            body {
                background-color: white;
                font-size: 12px;
            }

            .no-print {
                display: none;
            }

            .print-only {
                display: block;
            }

            .shadow,
            .shadow-lg {
                box-shadow: none;
            }

            .break-after {
                page-break-after: always;
            }
        }

        /* Estilo para el ticket de impresión tipo RMS */
        .rms-ticket {
            font-family: 'Roboto Mono', monospace;
            width: 320px;
            margin: 0 auto;
            background: #fff;
            color: #222;
            font-size: 13px;
            padding: 0;
        }

        .rms-ticket .title {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 2px;
        }

        .rms-ticket .subtitle {
            text-align: center;
            font-size: 13px;
            margin-bottom: 8px;
        }

        .rms-ticket .section {
            border-top: 1px dashed #bbb;
            margin: 8px 0;
            padding-top: 6px;
        }

        .rms-ticket .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2px;
        }

        .rms-ticket .total {
            font-weight: bold;
            font-size: 15px;
            border-top: 1px solid #222;
            margin-top: 6px;
            padding-top: 4px;
        }

        .rms-ticket .diff {
            font-weight: bold;
            font-size: 14px;
            text-align: center;
            margin-top: 8px;
        }

        .rms-ticket .small {
            font-size: 11px;
            color: #666;
        }
    </style>
</head>

<body class="bg-gray-50">

    <div class="max-w-4xl mx-auto my-8 bg-white p-8 rounded-xl shadow-lg">
        @php
            // Turno cerrado cuando pendiente es false o cuando ya se generó el reporte Z
            $turnoCerrado = false;
            if (isset($cierre)) {
                $turnoCerrado =
                    (isset($cierre->pendiente) && $cierre->pendiente === false) || !empty($cierre->reporte_z_generado);
            }
        @endphp

        <div id="printable-area">
            <!-- Encabezado -->
            <div class="text-center mb-8">
                <div class="flex justify-between items-center mb-4">
                    <div class="text-left">
                        <h1 class="text-3xl font-bold text-gray-800">REPORTE Z</h1>
                        <p class="text-gray-600">Resumen de Cierre de Turno</p>
                        <span class="font-semibold text-green-700">
                            {{ auth()->user()->role ?? 'Cajero' }}: {{ auth()->user()->name ?? '' }}
                        </span>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Generado: {{ now()->format('d/m/Y H:i') }}</p>
                        <p class="text-sm font-semibold">Punto de Venta: {{ $puntoVentaNombre ?? '001' }}</p>
                    </div>
                </div>
                <div class="receipt-style py-4 my-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-left">
                            <p><span class="font-semibold">Fecha Apertura:</span>
                                {{ $apertura->created_at->format('d/m/Y H:i') }}</p>
                            <p><span class="font-semibold">Fecha Cierre:</span>
                                {{ $cierre->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="text-right">
                            <p><span class="font-semibold">Efectivo Inicial:</span> L
                                {{ number_format($apertura->efectivo_inicial, 2) }}</p>
                            <p><span class="font-semibold">Efectivo Final:</span> L
                                {{ number_format($cierre->efectivo_final, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resumen Financiero -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Ingresos -->
                <div class="border border-green-200 rounded-lg overflow-hidden mb-6 md:mb-0">
                    <div class="bg-green-600 p-3">
                        <h3 class="text-white font-bold text-lg flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd" d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"
                                    clip-rule="evenodd" />
                            </svg>
                            INGRESOS
                        </h3>
                    </div>
                    <div class="p-4 space-y-2">
                        @php
                            $comisiones = [
                                ['label' => 'Remesas', 'value' => $comision_remesas ?? 0],
                                ['label' => 'Retiros', 'value' => $comision_retiros ?? 0],
                                ['label' => 'Depósitos', 'value' => $comision_depositos ?? 0],
                                ['label' => 'Servicios', 'value' => $comision_servicios ?? 0],
                            ];
                        @endphp
                        @foreach ([['label' => 'Ventas', 'value' => $ventas], ['label' => 'Recargas', 'value' => $recargas], ['label' => 'Servicios', 'value' => $servicios], ['label' => 'Impresiones', 'value' => $impresiones], ['label' => 'Depósitos', 'value' => $depositos]] as $item)
                            <div class="flex justify-between">
                                <span>{{ $item['label'] }}:</span>
                                <span class="font-medium">L {{ number_format($item['value'], 2) }}</span>
                            </div>
                        @endforeach
                        <div class="border-t border-gray-200 pt-2 mt-2">
                            <div class="flex justify-between font-semibold">
                                <span>Comisiones:</span>
                                <span>L {{ number_format($ingresos_comisiones, 2) }}</span>
                            </div>
                            <div class="text-xs text-gray-500 mt-1 space-y-0.5">
                                @foreach ($comisiones as $com)
                                    <div class="flex justify-between">
                                        <span>• {{ $com['label'] }}</span>
                                        <span>L {{ number_format($com['value'], 2) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="border-t border-green-200 pt-2 mt-2">
                            <div class="flex justify-between font-bold text-green-700">
                                <span>TOTAL INGRESOS:</span>
                                <span>L {{ number_format($ingresos, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Egresos -->
                <div class="border border-red-200 rounded-lg overflow-hidden mb-6 md:mb-0">
                    <div class="bg-red-600 p-3">
                        <h3 class="text-white font-bold text-lg flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd" d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"
                                    clip-rule="evenodd" />
                            </svg>
                            EGRESOS
                        </h3>
                    </div>
                    <div class="p-4 space-y-2">
                        @foreach ([['label' => 'Retiros', 'value' => $retiros], ['label' => 'Remesas', 'value' => $remesas]] as $item)
                            <div class="flex justify-between">
                                <span>{{ $item['label'] }}:</span>
                                <span class="font-medium">L {{ number_format($item['value'], 2) }}</span>
                            </div>
                        @endforeach
                        <div class="border-t border-red-200 pt-2 mt-4">
                            <div class="flex justify-between font-bold text-red-700">
                                <span>TOTAL EGRESOS:</span>
                                <span>L {{ number_format($egresos, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resumen Final -->
            <div class="total-box p-6 rounded-lg mb-8 border border-blue-200">
                <h3 class="text-xl font-bold text-gray-800 mb-4 text-center">RESUMEN FINAL</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        @foreach ([['label' => 'Efectivo Inicial', 'value' => $apertura->efectivo_inicial], ['label' => 'Total Ingresos', 'value' => $ingresos], ['label' => 'Total Egresos', 'value' => $egresos]] as $item)
                            <div class="flex justify-between py-2 border-b border-gray-200">
                                <span class="font-semibold">{{ $item['label'] }}:</span>
                                <span>L {{ number_format($item['value'], 2) }}</span>
                            </div>
                        @endforeach
                        <div class="flex justify-between py-2 font-bold text-lg">
                            <span>Total Esperado:</span>
                            <span>L {{ number_format($esperado, 2) }}</span>
                        </div>
                    </div>
                    <div class="flex flex-col justify-center items-center">
                        <div class="text-center mb-4">
                            <p class="text-sm text-gray-600">Efectivo Reportado</p>
                            <p class="text-2xl font-bold">L {{ number_format($cierre->efectivo_final, 2) }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm text-gray-600">Diferencia</p>
                            @if ($diferencia > 0)
                                <p class="text-xl font-bold text-green-600">Sobrante: L
                                    {{ number_format($diferencia, 2) }}</p>
                            @elseif ($diferencia < 0)
                                <p class="text-xl font-bold text-red-600">Faltante: L
                                    {{ number_format(abs($diferencia), 2) }}</p>
                            @else
                                <p class="text-xl font-bold text-blue-600">Sin diferencia</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mensajes y Acciones -->
        @if ($cierre->diferencia < 0)
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700 font-bold">
                            No se puede cerrar turno con faltante. Corrige los valores ingresados.
                        </p>
                    </div>
                </div>
            </div>
            <div class="flex justify-end no-print">
                <a href="{{ route('cierres.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-white hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path
                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                    Corregir datos de cierre
                </a>
            </div>
        @else
            <div class="flex justify-between items-center no-print">
                <button onclick="printTicket()"
                    class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z"
                            clip-rule="evenodd" />
                    </svg>
                    Imprimir Reporte
                </button>

                {{-- Botón Cerrar Turno: deshabilitado si ya está cerrado --}}
                <button
                    @if (!$turnoCerrado) onclick="document.getElementById('confirmModal').classList.remove('hidden')" @endif
                    class="inline-flex items-center px-6 py-2 border border-transparent rounded-md font-semibold text-white focus:outline-none focus:ring-2 focus:ring-offset-2
                   {{ $turnoCerrado ? 'bg-gray-400 cursor-not-allowed opacity-60 focus:ring-gray-300' : 'bg-green-600 hover:bg-green-700 focus:ring-green-500' }}"
                    {{ $turnoCerrado ? 'disabled aria-disabled=true' : '' }}>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ $turnoCerrado ? 'Turno ya cerrado' : 'Cerrar Turno' }}
                </button>
            </div>
        @endif


        {{-- Modal de confirmación: solo si NO está cerrado --}}
        @if (!$turnoCerrado)
            <div id="confirmModal"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
                <div class="bg-white p-6 rounded-lg shadow-xl max-w-md w-full mx-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <svg class="h-6 w-6 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-bold text-gray-900">Confirmar Cierre de Turno</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-600">¿Estás seguro de cerrar el turno? Esta acción no se
                                    puede deshacer.</p>
                                <p class="text-sm font-semibold text-gray-700 mt-2">Diferencia:
                                    @if ($diferencia > 0)
                                        <span class="text-green-600">Sobrante L
                                            {{ number_format($diferencia, 2) }}</span>
                                    @elseif ($diferencia < 0)
                                        <span class="text-red-600">Faltante L
                                            {{ number_format(abs($diferencia), 2) }}</span>
                                    @else
                                        <span class="text-blue-600">Sin diferencia</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end gap-3">
                        <button onclick="document.getElementById('confirmModal').classList.add('hidden')"
                            class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                            Cancelar
                        </button>
                        <form method="POST" action="{{ route('cierres.finalizar', $cierre->id) }}">
                            @csrf
                            <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                Confirmar Cierre
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        <script>
            document.getElementById('confirmModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.add('hidden');
                }
            });

            // Función para imprimir el ticket estilo RMS
            function printTicket() {
                // Construye el contenido del ticket usando los datos del DOM
                let area = document.getElementById('printable-area');
                // Puedes personalizar el contenido del ticket aquí si quieres menos información
                let ticketHTML = `
                <div class="rms-ticket">
                    <div class="title">REPORTE Z</div>
                    <div class="subtitle">Resumen de Cierre de Turno</div>
                    <div class="small">Generado: {{ now()->format('d/m/Y H:i') }}</div>
                    <div class="small">Punto de Venta: {{ $puntoVentaNombre ?? '001' }}</div>
                    <div class="section">
                        <div class="row"><span>Cajero:</span><span>{{ auth()->user()->name ?? '' }}</span></div>
                        <div class="row"><span>Rol:</span><span>{{ auth()->user()->role ?? 'Cajero' }}</span></div>
                        <div class="row"><span>Fecha Apertura:</span><span>{{ $apertura->created_at->format('d/m/Y H:i') }}</span></div>
                        <div class="row"><span>Fecha Cierre:</span><span>{{ $cierre->created_at->format('d/m/Y H:i') }}</span></div>
                    </div>
                    <div class="section">
                        <div class="row"><span>Efectivo Inicial:</span><span>L {{ number_format($apertura->efectivo_inicial, 2) }}</span></div>
                        <div class="row"><span>Efectivo Final:</span><span>L {{ number_format($cierre->efectivo_final, 2) }}</span></div>
                    </div>
                    <div class="section">
                        <div class="row"><span>Ventas:</span><span>L {{ number_format($ventas, 2) }}</span></div>
                        <div class="row"><span>Recargas:</span><span>L {{ number_format($recargas, 2) }}</span></div>
                        <div class="row"><span>Servicios:</span><span>L {{ number_format($servicios, 2) }}</span></div>
                        <div class="row"><span>Impresiones:</span><span>L {{ number_format($impresiones, 2) }}</span></div>
                        <div class="row"><span>Depósitos:</span><span>L {{ number_format($depositos, 2) }}</span></div>
                        <div class="row"><span>Comisiones:</span><span>L {{ number_format($ingresos_comisiones, 2) }}</span></div>
                        <div class="row small">Remesas: L {{ number_format($comision_remesas ?? 0, 2) }}</div>
                        <div class="row small">Retiros: L {{ number_format($comision_retiros ?? 0, 2) }}</div>
                        <div class="row small">Depósitos: L {{ number_format($comision_depositos ?? 0, 2) }}</div>
                        <div class="row small">Servicios: L {{ number_format($comision_servicios ?? 0, 2) }}</div>
                        <div class="total row"><span>TOTAL INGRESOS:</span><span>L {{ number_format($ingresos, 2) }}</span></div>
                    </div>
                    <div class="section">
                        <div class="row"><span>Retiros:</span><span>L {{ number_format($retiros, 2) }}</span></div>
                        <div class="row"><span>Remesas:</span><span>L {{ number_format($remesas, 2) }}</span></div>
                        <div class="total row"><span>TOTAL EGRESOS:</span><span>L {{ number_format($egresos, 2) }}</span></div>
                    </div>
                    <div class="section">
                        <div class="row"><span>Total Esperado:</span><span>L {{ number_format($esperado, 2) }}</span></div>
                        <div class="row"><span>Efectivo Reportado:</span><span>L {{ number_format($cierre->efectivo_final, 2) }}</span></div>
                        <div class="diff">
                            @if ($diferencia > 0)
                                <span style="color:green;">Sobrante: L {{ number_format($diferencia, 2) }}</span>
                            @elseif ($diferencia < 0)
                                <span style="color:red;">Faltante: L {{ number_format(abs($diferencia), 2) }}</span>
                            @else
                                <span style="color:blue;">Sin diferencia</span>
                            @endif
                        </div>
                    </div>
                    <div class="section small" style="text-align:center;">
                        <div>Gracias por su trabajo</div>
                        
                    </div>
                </div>
                <script>
                    window.onload = function() { window.print(); setTimeout(function(){ window.close(); }, 500); }
                <\/script>
                `;

                let printWindow = window.open('', '', 'width=400,height=600');
                printWindow.document.write('<html><head><title>Ticket de Cierre</title>');
                printWindow.document.write('<style>' +
                    document.querySelector('style').innerHTML +
                    '</style></head><body>');
                printWindow.document.write(ticketHTML);
                printWindow.document.write('</body></html>');
                printWindow.document.close();
            }
        </script>
    </div>
</body>

</html>
