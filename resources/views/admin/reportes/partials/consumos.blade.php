{{-- resources/views/admin/reportes/partials/consumos.blade.php --}}
@php
    // Espera: $consumos (Collection|LengthAwarePaginator), $total_consumos (float|int), $filtros (array), $users (Collection)
@endphp

<div class="bg-white shadow rounded-2xl border p-6">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center justify-center rounded-full bg-amber-100 p-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path
                        d="M10 2a4 4 0 00-4 4v2H5a2 2 0 00-2 2v4a2 2 0 002 2h1v1a3 3 0 003 3h2a3 3 0 003-3v-1h1a2 2 0 002-2v-4a2 2 0 00-2-2h-1V6a4 4 0 00-4-4z" />
                </svg>
            </span>
            <div>
                <h2 class="text-xl font-bold text-gray-800">Consumos (control interno)</h2>
                <p class="text-gray-500 text-sm">
                    Rango: {{ $filtros['desde'] ?? '-' }} a {{ $filtros['hasta'] ?? '-' }}
                    @if (!empty($filtros['user_id']))
                        — Cajero: {{ optional($users->firstWhere('id', $filtros['user_id']))?->name }}
                    @endif
                </p>
            </div>
        </div>
        <div class="text-right">
            <div class="text-xs text-gray-500">Total consumos</div>
            <div class="text-2xl font-extrabold text-amber-600">L {{ number_format($total_consumos ?? 0, 2) }}</div>
        </div>
    </div>

    <div class="overflow-auto border rounded-xl">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="bg-amber-50 text-left">
                    <th class="py-2 px-3">Fecha/Hora</th>
                    <th class="py-2 px-3">Cajero</th>
                    <th class="py-2 px-3">Código</th>
                    <th class="py-2 px-3">Producto/Nombre</th>
                    <th class="py-2 px-3 text-right">Cant.</th>
                    <th class="py-2 px-3 text-right">Costo unit. (L)</th>
                    <th class="py-2 px-3 text-right">Total (L)</th>
                    <th class="py-2 px-3">Observación</th>
                </tr>
            </thead>
            <tbody>
                @forelse($consumos as $c)
                    <tr class="border-t">
                        <td class="py-2 px-3">
                            {{ optional($c->created_at)->format('d/m/Y H:i') }}
                        </td>
                        <td class="py-2 px-3">
                            {{-- intentamos usuario->name, si no user->name --}}
                            {{ $c->usuario->name ?? ($c->user->name ?? '—') }}
                        </td>
                        <td class="py-2 px-3 font-mono text-amber-700">
                            {{ $c->codigo_barra ?? ($c->producto->codigo ?? '—') }}
                        </td>
                        <td class="py-2 px-3">
                            <div class="flex items-center gap-2">
                                <span class="font-semibold">
                                    {{ $c->producto->nombre ?? ($c->nombre ?? '—') }}
                                </span>
                                @if (!empty($c->producto_id))
                                    <span
                                        class="text-[10px] px-2 py-0.5 rounded-full bg-green-100 text-green-700 border border-green-200">
                                        vinculado
                                    </span>
                                @else
                                    <span
                                        class="text-[10px] px-2 py-0.5 rounded-full bg-gray-100 text-gray-600 border border-gray-200">
                                        manual
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="py-2 px-3 text-right">
                            {{ number_format((float) $c->cantidad, 2) }}
                        </td>
                        <td class="py-2 px-3 text-right">
                            {{ number_format((float) $c->costo_unitario, 2) }}
                        </td>
                        <td class="py-2 px-3 text-right font-semibold text-amber-700">
                            {{ number_format((float) $c->total_costo, 2) }}
                        </td>
                        <td class="py-2 px-3">
                            {{ $c->observacion ?? '—' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="py-4 px-3 text-center text-gray-500">
                            Sin consumos registrados…
                        </td>
                    </tr>
                @endforelse
            </tbody>

            @if (($consumos->count() ?? 0) > 0)
                <tfoot>
                    <tr>
                        <td colspan="6" class="py-2 px-3 text-right font-semibold">Total:</td>
                        <td class="py-2 px-3 text-right font-bold">L {{ number_format($total_consumos ?? 0, 2) }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            @endif
        </table>
    </div>

    @if (method_exists($consumos, 'links'))
        <div class="mt-4">
            {{ $consumos->appends(request()->query())->links() }}
        </div>
    @endif
</div>
