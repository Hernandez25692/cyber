<div class="mb-12">
    {{-- TARJETA DE RESUMEN IMPRESIONES --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="bg-pink-100 border border-pink-200 p-5 rounded-xl shadow-sm flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-pink-800">Impresiones realizadas</h2>
                <p class="text-sm text-pink-600 mt-1">Cantidad total</p>
            </div>
            <div class="text-3xl font-bold text-pink-700">
                {{ $impresiones->count() }}
            </div>
        </div>

        <div class="bg-pink-100 border border-pink-200 p-5 rounded-xl shadow-sm flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-pink-800">Total recaudado</h2>
                <p class="text-sm text-pink-600 mt-1">Suma de ingresos por impresión</p>
            </div>
            <div class="text-3xl font-bold text-pink-700">
                L {{ number_format($impresiones->sum('monto'), 2) }}
            </div>
        </div>
    </div>

    {{-- TABLA DETALLE IMPRESIONES --}}
    <div class="bg-white shadow rounded-xl overflow-x-auto border border-pink-200">
        <table class="min-w-full divide-y divide-pink-300">
            <thead class="bg-pink-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-pink-600 uppercase">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-pink-600 uppercase">Cajero</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-pink-600 uppercase">Cliente</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-pink-600 uppercase">Monto</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-pink-600 uppercase">Fecha</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-pink-100">
                @forelse ($impresiones as $impresion)
                    <tr>
                        <td class="px-4 py-3">{{ $impresion->id }}</td>
                        <td class="px-4 py-3">{{ $impresion->usuario->name ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $impresion->cliente ?? '—' }}</td>
                        <td class="px-4 py-3 text-pink-800 font-semibold">L {{ number_format($impresion->monto, 2) }}
                        </td>
                        <td class="px-4 py-3 text-gray-500">{{ $impresion->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-4 text-center text-sm text-gray-500">No hay impresiones
                            registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
