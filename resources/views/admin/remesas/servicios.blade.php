@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-xl font-bold mb-4">Reporte de Servicios Realizados</h2>

        <form method="GET" class="mb-4 flex gap-4 flex-wrap">
            <input type="date" name="desde" value="{{ $filtros['desde'] ?? '' }}" class="form-input" />
            <input type="date" name="hasta" value="{{ $filtros['hasta'] ?? '' }}" class="form-input" />
            <select name="tipo_servicio_id" class="form-select">
                <option value="">Todos los Tipos</option>
                @foreach ($tipos as $tipo)
                    <option value="{{ $tipo->id }}"
                        {{ ($filtros['tipo_servicio_id'] ?? '') == $tipo->id ? 'selected' : '' }}>
                        {{ $tipo->nombre }}
                    </option>
                @endforeach
            </select>
            <button class="btn btn-primary">Filtrar</button>
        </form>

        <table class="table-auto w-full bg-white shadow-md rounded">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="p-2">ID</th>
                    <th class="p-2">Tipo</th>
                    <th class="p-2">Banco</th>
                    <th class="p-2">Comisión</th>
                    <th class="p-2">Referencia</th>
                    <th class="p-2">Usuario</th>
                    <th class="p-2">Fecha</th>
                </tr>
            </thead>
            <tbody>
                @forelse($servicios as $servicio)
                    <tr class="border-t">
                        <td class="p-2">{{ $servicio->id }}</td>
                        <td class="p-2">{{ $servicio->tipo->nombre }}</td>
                        <td class="p-2">{{ $servicio->banco->nombre }}</td>
                        <td class="p-2">L. {{ number_format($servicio->comision, 2) }}</td>
                        <td class="p-2">{{ $servicio->referencia }}</td>
                        <td class="p-2">{{ $servicio->usuario->name }}</td>
                        <td class="p-2">{{ $servicio->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-2 text-center">No hay servicios registrados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
