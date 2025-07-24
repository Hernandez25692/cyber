@extends('layouts.admin')

@section('title', 'Entrada de Inventario')

@section('content')
    <div class="max-w-5xl mx-auto mt-10 bg-[#f3f6f9] shadow-2xl rounded-lg p-8 border border-[#d1dbe5] font-sans">
        <div class="flex items-center mb-8">
            <div class="bg-[#0a6ed1] text-white rounded-full w-12 h-12 flex items-center justify-center mr-4 shadow">
                <span class="text-2xl">📦</span>
            </div>
            <h2 class="text-3xl font-bold text-[#0a6ed1] tracking-wide">Nueva entrada de inventario</h2>
        </div>

        <form method="POST" action="{{ route('inventario.entrada.store') }}" id="entradaForm">
            @csrf
            <div class="mb-6">
                <label class="block text-[#2e3b4e] font-semibold mb-1">Descripción general (opcional)</label>
                <textarea name="descripcion" class="w-full border border-[#b0beca] rounded-lg p-3 bg-[#f9fafb] focus:outline-none focus:ring-2 focus:ring-[#0a6ed1] transition"></textarea>
            </div>

            <hr class="my-8 border-[#d1dbe5]">

            <div class="mb-6">
                <label class="block text-[#2e3b4e] font-semibold mb-1">Agregar producto por código:</label>
                <div class="flex gap-4 mt-2">
                    <input type="text" id="codigoInput"
                        class="border border-[#b0beca] rounded-lg w-1/3 p-3 bg-[#f9fafb] focus:outline-none focus:ring-2 focus:ring-[#0a6ed1] transition"
                        placeholder="Ej: P001"
                        onkeydown="if(event.key==='Enter'){event.preventDefault();buscarProducto();}"
                        autofocus>
                    <button type="button" onclick="buscarProducto()"
                        class="bg-[#0a6ed1] text-white px-6 py-2 rounded-lg shadow hover:bg-[#085caf] transition">
                        Buscar y agregar
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto rounded-lg border border-[#d1dbe5] bg-white shadow-inner">
                <table class="w-full text-sm text-left mt-6" id="tablaProductos">
                    <thead class="bg-[#eaf1fb] text-[#2e3b4e]">
                        <tr>
                            <th class="px-5 py-3 font-semibold">Código</th>
                            <th class="px-5 py-3 font-semibold">Nombre</th>
                            <th class="px-5 py-3 font-semibold">Stock actual</th>
                            <th class="px-5 py-3 font-semibold">Cantidad a agregar</th>
                            <th class="px-5 py-3 font-semibold text-center">Quitar</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <div class="mt-8 flex justify-end">
                <button type="submit" class="bg-[#107e3e] text-white px-8 py-3 rounded-lg shadow hover:bg-[#0b6330] transition font-semibold text-lg">
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
                    fila.className = "hover:bg-[#f3f6f9] transition";
                    fila.innerHTML = `
                    <td class="px-5 py-3 border-b border-[#e3e9f1] font-mono text-[#0a6ed1]">
                        ${data.codigo}
                        <input type="hidden" name="productos[${data.codigo}][codigo]" value="${data.codigo}">
                    </td>
                    <td class="px-5 py-3 border-b border-[#e3e9f1]">${data.nombre}</td>
                    <td class="px-5 py-3 border-b border-[#e3e9f1]">${data.stock}</td>
                    <td class="px-5 py-3 border-b border-[#e3e9f1]">
                        <input type="number" name="productos[${data.codigo}][cantidad]" min="1" value="1"
                            class="w-24 border border-[#b0beca] rounded-lg px-2 py-1 bg-[#f9fafb] focus:outline-none focus:ring-2 focus:ring-[#0a6ed1] transition" required>
                    </td>
                    <td class="px-5 py-3 border-b border-[#e3e9f1] text-center">
                        <button type="button" onclick="this.closest('tr').remove()"
                            class="text-[#e53935] hover:text-[#b71c1c] text-xl transition" title="Quitar">❌</button>
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
