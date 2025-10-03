@extends('layouts.admin')

@section('title', 'Panel de Administración')

@section('content')
    <div class="max-w-7xl mx-auto p-4 sm:p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-blue-900 tracking-tight mb-1">Reporte de Ganancias y Comisiones</h1>
                <p class="text-slate-500 text-base">Visualiza el resumen y detalle avanzado de tus ingresos, costos y comisiones.</p>
            </div>
            <div class="flex gap-2">
                <button type="button" id="btnFiltrar"
                    class="px-5 py-2 bg-gradient-to-r from-blue-600 to-blue-400 hover:from-blue-700 hover:to-blue-500 text-white rounded-xl shadow-lg font-semibold transition-all duration-150">
                    <i class="fa fa-filter mr-2"></i> Filtrar
                </button>
                <button type="button" id="btnLimpiar"
                    class="px-5 py-2 bg-gradient-to-r from-slate-200 to-slate-100 hover:from-slate-300 hover:to-slate-200 text-slate-700 rounded-xl shadow font-semibold transition-all duration-150">
                    <i class="fa fa-eraser mr-2"></i> Limpiar
                </button>
                <span id="status" class="text-sm text-slate-500 hidden ml-3">Cargando…</span>
            </div>
        </div>

        {{-- Filtros --}}
        <form id="filtros" class="grid md:grid-cols-5 gap-6 bg-white p-6 rounded-2xl shadow-xl border border-blue-100 mb-8" onsubmit="return false;">
            <div>
                <label class="text-sm font-semibold text-blue-700">Desde</label>
                <input type="date" name="desde" class="w-full mt-2 border border-blue-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-400 transition-all duration-150">
            </div>
            <div>
                <label class="text-sm font-semibold text-blue-700">Hasta</label>
                <input type="date" name="hasta" class="w-full mt-2 border border-blue-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-400 transition-all duration-150">
            </div>
            <div>
                <label class="text-sm font-semibold text-blue-700">Cajero</label>
                <select name="cajero_id" class="w-full mt-2 border border-blue-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-400 transition-all duration-150">
                    <option value="">Todos</option>
                    @foreach ($usuarios as $u)
                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-2">
                <label class="text-sm font-semibold text-blue-700">Servicios a incluir</label>
                <div class="mt-2 flex flex-wrap gap-4">
                    @php
                        $ops = [
                            'ventas' => 'Ventas de productos',
                            'recargas' => 'Recargas',
                            'remesas' => 'Remesas',
                            'retiros' => 'Retiros',
                            'impresiones' => 'Impresiones',
                            'servicios' => 'Servicios',
                        ];
                    @endphp
                    @foreach ($ops as $val => $label)
                        <label class="inline-flex items-center gap-2 bg-blue-50 px-3 py-2 rounded-lg shadow-sm hover:bg-blue-100 cursor-pointer transition-all duration-150">
                            <input type="checkbox" name="servicios[]" value="{{ $val }}" class="rounded accent-blue-600" checked>
                            <span class="font-medium text-blue-900">{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </form>

        {{-- Resumen --}}
        <div id="cards" class="grid md:grid-cols-4 gap-6 mt-2"></div>

        {{-- Por categoría --}}
        <div id="porCategoria" class="mt-10"></div>

        {{-- Detalle --}}
        <div class="mt-10">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-2xl font-bold text-blue-900">Detalle fila a fila</h2>
                <span class="text-slate-400 text-sm">Actualizado: <span id="detalleFecha"></span></span>
            </div>
            <div class="overflow-auto bg-white rounded-2xl shadow-xl border border-blue-100">
                <table class="min-w-full text-sm">
                    <thead class="bg-gradient-to-r from-blue-50 to-blue-100 text-blue-900">
                        <tr>
                            <th class="text-left p-4 font-semibold">Categoría</th>
                            <th class="text-left p-4 font-semibold">Fecha</th>
                            <th class="text-left p-4 font-semibold">Cajero</th>
                            <th class="text-left p-4 font-semibold">Referencia</th>
                            <th class="text-right p-4 font-semibold">Ingreso</th>
                            <th class="text-right p-4 font-semibold">Costo</th>
                            <th class="text-right p-4 font-semibold">Comisión</th>
                            <th class="text-right p-4 font-semibold">Ganancia</th>
                        </tr>
                    </thead>
                    <tbody id="detalleBody"></tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- FontAwesome CDN for icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <script>
        const $status = document.getElementById('status');

        async function fetchDatos() {
            const form = document.getElementById('filtros');
            const fd = new FormData(form);
            const params = new URLSearchParams();
            for (const [k, v] of fd.entries()) {
                if (k === 'servicios[]') {
                    params.append('servicios[]', v);
                } else {
                    params.append(k, v);
                }
            }
            const url = "{{ route('admin.reporte_ganancias.data') }}?" + params.toString();
            const res = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            if (!res.ok) {
                const txt = await res.text();
                throw new Error('Error ' + res.status + ': ' + txt);
            }
            return await res.json();
        }

        function money(n) {
            return (Number(n || 0)).toLocaleString('es-HN', {
                style: 'currency',
                currency: 'HNL'
            });
        }

        function resumenIcon(idx) {
            const icons = [
                '<i class="fa fa-arrow-down text-blue-500"></i>',
                '<i class="fa fa-coins text-yellow-500"></i>',
                '<i class="fa fa-percent text-green-500"></i>',
                '<i class="fa fa-chart-line text-purple-600"></i>',
            ];
            return icons[idx] || '';
        }

        function renderResumen(tot) {
            const cont = document.getElementById('cards');
            cont.innerHTML = '';
            const items = [
                { 
                    label: 'Ingresos', 
                    value: money(tot.ingresos), 
                    color: 'from-blue-500 to-blue-400', 
                    shadow: 'shadow-blue-200',
                    gradient: 'linear-gradient(135deg, #2563eb 0%, #60a5fa 100%)',
                    border: 'border-blue-500',
                    iconBg: 'bg-white/30'
                },
                { 
                    label: 'Costos', 
                    value: money(tot.costos), 
                    color: 'from-yellow-400 to-yellow-300', 
                    shadow: 'shadow-yellow-200',
                    gradient: 'linear-gradient(135deg, #facc15 0%, #fde68a 100%)',
                    border: 'border-yellow-400',
                    iconBg: 'bg-white/30'
                },
                { 
                    label: 'Comisiones', 
                    value: money(tot.comisiones), 
                    color: 'from-green-400 to-green-300', 
                    shadow: 'shadow-green-200',
                    gradient: 'linear-gradient(135deg, #34d399 0%, #bbf7d0 100%)',
                    border: 'border-green-400',
                    iconBg: 'bg-white/30'
                },
                { 
                    label: 'Ganancias', 
                    value: money(tot.ganancias), 
                    color: 'from-purple-500 to-purple-400', 
                    shadow: 'shadow-purple-200',
                    gradient: 'linear-gradient(135deg, #a78bfa 0%, #c4b5fd 100%)',
                    border: 'border-purple-500',
                    iconBg: 'bg-white/30'
                },
            ];
            items.forEach((i, idx) => {
                const div = document.createElement('div');
                div.className = `bg-gradient-to-br ${i.color} rounded-2xl shadow-xl p-6 flex flex-col gap-2 border border-blue-100`;
                div.innerHTML = `
                    <div class="flex items-center gap-3">
                        <span class="text-3xl">${resumenIcon(idx)}</span>
                        <span class="text-lg font-bold text-white">${i.label}</span>
                    </div>
                    <div class="text-3xl font-extrabold text-white mt-2">${i.value}</div>
                `;
                cont.appendChild(div);
            });
        }

        function categoriaIcon(cat) {
            const icons = {
                ventas: '<i class="fa fa-shopping-cart text-blue-500"></i>',
                recargas: '<i class="fa fa-bolt text-yellow-500"></i>',
                remesas: '<i class="fa fa-paper-plane text-green-500"></i>',
                retiros: '<i class="fa fa-money-bill-wave text-red-500"></i>',
                impresiones: '<i class="fa fa-print text-purple-500"></i>',
                servicios: '<i class="fa fa-cogs text-indigo-500"></i>',
            };
            return icons[cat] || '<i class="fa fa-box text-slate-400"></i>';
        }

        function renderPorCategoria(data) {
            const cont = document.getElementById('porCategoria');
            cont.innerHTML = '';
            Object.entries(data).forEach(([cat, val]) => {
                const card = document.createElement('div');
                card.className = "bg-white rounded-2xl shadow-xl p-6 mb-6 border border-blue-100";
                card.innerHTML = `
                    <div class="flex justify-between items-center mb-3">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">${categoriaIcon(cat)}</span>
                            <h3 class="font-bold text-lg capitalize text-blue-900">${cat}</h3>
                        </div>
                        <span class="text-xs text-slate-500 bg-blue-50 px-3 py-1 rounded-full">Items: ${val.items||0}</span>
                    </div>
                    <div class="grid md:grid-cols-4 gap-4 mt-2">
                        <div>
                            <div class="text-slate-500 text-sm">Ingresos</div>
                            <div class="text-xl font-bold text-blue-700">${money(val.ingresos)}</div>
                        </div>
                        <div>
                            <div class="text-slate-500 text-sm">Costos</div>
                            <div class="text-xl font-bold text-yellow-600">${money(val.costos)}</div>
                        </div>
                        <div>
                            <div class="text-slate-500 text-sm">Comisiones</div>
                            <div class="text-xl font-bold text-green-600">${money(val.comisiones)}</div>
                        </div>
                        <div>
                            <div class="text-slate-500 text-sm">Ganancias</div>
                            <div class="text-xl font-bold text-purple-700">${money(val.ganancias)}</div>
                        </div>
                    </div>
                `;
                cont.appendChild(card);
            });
        }

        function renderDetalle(rows) {
            const tbody = document.getElementById('detalleBody');
            tbody.innerHTML = '';
            let lastFecha = '';
            rows.forEach(r => {
                const tr = document.createElement('tr');
                tr.className = "border-b last:border-0 hover:bg-blue-50 transition-all duration-100";
                tr.innerHTML = `
                    <td class="p-4 font-medium text-blue-900">${r.categoria||''}</td>
                    <td class="p-4">${r.fecha? new Date(r.fecha).toLocaleString():''}</td>
                    <td class="p-4">${r.cajero||''}</td>
                    <td class="p-4">${r.referencia||''}</td>
                    <td class="p-4 text-right text-blue-700 font-semibold">${money(r.ingreso)}</td>
                    <td class="p-4 text-right text-yellow-600 font-semibold">${money(r.costo)}</td>
                    <td class="p-4 text-right text-green-600 font-semibold">${money(r.comision)}</td>
                    <td class="p-4 text-right font-extrabold text-purple-700">${money(r.ganancia)}</td>
                `;
                tbody.appendChild(tr);
                if (r.fecha) lastFecha = r.fecha;
            });
            document.getElementById('detalleFecha').textContent = lastFecha ? new Date(lastFecha).toLocaleString() : '';
        }

        async function cargar() {
            try {
                $status.classList.remove('hidden');
                $status.textContent = 'Cargando…';
                const data = await fetchDatos();
                renderResumen(data.totales || {});
                renderPorCategoria(data.por_categoria || {});
                renderDetalle(data.detalles || []);
                $status.textContent = 'Listo';
                setTimeout(() => $status.classList.add('hidden'), 700);
            } catch (err) {
                console.error(err);
                $status.textContent = 'Error al cargar';
                alert('No se pudo cargar el reporte.\n' + err.message);
                setTimeout(() => $status.classList.add('hidden'), 1500);
            }
        }

        document.getElementById('btnFiltrar').addEventListener('click', cargar);
        document.getElementById('btnLimpiar').addEventListener('click', () => {
            const form = document.getElementById('filtros');
            form.reset();
            form.querySelectorAll('input[type="checkbox"][name="servicios[]"]').forEach(c => c.checked = true);
            cargar();
        });

        document.getElementById('filtros').addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                cargar();
            }
        });

        cargar();
    </script>
@endsection
