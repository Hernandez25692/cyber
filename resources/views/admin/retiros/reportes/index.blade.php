@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h2 class="text-xl font-bold mb-4">📊 Reporte de Retiros Realizados</h2>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Monto</th>
                    <th>Comisión</th>
                    <th>Referencia</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($retiros as $retiro)
                    <tr>
                        <td>{{ $retiro->usuario->name }}</td>
                        <td>L {{ number_format($retiro->monto, 2) }}</td>
                        <td>L {{ number_format($retiro->comision, 2) }}</td>
                        <td>{{ $retiro->referencia ?? 'N/A' }}</td>
                        <td>{{ $retiro->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
