<div class="mb-12">
    {{-- TARJETA DE RESUMEN REMESAS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
        <div class="bg-purple-100 border border-purple-200 p-5 rounded-xl shadow-sm flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-purple-800">Remesas realizadas</h2>
                <p class="text-sm text-purple-600 mt-1">Cantidad total</p>
            </div>
            <div class="text-3xl font-bold text-purple-700">
                {{ $remesas->count() }}
            </div>
        </div>

        <div class="bg-purple-100 border border-purple-200 p-5 rounded-xl shadow-sm flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-purple-800">Monto total </h2>
                <p class="text-sm text-purple-600 mt-1">Suma de todas las remesas</p>
            </div>
            <div class="text-3xl font-bold text-purple-700">
                L {{ number_format($remesas->sum('monto'), 2) }}
            </div>
        </div>

        <div class="bg-purple-100 border border-purple-200 p-5 rounded-xl shadow-sm flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-purple-800">Ganancia Total</h2>
                <p class="text-sm text-purple-600 mt-1">Suma de todas las comisiones</p>
            </div>
            <div class="text-3xl font-bold text-purple-700">
                L {{ number_format($remesas->sum('comision'), 2) }}
            </div>
        </div>
    </div>

    {{-- TABLA DETALLE REMESAS --}}
    <div class="bg-white shadow rounded-xl overflow-x-auto border border-purple-200">
        <table class="min-w-full divide-y divide-purple-300">
            <thead class="bg-purple-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-purple-600 uppercase tracking-wider">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-purple-600 uppercase tracking-wider">Cajero
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-purple-600 uppercase tracking-wider">Banco
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-purple-600 uppercase tracking-wider">Monto
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-purple-600 uppercase tracking-wider">Comisión</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-purple-600 uppercase tracking-wider">
                        Referencia</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-purple-600 uppercase tracking-wider">Fecha
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-purple-100">
                @forelse ($remesas as $remesa)
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{ $remesa->id }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $remesa->usuario->name ?? '—' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $remesa->banco->nombre ?? '—' }}</td>
                        <td class="px-4 py-3 text-sm text-purple-800 font-semibold">
                            L {{ number_format($remesa->monto, 2) }}
                        </td>
                        <td class="px-4 py-3 text-sm text-purple-600">
                            L {{ number_format($remesa->comision, 2) }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $remesa->referencia ?? '—' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">
                            {{ $remesa->created_at->format('d/m/Y H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-4 text-center text-sm text-gray-500">No se encontraron remesas
                            en el rango seleccionado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
