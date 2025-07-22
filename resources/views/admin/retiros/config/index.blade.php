@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h2 class="text-xl font-bold mb-4">Configuración de Comisiones para Retiros</h2>

        <a href="{{ route('admin.retiros.config.create') }}" class="btn btn-primary mb-3">➕ Nuevo Rango</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Monto Mínimo</th>
                    <th>Monto Máximo</th>
                    <th>Comisión</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rangos as $rango)
                    <tr>
                        <td>{{ $rango->nombre }}</td>
                        <td>L {{ number_format($rango->monto_min, 2) }}</td>
                        <td>L {{ number_format($rango->monto_max, 2) }}</td>
                        <td>L {{ number_format($rango->comision, 2) }}</td>
                        <td>
                            <form action="{{ route('admin.retiros.config.destroy', $rango->id) }}" method="POST"
                                onsubmit="return confirm('¿Eliminar este rango?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">🗑️</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
