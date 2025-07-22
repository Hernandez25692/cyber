@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h2 class="text-xl font-bold mb-4">Nuevo Rango de Comisión</h2>

        <form action="{{ route('admin.retiros.config.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Rango</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="monto_min" class="form-label">Monto Mínimo</label>
                <input type="number" step="0.01" name="monto_min" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="monto_max" class="form-label">Monto Máximo</label>
                <input type="number" step="0.01" name="monto_max" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="comision" class="form-label">Comisión</label>
                <input type="number" step="0.01" name="comision" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">Guardar Rango</button>
        </form>
    </div>
@endsection
