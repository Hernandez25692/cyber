<div class="mb-12">
    {{-- TARJETA DE RESUMEN RETIROS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
        <div class="bg-red-100 border border-red-200 p-5 rounded-xl shadow-sm flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-red-800">Retiros realizados</h2>
                <p class="text-sm text-red-600 mt-1">Cantidad total</p>
            </div>
            <div class="text-3xl font-bold text-red-700">
                {{ $retiros->count() }}
            </div>
        </div>

        <div class="bg-red-100 border border-red-200 p-5 rounded-xl shadow-sm flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-red-800">Monto total retirado</h2>
                <p class="text-sm text-red-600 mt-1">Suma total</p>
            </div>
            <div class="text-3xl font-bold text-red-700">
                L {{ number_format($retiros->sum('monto'), 2) }}
            </div>
        </div>
        <div class="bg-red-100 border border-red-200 p-5 rounded-xl shadow-sm flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-red-800">Ganancia Total</h2>
                <p class="text-sm text-red-600 mt-1">Suma total de comisiones</p>
            </div>
            <div class="text-3xl font-bold text-red-700">
                L {{ number_format($retiros->sum('comision'), 2) }}
            </div>
        </div>
    </div>

    {{-- TABLA DETALLE RETIROS --}}
    <div class="bg-white shadow rounded-xl overflow-x-auto border border-red-200">
        <table class="min-w-full divide-y divide-red-300">
            <thead class="bg-red-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-red-600 uppercase">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-red-600 uppercase">Cajero</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-red-600 uppercase">Banco</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-red-600 uppercase">Monto</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-red-600 uppercase">Comisión</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-red-600 uppercase">Referencia</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-red-600 uppercase">Fecha</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-red-100">
                @forelse ($retiros as $retiro)
                    <tr>
                        <td class="px-4 py-3">{{ $retiro->id }}</td>
                        <td class="px-4 py-3">{{ $retiro->usuario->name ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $retiro->banco->nombre ?? '—' }}</td>
                        <td class="px-4 py-3 font-semibold text-red-800">L {{ number_format($retiro->monto, 2) }}</td>
                        <td class="px-4 py-3 text-red-600">L {{ number_format($retiro->comision, 2) }}</td>
                        <td class="px-4 py-3">{{ $retiro->referencia ?? '—' }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $retiro->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-4 text-center text-sm text-gray-500">No hay retiros.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
