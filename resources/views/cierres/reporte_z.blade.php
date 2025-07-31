<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte Z</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CSS CDN (opcional, si usas Tailwind) -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded-xl shadow">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">📊 Reporte Z - Resumen de Cierre</h2>

        <div class="mb-4">
            <p><strong>Fecha de apertura:</strong> {{ $apertura->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Efectivo inicial:</strong> L {{ number_format($apertura->efectivo_inicial, 2) }}</p>
        </div>

        <div class="grid grid-cols-2 gap-4 text-sm text-gray-700 mb-6">
            <div class="bg-green-100 p-4 rounded-lg">
                <h3 class="font-bold text-green-800 mb-2">🟢 Ingresos</h3>
                <p>Ventas: L {{ number_format($ventas, 2) }}</p>
                <p>Recargas: L {{ number_format($recargas, 2) }}</p>
                <p>Servicios: L {{ number_format($servicios, 2) }}</p>
                <p>Impresiones: L {{ number_format($impresiones, 2) }}</p>
                <p class="mt-2 font-bold">Comisiones (Remesas, Retiros, Servicios): L
                    {{ number_format($ingresos_comisiones, 2) }}</p>
                <p class="font-bold">Total Ingresos (con comisiones): L {{ number_format($ingresos, 2) }}</p>

            </div>
            <div class="bg-red-100 p-4 rounded-lg">
                <h3 class="font-bold text-red-800 mb-2">🔴 Egresos</h3>
                <p>Retiros: L {{ number_format($retiros, 2) }}</p>
                <p>Remesas: L {{ number_format($remesas, 2) }}</p>
                <p class="mt-2 font-bold">Total Egresos: L {{ number_format($egresos, 2) }}</p>
            </div>
        </div>

        <div class="bg-gray-100 p-4 rounded-lg mb-6">
            <p><strong>Total esperado en efectivo:</strong> L {{ number_format($esperado, 2) }}</p>
            <p><strong>Efectivo ingresado:</strong> L {{ number_format($cierre->efectivo_final, 2) }}</p>

            <p class="mt-2">
                <strong>Diferencia:</strong>
                @if ($cierre->diferencia > 0)
                    <span class="text-green-700 font-bold">Sobrante L
                        {{ number_format($cierre->diferencia, 2) }}</span>
                @elseif ($cierre->diferencia < 0)
                    <span class="text-red-700 font-bold">Faltante L
                        {{ number_format(abs($cierre->diferencia), 2) }}</span>
                @else
                    <span class="text-blue-700 font-bold">Sin diferencia</span>
                @endif
            </p>
        </div>

        @if ($cierre->diferencia < 0)
            <div class="bg-red-100 border border-red-200 p-4 rounded mb-4">
                <p class="text-red-700 font-semibold">❌ No se puede cerrar turno con faltante. Corrige los valores
                    ingresados.</p>
            </div>
            <a href="{{ route('cierres.create') }}"
                class="inline-block px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                Corregir datos de cierre
            </a>
        @else
            <button onclick="document.getElementById('confirmModal').classList.remove('hidden')"
                class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                ✅ Cerrar Turno
            </button>
        @endif
    </div>

    {{-- Modal de confirmación --}}
    <div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
            <h3 class="text-lg font-bold mb-4">¿Estás seguro de cerrar el turno?</h3>
            <p class="mb-4">No podrás modificar los datos después de confirmar.</p>
            <div class="flex justify-end gap-4">
                <button onclick="document.getElementById('confirmModal').classList.add('hidden')"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancelar</button>
                <form method="POST" action="{{ route('cierres.finalizar', $cierre->id) }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        Confirmar Cierre
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
