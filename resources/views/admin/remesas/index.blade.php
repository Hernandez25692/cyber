@extends('layouts.admin')

@section('title', 'Remesas y Comisiones')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8 bg-gradient-to-br from-gray-100 to-green-50 min-h-screen font-sans">
    <!-- Header -->
    <div class="mb-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-4xl font-extrabold text-green-900 tracking-tight flex items-center gap-3">
                <span class="bg-green-100 rounded-full p-2 shadow-inner">💸</span>
                Remesas y Comisiones
            </h1>
            <p class="text-base text-green-700 mt-2">Gestión de comisiones para remesas en el sistema administrativo.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.index') }}" class="flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-5 py-2 rounded-lg shadow transition-all border border-gray-300">
                ← Regresar
            </a>
            <a href="{{ route('admin.remesas.create') }}" class="flex items-center gap-2 bg-gradient-to-r from-green-500 to-green-700 hover:from-green-600 hover:to-green-800 text-white font-semibold px-5 py-2 rounded-lg shadow transition-all border border-green-600">
                ➕ Nueva Comisión
            </a>
        </div>
    </div>

    <!-- Card -->
    <div class="bg-white rounded-2xl shadow-2xl p-8 border border-green-100">
        <div class="flex items-center gap-3 mb-6">
            <span class="bg-green-200 text-green-900 rounded-full px-3 py-1 text-lg font-bold shadow-inner">📋</span>
            <h2 class="text-2xl font-bold text-green-800 tracking-wide">Comisiones registradas</h2>
        </div>
        <div class="overflow-x-auto custom-scrollbar">
            <table class="min-w-full text-base border-separate border-spacing-y-2">
                <thead class="bg-green-50 text-green-900 uppercase text-xs font-bold">
                    <tr>
                        <th class="p-4 text-left rounded-tl-xl border-b-2 border-green-200">Nombre</th>
                        <th class="p-4 text-left border-b-2 border-green-200">Monto Mínimo</th>
                        <th class="p-4 text-left border-b-2 border-green-200">Monto Máximo</th>
                        <th class="p-4 text-left border-b-2 border-green-200">Comisión</th>
                        <th class="p-4 text-left rounded-tr-xl border-b-2 border-green-200">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($remesas as $r)
                        <tr class="bg-green-50 hover:bg-green-100 transition-colors shadow rounded-xl border-b border-green-100">
                            <td class="p-4 font-semibold text-green-900 border-r border-green-100">{{ $r->nombre }}</td>
                            <td class="p-4 text-green-800 border-r border-green-100">L. {{ number_format($r->monto_min, 2) }}</td>
                            <td class="p-4 text-green-800 border-r border-green-100">L. {{ number_format($r->monto_max, 2) }}</td>
                            <td class="p-4 text-green-800 border-r border-green-100">L. {{ number_format($r->comision, 2) }}</td>
                            <td class="p-4">
                                <form action="{{ route('admin.remesas.destroy', $r->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar esta comisión?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="flex items-center gap-1 bg-gradient-to-r from-red-500 to-red-700 hover:from-red-600 hover:to-red-800 text-white px-4 py-1.5 rounded-lg shadow transition-all border border-red-600 font-semibold">
                                        🗑️ Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-green-600 bg-green-50 rounded-xl">Sin registros</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
/* SAP-like scrollbar */
.custom-scrollbar::-webkit-scrollbar {
    height: 8px;
    background: #e5f4ea;
    border-radius: 8px;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #38a169;
    border-radius: 8px;
}
.custom-scrollbar {
    scrollbar-color: #38a169 #e5f4ea;
    scrollbar-width: thin;
}
</style>
@endsection
