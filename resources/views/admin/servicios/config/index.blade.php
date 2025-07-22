@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="text-2xl font-bold mb-4">Configuración de Servicios</h1>

        <a href="{{ route('admin.servicios.config.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">Nueva Configuración</a>

        <table class="table-auto w-full border mt-4">
            <thead>
                <tr>
                    <th class="border p-2">Tipo Servicio</th>
                    <th class="border p-2">Banco</th>
                    <th class="border p-2">Comisión</th>
                    <th class="border p-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($configs as $config)
                    <tr>
                        <td class="border p-2">{{ $config->tipo->nombre }}</td>
                        <td class="border p-2">{{ $config->banco->nombre }}</td>
                        <td class="border p-2">L {{ number_format($config->comision, 2) }}</td>
                        <td class="border p-2">
                            <form action="{{ route('admin.servicios.config.destroy', $config) }}" method="POST"
                                onsubmit="return confirm('¿Eliminar configuración?')">
                                @csrf @method('DELETE')
                                <button class="bg-red-500 text-white px-3 py-1 rounded">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
