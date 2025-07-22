@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="text-2xl font-bold mb-4">Nueva Configuración de Servicio</h1>

        <form action="{{ route('admin.servicios.config.store') }}" method="POST" class="space-y-4 max-w-md">
            @csrf

            <div>
                <label class="block font-semibold">Tipo de Servicio</label>
                <select name="tipo_servicio_id" class="w-full border rounded p-2" required>
                    @foreach ($tipos as $tipo)
                        <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-semibold">Banco</label>
                <select name="banco_id" class="w-full border rounded p-2" required>
                    @foreach ($bancos as $banco)
                        <option value="{{ $banco->id }}">{{ $banco->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-semibold">Comisión</label>
                <input type="number" name="comision" step="0.01" required class="w-full border rounded px-3 py-2">
            </div>

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Guardar</button>
        </form>
    </div>
@endsection
