@extends('layouts.admin')

@section('title', 'Registrar Remesa')

@section('content')
    <h2 class="text-2xl font-bold text-green-700 mb-6">💸 Registrar Remesa</h2>

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('remesas.store') }}" method="POST" class="space-y-4 max-w-xl">
        @csrf

        <div>
            <label class="block font-semibold">Monto</label>
            <input type="number" step="0.01" name="monto" id="monto" class="w-full border rounded p-2" required
                oninput="calcularComision()">
        </div>

        <div>
            <label class="block font-semibold">Comisión a cobrar</label>
            <input type="text" id="comision" class="w-full border rounded p-2 bg-gray-100 text-green-700 font-bold"
                readonly>
        </div>

        <div>
            <label class="block font-semibold">Referencia / ID (opcional)</label>
            <input type="text" name="referencia" class="w-full border rounded p-2">
        </div>

        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
            Registrar Remesa
        </button>
    </form>

    <script>
        const rangos = @json($rangos);

        function calcularComision() {
            const monto = parseFloat(document.getElementById('monto').value);
            const inputComision = document.getElementById('comision');

            if (isNaN(monto)) {
                inputComision.value = '';
                return;
            }

            const rango = rangos.find(r =>
                parseFloat(r.monto_min) <= monto && parseFloat(r.monto_max) >= monto
            );

            if (rango) {
                inputComision.value = `L. ${parseFloat(rango.comision).toFixed(2)}`;
            } else {
                inputComision.value = '❌ Sin comisión definida';
            }
        }
    </script>
@endsection
