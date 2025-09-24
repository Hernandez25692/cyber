@extends('layouts.admin')

@section('title', 'Configuración de Comisión - Depósitos')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-blue-600">Configuración de Comisión - Depósitos</h1>
        <a href="{{ route('admin.depositos.config.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
            ➕ Nuevo Rango
        </a>
    </div>

    @if ($rangos->isEmpty())
        <p class="text-gray-500">No hay rangos configurados aún.</p>
    @else
        <table class="min-w-full bg-white border rounded-lg shadow">
            <thead class="bg-blue-100">
                <tr>
                    <th class="px-4 py-2 text-left">Nombre</th>
                    <th class="px-4 py-2 text-left">Monto Mínimo</th>
                    <th class="px-4 py-2 text-left">Monto Máximo</th>
                    <th class="px-4 py-2 text-left">Comisión</th>
                    <th class="px-4 py-2 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rangos as $rango)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $rango->nombre }}</td>
                        <td class="px-4 py-2">L. {{ number_format($rango->monto_min, 2) }}</td>
                        <td class="px-4 py-2">L. {{ number_format($rango->monto_max, 2) }}</td>
                        <td class="px-4 py-2 text-blue-600 font-bold">L. {{ number_format($rango->comision, 2) }}</td>
                        <td class="px-4 py-2 text-center">
                            <form action="{{ route('admin.depositos.config.destroy', $rango) }}" method="POST"
                                onsubmit="return confirm('¿Seguro que deseas eliminar este rango?')">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">🗑
                                    Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
