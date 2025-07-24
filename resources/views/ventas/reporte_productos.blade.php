@extends('layouts.admin')

@section('title', 'Productos Más Vendidos')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/@sap-theming/theming-base-content@11.1.29/content/Base/baseLib/sap_fiori_3/css_variables.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@sap-theming/theming-base-content@11.1.29/content/Base/baseLib/sap_fiori_3/css_variables_custom.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="max-w-4xl mx-auto px-6 py-8 rounded-lg shadow" style="background: var(--sapBackgroundColor); color: var(--sapTextColor);">
        <h1 class="text-2xl font-bold mb-6" style="color: var(--sapTitleColor);">
            <span style="vertical-align: middle;">📊</span> Productos Más Vendidos
        </h1>

        {{-- Métrica principal --}}
        <div class="flex items-center mb-8 gap-8">
            <div class="flex-1 p-6 rounded-lg shadow" style="background: var(--sapTile_Background);">
                <div class="text-lg font-semibold" style="color: var(--sapPositiveColor);">
                    Total Productos Vendidos
                </div>
                <div class="text-3xl font-bold mt-2" style="color: var(--sapAccentColor1);">
                    {{ $reporte->sum('total_vendidos') }}
                </div>
            </div>
            <div class="flex-1 p-6 rounded-lg shadow" style="background: var(--sapTile_Background);">
                <div class="text-lg font-semibold" style="color: var(--sapHighlightColor);">
                    Productos Analizados
                </div>
                <div class="text-3xl font-bold mt-2" style="color: var(--sapAccentColor2);">
                    {{ $reporte->count() }}
                </div>
            </div>
        </div>

        {{-- Gráfico dinámico --}}
        <div class="mb-10 bg-white rounded-lg p-4 shadow" style="background: var(--sapTile_Background);">
            <canvas id="productosChart" height="120"></canvas>
        </div>

        <div class="overflow-x-auto rounded-lg shadow" style="background: var(--sapList_Background);">
            <table class="min-w-full text-sm" style="border-collapse: separate; border-spacing: 0;">
            <thead>
                <tr style="background: var(--sapList_HeaderBackground); color: var(--sapList_HeaderTextColor);">
                <th class="px-5 py-3 text-left font-semibold border-b" style="border-color: var(--sapList_BorderColor);">Código</th>
                <th class="px-5 py-3 text-left font-semibold border-b" style="border-color: var(--sapList_BorderColor);">Nombre</th>
                <th class="px-5 py-3 text-left font-semibold border-b" style="border-color: var(--sapList_BorderColor);">Total Vendidos</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reporte as $r)
                <tr class="transition-colors duration-150 hover:bg-[var(--sapList_SelectionBackground)]" style="border-bottom: 1px solid var(--sapList_BorderColor);">
                    <td class="px-5 py-3" style="color: var(--sapTextColor);">{{ $r->producto->codigo }}</td>
                    <td class="px-5 py-3" style="color: var(--sapTextColor);">{{ $r->producto->nombre }}</td>
                    <td class="px-5 py-3 font-bold" style="color: var(--sapAccentColor1);">{{ $r->total_vendidos }}</td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('productosChart').getContext('2d');
        const productosData = {
            labels: {!! $reporte->pluck('producto.nombre')->map(fn($n) => addslashes($n)) !!},
            datasets: [{
                label: 'Total Vendidos',
                data: {!! $reporte->pluck('total_vendidos') !!},
                backgroundColor: 'rgba(0, 120, 212, 0.6)',
                borderColor: 'rgba(0, 120, 212, 1)',
                borderWidth: 2,
                borderRadius: 6,
                maxBarThickness: 40
            }]
        };
        new Chart(ctx, {
            type: 'bar',
            data: productosData,
            options: {
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        ticks: { color: getComputedStyle(document.body).getPropertyValue('--sapTextColor') }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { color: getComputedStyle(document.body).getPropertyValue('--sapTextColor') }
                    }
                }
            }
        });
    </script>
@endsection
