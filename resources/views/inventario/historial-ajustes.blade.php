@extends('layouts.admin')

@section('title', 'Historial de Ajustes de Inventario')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold text-gray-700 mb-6">📜 Historial de Ajustes de Inventario</h1>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white shadow rounded p-4">
            <table class="w-full text-sm border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-2 py-1 border">Código</th>
                        <th class="px-2 py-1 border">Descripción</th>
                        <th class="px-2 py-1 border">Usuario</th>
                        <th class="px-2 py-1 border">Fecha</th>
                        <th class="px-2 py-1 border">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ajustes as $ajuste)
                        <tr>
                            <td class="border px-2 py-1">{{ $ajuste->codigo }}</td>
                            <td class="border px-2 py-1">{{ $ajuste->descripcion ?? '—' }}</td>
                            <td class="border px-2 py-1">{{ $ajuste->usuario->name }}</td>
                            <td class="border px-2 py-1">{{ $ajuste->created_at->format('d/m/Y H:i') }}</td>
                            <td class="border px-2 py-1">
                                <a href="{{ route('ajustes.detalle', $ajuste->id) }}"
                                    class="text-blue-600 hover:underline">Ver detalle</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">No hay ajustes registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $ajustes->links() }}
            </div>
        </div>
    </div>
@endsection
