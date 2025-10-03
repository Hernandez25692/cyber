<div class="mb-12">
    {{-- TARJETA DE RESUMEN RECARGAS --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-yellow-100 border border-yellow-200 p-5 rounded-xl shadow-sm flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-yellow-800">Recargas realizadas</h2>
                <p class="text-sm text-yellow-600 mt-1">Cantidad total</p>
            </div>
            <div class="text-3xl font-bold text-yellow-700">
                {{ $recargas->count() }}
            </div>
        </div>
        <div class="bg-yellow-100 border border-yellow-200 p-5 rounded-xl shadow-sm flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-yellow-800">Total vendido</h2>
                <p class="text-sm text-yellow-600 mt-1">Precio de venta total</p>
            </div>
            <div class="text-3xl font-bold text-yellow-700">
                L {{ number_format($recargas->sum(fn($r) => $r->precio_venta ?? $r->paquete->precio ?? 0), 2) }}
            </div>
        </div>
        <div class="bg-yellow-100 border border-yellow-200 p-5 rounded-xl shadow-sm flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-yellow-800">Total comprado</h2>
                <p class="text-sm text-yellow-600 mt-1">Precio de compra total</p>
            </div>
            <div class="text-3xl font-bold text-yellow-700">
                L {{ number_format($recargas->sum(fn($r) => $r->precio_compra ?? 0), 2) }}
            </div>
        </div>
        <div class="bg-yellow-100 border border-yellow-200 p-5 rounded-xl shadow-sm flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-yellow-800">Comisión total</h2>
                <p class="text-sm text-yellow-600 mt-1">Ganancia obtenida</p>
            </div>
            <div class="text-3xl font-bold text-yellow-700">
                L {{ number_format($recargas->sum(fn($r) => ($r->precio_venta ?? $r->paquete->precio ?? 0) - ($r->precio_compra ?? 0)), 2) }}
            </div>
        </div>
    </div>

    {{-- TABLA DETALLE RECARGAS --}}
    <div class="bg-white shadow rounded-xl overflow-x-auto border border-yellow-200">
        <table class="min-w-full divide-y divide-yellow-300">
            <thead class="bg-yellow-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-yellow-600 uppercase">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-yellow-600 uppercase">Cajero</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-yellow-600 uppercase">Proveedor</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-yellow-600 uppercase">Precio compra</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-yellow-600 uppercase">Precio venta</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-yellow-600 uppercase">Comisión</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-yellow-600 uppercase">Fecha</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-yellow-100">
                @forelse ($recargas as $recarga)
                    <tr>
                        <td class="px-4 py-3">{{ $recarga->id }}</td>
                        <td class="px-4 py-3">{{ $recarga->usuario->name ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $recarga->paquete->proveedor->nombre ?? '—' }}</td>
                        <td class="px-4 py-3 text-yellow-800 font-semibold">L
                            {{ number_format($recarga->precio_compra ?? 0, 2) }}</td>
                        <td class="px-4 py-3 text-yellow-800 font-semibold">L
                            {{ number_format($recarga->precio_venta ?? $recarga->paquete->precio ?? 0, 2) }}</td>
                        <td class="px-4 py-3 text-green-700 font-semibold">L
                            {{ number_format(($recarga->precio_venta ?? $recarga->paquete->precio ?? 0) - ($recarga->precio_compra ?? 0), 2) }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $recarga->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-4 text-center text-sm text-gray-500">No hay recargas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
