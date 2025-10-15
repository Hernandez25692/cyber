{{-- resources/views/admin/reportes/partials/depositos.blade.php --}}
@php
    // Calcula totales rápido (si no vienen del controlador)
    $totalComision = $depositos->sum('comision');
    $totalMonto = $depositos->sum('monto') + $totalComision;
    $totalNeto = $totalMonto - $totalComision;
@endphp

<div class="flex items-center gap-3 mb-4">
    <span class="inline-flex items-center justify-center rounded-full bg-emerald-100 p-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 16V8m0 0l-3 3m3-3l3 3M5 19h14a2 2 0 002-2V9.414a2 2 0 00-.586-1.414l-5.414-5.414A2 2 0 0013.586 2H5a2 2 0 00-2 2v13a2 2 0 002 2z" />
        </svg>
    </span>
    <h2 class="text-2xl font-bold text-emerald-700">Depósitos</h2>
</div>

{{-- KPIs --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white border rounded-xl p-4 shadow-sm">
        <div class="text-sm text-gray-500">Total Depósitos</div>
        <div class="text-2xl font-bold text-emerald-700">L. {{ number_format($totalMonto, 2) }}</div>
    </div>
    <div class="bg-white border rounded-xl p-4 shadow-sm">
        <div class="text-sm text-gray-500">Total Comisiones</div>
        <div class="text-2xl font-bold text-rose-700">L. {{ number_format($totalComision, 2) }}</div>
    </div>
    <div class="bg-white border rounded-xl p-4 shadow-sm">
        <div class="text-sm text-gray-500">Total Neto</div>
        <div class="text-2xl font-bold text-indigo-700">L. {{ number_format($totalNeto, 2) }}</div>
    </div>
</div>

{{-- Tabla --}}
<div class="overflow-x-auto border rounded-2xl bg-white shadow">
    <table class="min-w-full text-sm">
        <thead class="bg-emerald-100 text-emerald-900">
            <tr>
                <th class="px-3 py-2 text-left">Fecha</th>
                <th class="px-3 py-2 text-left">Cajero</th>
                <th class="px-3 py-2 text-left">Banco</th>
                <th class="px-3 py-2 text-right">Monto</th>
                <th class="px-3 py-2 text-right">Comisión</th>
                <th class="px-3 py-2 text-right">Neto</th>
                <th class="px-3 py-2 text-left">Referencia</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($depositos as $dep)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-3 py-2">{{ $dep->created_at->format('Y-m-d H:i') }}</td>
                    <td class="px-3 py-2">{{ optional($dep->usuario)->name ?? 'N/D' }}</td>
                    <td class="px-3 py-2">{{ optional($dep->banco)->nombre ?? 'N/D' }}</td>
                    <td class="px-3 py-2 text-right">L. {{ number_format($dep->monto, 2) }}</td>
                    <td class="px-3 py-2 text-right">L. {{ number_format($dep->comision, 2) }}</td>
                    <td class="px-3 py-2 text-right">L. {{ number_format($dep->monto - $dep->comision, 2) }}</td>
                    <td class="px-3 py-2">{{ $dep->referencia ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-3 py-6 text-center text-gray-500">
                        No hay depósitos para los filtros seleccionados.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
