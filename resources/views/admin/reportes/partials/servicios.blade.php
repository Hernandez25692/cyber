<div class="mb-12">
    {{-- TARJETA DE RESUMEN SERVICIOS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
        <div class="bg-green-100 border border-green-200 p-5 rounded-xl shadow-sm flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-green-800">Servicios realizados</h2>
                <p class="text-sm text-green-600 mt-1">Cantidad total</p>
            </div>
            <div class="text-3xl font-bold text-green-700">
                {{ $servicios->count() }}
            </div>
        </div>

        <div class="bg-green-100 border border-green-200 p-5 rounded-xl shadow-sm flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-green-800">Ganancia total</h2>
                <p class="text-sm text-green-600 mt-1">Suma de comisiones</p>
            </div>
            <div class="text-3xl font-bold text-green-700">
                L {{ number_format($servicios->sum('comision'), 2) }}
            </div>
        </div>
    </div>

    {{-- TABLA DETALLE SERVICIOS --}}
    <div class="bg-white shadow rounded-xl overflow-x-auto border border-green-200">
        <table class="min-w-full divide-y divide-green-300">
            <thead class="bg-green-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-green-600 uppercase">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-green-600 uppercase">Tipo</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-green-600 uppercase">Cajero</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-green-600 uppercase">Banco</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-green-600 uppercase">Comisión</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-green-600 uppercase">Fecha</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-green-100">
                @forelse ($servicios as $servicio)
                    <tr>
                        <td class="px-4 py-3">{{ $servicio->id }}</td>
                        <td class="px-4 py-3">{{ $servicio->tipoServicio->nombre ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $servicio->usuario->name ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $servicio->banco->nombre ?? '—' }}</td>
                        <td class="px-4 py-3 text-green-800 font-semibold">L {{ number_format($servicio->comision, 2) }}
                        </td>
                        <td class="px-4 py-3 text-gray-500">{{ $servicio->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-4 text-center text-sm text-gray-500">No hay servicios
                            registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
