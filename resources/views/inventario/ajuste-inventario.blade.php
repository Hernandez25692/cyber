@extends('layouts.admin')

@section('title', 'Ajuste de Inventario')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold text-gray-700 mb-6">🧮 Ajuste de Inventario</h1>

        <form action="{{ route('ajustes.guardar') }}" method="POST" id="ajusteForm">
            @csrf

            <div class="mb-6">
                <label for="descripcion" class="block font-medium text-gray-700 mb-1">Descripción del ajuste
                    (opcional):</label>
                <textarea name="descripcion" id="descripcion" rows="2" class="w-full border border-gray-300 p-2 rounded">{{ old('descripcion') }}</textarea>
            </div>

            <div class="bg-white shadow rounded p-4 mb-6">
                <h2 class="text-lg font-semibold text-gray-600 mb-4">Agregar productos</h2>
                <div class="flex items-center gap-3 mb-4">
                    <input type="text" id="codigoProducto" class="border p-2 rounded w-full"
                        placeholder="Ingrese código de producto">
                    <button type="button" id="buscarBtn" class="bg-blue-600 text-white px-4 py-2 rounded">Buscar</button>
                </div>
                <div id="tablaProductosContainer" class="overflow-x-auto">
                    <table class="w-full table-auto border text-sm" id="tablaProductos">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-2 py-1 border">Código</th>
                                <th class="px-2 py-1 border">Nombre</th>
                                <th class="px-2 py-1 border">Stock Sistema</th>
                                <th class="px-2 py-1 border">Stock Físico</th>
                                <th class="px-2 py-1 border">Diferencia</th>
                                <th class="px-2 py-1 border">Observación</th>
                                <th class="px-2 py-1 border">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="productosBody"></tbody>
                    </table>
                </div>
            </div>

            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded shadow hover:bg-green-700">📥 Registrar
                Ajuste</button>
        </form>
    </div>

    <script>
        let productos = [];

        function buscarProducto() {
            let codigo = document.getElementById('codigoProducto').value.trim();
            if (!codigo) return;

            fetch("{{ route('ajustes.buscar') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        codigo: codigo
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }

                    if (productos.some(p => p.id === data.id)) {
                        alert('Este producto ya fue agregado.');
                        return;
                    }

                    productos.push({
                        ...data,
                        stock_fisico: '',
                        observacion: ''
                    });
                    renderTabla();
                    document.getElementById('codigoProducto').value = '';
                });
        }

        document.getElementById('buscarBtn').addEventListener('click', (e) => {
            e.preventDefault();
            buscarProducto();
        });

        document.getElementById('codigoProducto').addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                buscarProducto();
            }
        });

        function renderTabla() {
            let tbody = document.getElementById('productosBody');
            tbody.innerHTML = '';

            productos.forEach((p, index) => {
                let diferencia = p.stock_fisico !== '' ? (parseInt(p.stock_fisico) - p.stock) : '';
                let row = `
                <tr>
                    <td class="border px-2 py-1">${p.codigo}<input type="hidden" name="productos[${index}][id]" value="${p.id}"></td>
                    <td class="border px-2 py-1">${p.nombre}</td>
                    <td class="border px-2 py-1">${p.stock}<input type="hidden" name="productos[${index}][stock_sistema]" value="${p.stock}"></td>
                    <td class="border px-2 py-1">
                        <input type="number" name="productos[${index}][stock_fisico]" value="${p.stock_fisico}" min="0" onchange="updateStockFisico(${index}, this.value)" class="w-20 border p-1 rounded">
                    </td>
                    <td class="border px-2 py-1" style="background-color: ${diferencia < 0 ? '#fee2e2' : (diferencia > 0 ? '#dcfce7' : 'inherit')}; color: ${diferencia < 0 ? '#b91c1c' : (diferencia > 0 ? '#166534' : 'inherit')}">
                        ${diferencia !== '' ? diferencia : '-'}
                    </td>
                    <td class="border px-2 py-1">
                        <input type="text" name="productos[${index}][observacion]" value="${p.observacion}" class="w-full border p-1 rounded" onchange="productos[${index}].observacion = this.value">
                    </td>
                    <td class="border px-2 py-1">
                        <button type="button" onclick="eliminarProducto(${index})" class="text-red-600 hover:underline">Eliminar</button>
                    </td>
                </tr>
            `;
                tbody.innerHTML += row;
            });
        }

        function updateStockFisico(index, valor) {
            productos[index].stock_fisico = valor;
            renderTabla();
        }

        function eliminarProducto(index) {
            productos.splice(index, 1);
            renderTabla();
        }
    </script>
@endsection
