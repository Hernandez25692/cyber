{{-- resources/views/admin/reportes/partials/salidas.blade.php --}}
@php
    // Variables esperadas: $salidas (Collection), $total_salidas (float), $filtros (array), $users (Collection)
@endphp

<div class="bg-white shadow rounded-2xl border p-6">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center justify-center rounded-full bg-red-100 p-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path
                        d="M5 4a3 3 0 013-3h4a3 3 0 013 3v3h1a2 2 0 012 2v4a2 2 0 01-2 2h-1v2a3 3 0 01-3 3H8a3 3 0 01-3-3v-2H4a2 2 0 01-2-2V9a2 2 0 012-2h1V4z" />
                </svg>
            </span>
            <div>
                <h2 class="text-xl font-bold text-gray-800">Salidas de efectivo</h2>
                <p class="text-gray-500 text-sm">
                    Rango: {{ $filtros['desde'] ?? '-' }} a {{ $filtros['hasta'] ?? '-' }}
                    @if (!empty($filtros['user_id']))
                        — Cajero: {{ optional($users->firstWhere('id', $filtros['user_id']))?->name }}
                    @endif
                </p>
            </div>
        </div>
        <div class="text-right">
            <div class="text-xs text-gray-500">Total salidas</div>
            <div class="text-2xl font-extrabold text-red-600">L {{ number_format($total_salidas ?? 0, 2) }}</div>
        </div>
    </div>

    <div class="overflow-auto border rounded-xl">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="bg-red-50 text-left">
                    <th class="py-2 px-3">Fecha/Hora</th>
                    <th class="py-2 px-3">Cajero</th>
                    <th class="py-2 px-3">Motivo</th>
                    <th class="py-2 px-3">Observación</th>
                    <th class="py-2 px-3 text-right">Monto (L)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($salidas as $s)
                    <tr class="border-t">
                        <td class="py-2 px-3">
                            {{ optional($s->fecha_hora)->format('d/m/Y H:i') ?? $s->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="py-2 px-3">{{ $s->usuario?->name }}</td>
                        <td class="py-2 px-3">{{ $s->motivo }}</td>
                        <td class="py-2 px-3">{{ $s->observacion }}</td>
                        <td class="py-2 px-3 text-right">{{ number_format($s->monto, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-4 px-3 text-center text-gray-500">Sin salidas registradas…</td>
                    </tr>
                @endforelse
            </tbody>
            @if (($salidas->count() ?? 0) > 0)
                <tfoot>
                    <tr>
                        <td colspan="4" class="py-2 px-3 text-right font-semibold">Total:</td>
                        <td class="py-2 px-3 text-right font-bold">L {{ number_format($total_salidas ?? 0, 2) }}</td>
                    </tr>
                </tfoot>
            @endif
        </table>
    </div>
</div>
