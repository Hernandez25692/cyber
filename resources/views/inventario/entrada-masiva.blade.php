@extends('layouts.admin')

@section('title', 'Entrada de Inventario')

@section('content')
    <div class="max-w-5xl mx-auto mt-10 bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-6">📦 Nueva entrada de inventario</h2>

        <form method="POST" action="{{ route('inventario.entrada.store') }}" id="entradaForm">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Descripción general (opcional)</label>
                <textarea name="descripcion" class="w-full border rounded p-2"></textarea>
            </div>

            <hr class="my-6">

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Agregar producto por código:</label>
                <div class="flex gap-4 mt-2">
                    <input type="text" id="codigoInput" class="border rounded w-1/3 p-2" placeholder="Ej: P001">
                    <button type="button" onclick="buscarProducto()"
                        class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                        Buscar y agregar
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border mt-6" id="tablaProductos">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2">Código</th>
                            <th class="px-4 py-2">Nombre</th>
                            <th class="px-4 py-2">Stock actual</th>
                            <th class="px-4 py-2">Cantidad a agregar</th>
                            <th class="px-4 py-2 text-center">Quitar</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                    Registrar orden de entrada
                </button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        const tabla = document.querySelector("#tablaProductos tbody");

        function buscarProducto() {
            const codigo = document.getElementById('codigoInput').value.trim();
            if (!codigo) return alert('Ingresa un código de producto');

            fetch(`/api/producto/${codigo}`)
                .then(res => res.json())
                .then(data => {
                    if (!data || !data.id) {
                        return alert('Producto no encontrado');
                    }

                    // Validar si ya está en la tabla
                    if (document.querySelector(`input[name="productos[${data.codigo}][cantidad]"]`)) {
                        return alert('Ya agregaste este producto');
                    }

                    const fila = document.createElement('tr');
                    fila.innerHTML = `
                    <td class="px-4 py-2">${data.codigo}
                        <input type="hidden" name="productos[${data.codigo}][codigo]" value="${data.codigo}">
                    </td>
                    <td class="px-4 py-2">${data.nombre}</td>
                    <td class="px-4 py-2">${data.stock}</td>
                    <td class="px-4 py-2">
                        <input type="number" name="productos[${data.codigo}][cantidad]" min="1" value="1"
                            class="w-24 border rounded px-2 py-1" required>
                    </td>
                    <td class="px-4 py-2 text-center">
                        <button type="button" onclick="this.closest('tr').remove()"
                            class="text-red-600 hover:text-red-800">❌</button>
                    </td>
                `;
                    tabla.appendChild(fila);
                    document.getElementById('codigoInput').value = '';
                })
                .catch(err => {
                    alert('Error al buscar el producto');
                    console.error(err);
                });
        }
    </script>
@endsection
