@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="text-2xl font-bold mb-4">Bancos</h1>

        <a href="{{ route('admin.servicios.bancos.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">Nuevo Banco</a>

        <table class="table-auto w-full border mt-4">
            <thead>
                <tr>
                    <th class="border p-2">Nombre</th>
                    <th class="border p-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bancos as $banco)
                    <tr>
                        <td class="border p-2">{{ $banco->nombre }}</td>
                        <td class="border p-2">
                            <form action="{{ route('admin.servicios.bancos.destroy', $banco) }}" method="POST"
                                onsubmit="return confirm('¿Eliminar este banco?')">
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
