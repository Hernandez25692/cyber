@extends('layouts.admin')

@section('title', 'Historial de Órdenes de Entrada')

@section('content')
    <div class="max-w-7xl mx-auto px-6 py-8 bg-[#f3f6f9] min-h-screen font-sans">
        <div class="mb-8 flex items-center gap-4">
            <div class="bg-[#0a6ed1] rounded-full w-12 h-12 flex items-center justify-center shadow">
                <span class="text-white text-2xl">📦</span>
            </div>
            <h1 class="text-3xl font-bold text-[#0a6ed1] tracking-tight">Historial de Órdenes de Entrada</h1>
        </div>
        <form method="GET" class="bg-white rounded-lg p-6 mb-8 shadow-md flex flex-wrap items-end gap-6 border border-[#e5eaf3]">
            <div>
                <label class="block text-xs text-[#6a6d70] font-semibold mb-1">Desde</label>
                <input type="date" name="desde" value="{{ request('desde') }}" class="border border-[#b8c2cc] rounded px-3 py-2 focus:ring-2 focus:ring-[#0a6ed1] focus:outline-none text-sm w-40 bg-[#f8fafc]">
            </div>
            <div>
                <label class="block text-xs text-[#6a6d70] font-semibold mb-1">Hasta</label>
                <input type="date" name="hasta" value="{{ request('hasta') }}" class="border border-[#b8c2cc] rounded px-3 py-2 focus:ring-2 focus:ring-[#0a6ed1] focus:outline-none text-sm w-40 bg-[#f8fafc]">
            </div>
            <div>
                <label class="block text-xs text-[#6a6d70] font-semibold mb-1">Nombre Producto</label>
                <input type="text" name="producto" value="{{ request('producto') }}" placeholder="Nombre del producto"
                    class="border border-[#b8c2cc] rounded px-3 py-2 focus:ring-2 focus:ring-[#0a6ed1] focus:outline-none text-sm w-56 bg-[#f8fafc]">
            </div>
            <div>
                <label class="block text-xs text-[#6a6d70] font-semibold mb-1">Código Producto</label>
                <input type="text" name="codigo" value="{{ request('codigo') }}" placeholder="Código del producto"
                    class="border border-[#b8c2cc] rounded px-3 py-2 focus:ring-2 focus:ring-[#0a6ed1] focus:outline-none text-sm w-40 bg-[#f8fafc]">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-[#0a6ed1] text-white px-5 py-2 rounded shadow hover:bg-[#0854a0] transition font-semibold text-sm">Filtrar</button>
                <a href="{{ route('ordenes-entrada.index') }}" class="text-[#0a6ed1] text-sm underline hover:text-[#0854a0] font-medium">Limpiar</a>
            </div>
        </form>

        @forelse ($ordenes as $orden)
            <div class="bg-white shadow-sm rounded-lg mb-8 border border-[#e5eaf3]">
                <div class="flex justify-between items-center px-6 py-4 border-b border-[#e5eaf3] bg-[#f8fafc] rounded-t-lg">
                    <div>
                        <h2 class="text-lg font-bold text-[#0a6ed1]">Orden: <span class="font-mono">{{ $orden->codigo }}</span></h2>
                        <p class="text-xs text-[#6a6d70] mt-1">Registrado por: <span class="font-semibold text-[#0854a0]">{{ $orden->usuario->name }}</span> | {{ $orden->created_at->format('d/m/Y H:i') }}</p>
                        @if ($orden->descripcion)
                            <p class="text-[#6a6d70] italic mt-2 text-sm">📄 {{ $orden->descripcion }}</p>
                        @endif
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full table-auto text-sm text-left">
                        <thead>
                            <tr class="bg-[#e5eaf3] text-[#0a6ed1] uppercase tracking-wide">
                                <th class="px-6 py-3 border-b border-[#e5eaf3] font-semibold">#</th>
                                <th class="px-6 py-3 border-b border-[#e5eaf3] font-semibold">Producto</th>
                                <th class="px-6 py-3 border-b border-[#e5eaf3] font-semibold">Código</th>
                                <th class="px-6 py-3 border-b border-[#e5eaf3] font-semibold">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orden->detalles as $i => $detalle)
                                <tr class="hover:bg-[#f3f6f9] transition">
                                    <td class="px-6 py-2 border-b border-[#e5eaf3]">{{ $i + 1 }}</td>
                                    <td class="px-6 py-2 border-b border-[#e5eaf3]">{{ $detalle->producto->nombre }}</td>
                                    <td class="px-6 py-2 border-b border-[#e5eaf3] font-mono">{{ $detalle->producto->codigo }}</td>
                                    <td class="px-6 py-2 border-b border-[#e5eaf3]">{{ $detalle->cantidad }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow p-8 text-center text-[#6a6d70] border border-[#e5eaf3]">
                <span class="text-2xl block mb-2">🗂️</span>
                No se encontraron órdenes de entrada con los filtros seleccionados.
            </div>
        @endforelse

        <div class="mt-6 flex justify-center">
            {{ $ordenes->links() }}
        </div>
    </div>
@endsection
