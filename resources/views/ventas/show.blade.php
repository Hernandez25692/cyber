@extends('layouts.admin')

@section('title', 'Detalle de Venta')

@section('content')
    <div class="max-w-4xl mx-auto px-6 py-8 bg-gradient-to-br from-blue-50 via-white to-gray-100 shadow-2xl rounded-2xl mt-8 border border-blue-200">
        <div class="flex items-center gap-3 mb-6">
            <div class="bg-blue-100 rounded-full p-3 shadow">
                <span class="text-3xl">🧾</span>
            </div>
            <h1 class="text-3xl font-extrabold text-blue-900 tracking-tight">Detalle de Venta</h1>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 text-[15px]">
            <div class="bg-white rounded-xl shadow p-5 border border-blue-100">
                <dl class="space-y-2">
                    <div class="flex items-center">
                        <dt class="font-semibold text-blue-800 w-36">ID Venta:</dt>
                        <dd class="text-gray-700">{{ $venta->id }}</dd>
                    </div>
                    <div class="flex items-center">
                        <dt class="font-semibold text-blue-800 w-36">Vendedor:</dt>
                        <dd class="text-gray-700">{{ $venta->user->name }}</dd>
                    </div>
                    <div class="flex items-center">
                        <dt class="font-semibold text-blue-800 w-36">Fecha:</dt>
                        <dd class="text-gray-700">{{ $venta->created_at->format('d/m/Y H:i') }}</dd>
                    </div>
                </dl>
            </div>
            <div class="bg-white rounded-xl shadow p-5 border border-blue-100">
                <dl class="space-y-2">
                    <div class="flex items-center">
                        <dt class="font-semibold text-blue-800 w-40">Total:</dt>
                        <dd class="text-gray-700">L. {{ number_format($venta->total, 2) }}</dd>
                    </div>
                    <div class="flex items-center">
                        <dt class="font-semibold text-blue-800 w-40">Monto Recibido:</dt>
                        <dd class="text-gray-700">L. {{ number_format($venta->monto_recibido, 2) }}</dd>
                    </div>
                    <div class="flex items-center">
                        <dt class="font-semibold text-blue-800 w-40">Cambio:</dt>
                        <dd class="text-gray-700">L. {{ number_format($venta->cambio, 2) }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="mb-4 flex items-center gap-2">
            <span class="text-xl">🛒</span>
            <h2 class="text-xl font-bold text-blue-900 tracking-tight">Productos Vendidos</h2>
        </div>
        <div class="overflow-x-auto rounded-xl shadow border border-blue-100 bg-white">
            <table class="min-w-full text-sm text-blue-900">
                <thead class="bg-blue-50 border-b border-blue-200">
                    <tr>
                        <th class="p-3 text-left font-semibold">Código</th>
                        <th class="p-3 text-left font-semibold">Nombre</th>
                        <th class="p-3 text-center font-semibold">Cantidad</th>
                        <th class="p-3 text-right font-semibold">Precio Unitario</th>
                        <th class="p-3 text-right font-semibold">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($venta->detalles as $detalle)
                        <tr class="border-b border-blue-100 hover:bg-blue-50 transition">
                            <td class="p-3">{{ $detalle->producto->codigo }}</td>
                            <td class="p-3">{{ $detalle->producto->nombre }}</td>
                            <td class="p-3 text-center">{{ $detalle->cantidad }}</td>
                            <td class="p-3 text-right">L. {{ number_format($detalle->precio_unitario, 2) }}</td>
                            <td class="p-3 text-right">L. {{ number_format($detalle->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-8 flex justify-end">
            <a href="{{ route('ventas.index') }}"
                class="inline-flex items-center gap-2 bg-blue-600 text-white px-5 py-2.5 rounded-lg shadow hover:bg-blue-700 transition font-semibold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Regresar al historial
            </a>
        </div>
    </div>
@endsection
