<div class="mb-12">
    {{-- TARJETA DE RESUMEN PRODUCTOS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="bg-blue-100 border border-blue-200 p-5 rounded-xl shadow-sm flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-blue-800">Total Transacciones</h2>
                <p class="text-sm text-blue-600 mt-1">Cantidad total</p>
            </div>
            <div class="text-3xl font-bold text-blue-700">
                {{ $productos->count() }}
            </div>
        </div>

        <div class="bg-blue-100 border border-blue-200 p-5 rounded-xl shadow-sm flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-blue-800">Utilidad total</h2>
                <p class="text-sm text-blue-600 mt-1">Venta - Costo</p>
            </div>
            <div class="text-3xl font-bold text-blue-700">
                L
                {{ number_format($productos->sum(fn($p) => ($p->precio_unitario - $p->producto->precio_compra) * $p->cantidad), 2) }}
            </div>
        </div>
    </div>

    {{-- TABLA DETALLE PRODUCTOS --}}
    <div class="bg-white shadow rounded-xl overflow-x-auto border border-blue-200">
        <table class="min-w-full divide-y divide-blue-300">
            <thead class="bg-blue-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-blue-600 uppercase">ID</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-blue-600 uppercase">Producto</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-blue-600 uppercase">Precio Venta</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-blue-600 uppercase">Costo</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-blue-600 uppercase">Cantidad</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-blue-600 uppercase">Subtotal</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-blue-600 uppercase">Fecha</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-blue-600 uppercase">Cajero</th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-blue-100">
            @forelse ($productos as $detalle)
                <tr>
                <td class="px-4 py-3">{{ $detalle->id }}</td>
                <td class="px-4 py-3">{{ $detalle->producto->nombre ?? '—' }}</td>
                <td class="px-4 py-3">L {{ number_format($detalle->precio_unitario, 2) }}</td>
                <td class="px-4 py-3">L {{ number_format($detalle->producto->precio_compra ?? 0, 2) }}</td>
                <td class="px-4 py-3">{{ $detalle->cantidad }}</td>
                <td class="px-4 py-3 font-semibold text-blue-800">L {{ number_format($detalle->subtotal, 2) }}
                </td>
                <td class="px-4 py-3 text-gray-500">{{ $detalle->created_at->format('d/m/Y H:i') }}</td>
                <td class="px-4 py-3">
                    {{ $detalle->venta->user->name ?? '—' }}
                </td>
                </tr>
            @empty
                <tr>
                <td colspan="8" class="px-4 py-4 text-center text-sm text-gray-500">No hay ventas de
                    productos.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
