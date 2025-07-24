@extends('layouts.admin')

@section('title', 'Productos Más Vendidos')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-6 bg-white rounded-lg shadow">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">📊 Productos Más Vendidos</h1>

        <table class="w-full table-auto border text-sm">
            <thead class="bg-indigo-100 text-left">
                <tr>
                    <th class="p-3">Código</th>
                    <th class="p-3">Nombre</th>
                    <th class="p-3">Total Vendidos</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reporte as $r)
                    <tr class="border-b hover:bg-indigo-50">
                        <td class="p-3">{{ $r->producto->codigo }}</td>
                        <td class="p-3">{{ $r->producto->nombre }}</td>
                        <td class="p-3 font-bold text-indigo-700">{{ $r->total_vendidos }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
