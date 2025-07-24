@extends('layouts.admin')

@section('title', 'Sugerencia de Pedido por Bajo Stock')

@section('content')
    <style>
        /* SAP Fiori-inspired styles */
        .sap-card {
            background: #f7f7f7;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            padding: 2rem 2.5rem;
            margin-bottom: 2rem;
        }
        .sap-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        }
        .sap-table th {
            background: #e5edf5;
            color: #0a6ed1;
            font-weight: 600;
            padding: 1rem 0.75rem;
            border-bottom: 2px solid #b8c9d9;
            text-align: left;
        }
        .sap-table td {
            padding: 0.75rem;
            border-bottom: 1px solid #e5edf5;
            font-size: 1rem;
        }
        .sap-table tr:last-child td {
            border-bottom: none;
        }
        .sap-table tr:hover {
            background: #f3f9fb;
        }
        .sap-badge {
            display: inline-block;
            padding: 0.25em 0.75em;
            border-radius: 1em;
            font-size: 0.95em;
            font-weight: 600;
        }
        .sap-badge-red {
            background: #fad2d2;
            color: #bb0000;
        }
        .sap-badge-blue {
            background: #d2e4fa;
            color: #0a6ed1;
        }
        .sap-badge-green {
            background: #d2fad2;
            color: #107e3e;
        }
        .sap-header {
            font-size: 2rem;
            font-weight: 700;
            color: #0a6ed1;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .sap-success {
            background: #d2fad2;
            color: #107e3e;
            padding: 1rem 1.5rem;
            border-radius: 6px;
            font-weight: 500;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        @media (max-width: 800px) {
            .sap-card { padding: 1rem; }
            .sap-header { font-size: 1.2rem; }
            .sap-table th, .sap-table td { padding: 0.5rem; font-size: 0.95rem; }
        }
    </style>
    <div class="max-w-7xl mx-auto px-2 py-6">
        <div class="sap-card">
            <div class="sap-header">
                <svg width="32" height="32" fill="none" viewBox="0 0 24 24"><rect width="24" height="24" rx="6" fill="#0a6ed1" opacity="0.08"/><path d="M7 7h10v10H7V7zm2 2v6h6V9H9z" fill="#0a6ed1"/></svg>
                Sugerencias de Pedido (Stock &lt; 10)
            </div>

            @if ($productos->isEmpty())
                <div class="sap-success">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" fill="#107e3e" opacity="0.15"/><path d="M8 12.5l2.5 2.5L16 9" stroke="#107e3e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Todos los productos tienen suficiente stock.
                </div>
            @else
                <div class="overflow-auto rounded-lg">
                    <table class="sap-table">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Categoría</th>
                                <th class="text-center">Stock Actual</th>
                                <th class="text-center">Sugerido a Pedir</th>
                                <th class="text-center">Última Modificación</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productos as $producto)
                                <tr>
                                    <td>{{ $producto->codigo }}</td>
                                    <td class="font-semibold">{{ $producto->nombre }}</td>
                                    <td>{{ $producto->categoria ?? '—' }}</td>
                                    <td class="text-center">
                                        <span class="sap-badge sap-badge-red">{{ $producto->stock }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="sap-badge sap-badge-blue">{{ max(15 - $producto->stock, 10) }}</span>
                                    </td>
                                    <td class="text-center text-gray-500">
                                        {{ $producto->updated_at ? $producto->updated_at->format('d/m/Y H:i') : '—' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
