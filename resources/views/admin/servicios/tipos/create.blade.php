@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="text-2xl font-bold mb-4">Crear Tipo de Servicio</h1>

        <form action="{{ route('admin.servicios.tipos.store') }}" method="POST" class="space-y-4 max-w-md">
            @csrf

            <div>
                <label class="block font-semibold">Nombre</label>
                <input type="text" name="nombre" required class="w-full border rounded px-3 py-2">
            </div>

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Guardar</button>
        </form>
    </div>
@endsection
