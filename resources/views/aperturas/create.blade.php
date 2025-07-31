<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Apertura de Turno</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CSS CDN (opcional, si usas Tailwind) -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded-xl shadow">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">🟢 Apertura de Turno</h2>

        <form action="{{ route('aperturas.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block font-semibold mb-1">Efectivo inicial</label>
                <input type="number" name="efectivo_inicial" step="0.01" required class="w-full border rounded p-2">
            </div>

            <h3 class="font-bold text-lg mb-2 mt-6">POS por banco</h3>

            @foreach ($bancos as $index => $banco)
                <div class="grid grid-cols-2 gap-4 mb-3">
                    <div>
                        <label class="block font-semibold">Banco</label>
                        <select name="banco_id[]" class="w-full border rounded p-2" required>
                            <option value="{{ $banco->id }}">{{ $banco->nombre }}</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-semibold">Monto</label>
                        <input type="number" name="pos_monto[]" step="0.01" class="w-full border rounded p-2" required>
                    </div>
                </div>
            @endforeach

            <div class="mt-6 text-right">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                    Registrar Apertura
                </button>
            </div>
        </form>
    </div>
</body>
</html>
