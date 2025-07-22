@extends('layouts.admin')

@section('title', 'Panel de Administración')

@section('content')
    <h1 class="text-3xl font-bold text-green-700 mb-8">👨‍💼 Panel de Administración</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

        {{-- Gestión de Usuarios --}}
        <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center">
            <h2 class="text-lg font-semibold text-blue-700 mb-4">Usuarios</h2>
            <a href="{{ route('admin.usuarios.index') }}"
                class="bg-blue-600 text-white w-full py-3 rounded-lg shadow hover:bg-blue-700 transition font-semibold mb-2 flex items-center justify-center gap-2">
                👥 Gestión de Usuarios
            </a>
        </div>

        {{-- Remesas --}}
        <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center">
            <h2 class="text-lg font-semibold text-yellow-700 mb-4">Remesas</h2>
            <a href="{{ route('admin.remesas.index') }}"
                class="bg-yellow-500 text-white w-full py-3 rounded-lg shadow hover:bg-yellow-600 transition font-semibold mb-2 flex items-center justify-center gap-2">
                💰 Remesas
            </a>
            <a href="{{ route('admin.reportes.remesas') }}"
                class="bg-purple-600 text-white w-full py-3 rounded-lg shadow hover:bg-purple-700 transition font-semibold mb-2 flex items-center justify-center gap-2">
                📈 Reportes de Remesas
            </a>
        </div>

        {{-- Retiros --}}
        <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center">
            <h2 class="text-lg font-semibold text-green-700 mb-4">Retiros</h2>
            <a href="{{ route('admin.retiros.config.index') }}"
                class="bg-green-600 text-white w-full py-3 rounded-lg shadow hover:bg-green-700 transition font-semibold mb-2 flex items-center justify-center gap-2">
                🛠️ Configurar Comisión
            </a>
            <a href="{{ route('admin.retiros.reportes') }}"
                class="bg-indigo-600 text-white w-full py-3 rounded-lg shadow hover:bg-indigo-700 transition font-semibold mb-2 flex items-center justify-center gap-2">
                📊 Reporte de Retiros
            </a>
            <a href="{{ route('admin.reportes.retiros') }}"
                class="bg-indigo-600 text-white w-full py-3 rounded-lg shadow hover:bg-indigo-700 transition font-semibold mb-2 flex items-center justify-center gap-2">
                🏧 Reportes de Retiros
            </a>
        </div>

        {{-- Servicios --}}
        <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center">
            <h2 class="text-lg font-semibold text-pink-700 mb-4">Servicios</h2>
            <a href="{{ route('admin.servicios.tipos.index') }}"
                class="bg-pink-600 text-white w-full py-3 rounded-lg shadow hover:bg-pink-700 transition font-semibold mb-2 flex items-center justify-center gap-2">
                🗂️ Tipos de Servicio
            </a>
            <a href="{{ route('admin.servicios.bancos.index') }}"
                class="bg-pink-600 text-white w-full py-3 rounded-lg shadow hover:bg-pink-700 transition font-semibold mb-2 flex items-center justify-center gap-2">
                🏦 Bancos
            </a>
            <a href="{{ route('admin.servicios.config.index') }}"
                class="bg-pink-600 text-white w-full py-3 rounded-lg shadow hover:bg-pink-700 transition font-semibold mb-2 flex items-center justify-center gap-2">
                ⚙️ Configuración de Servicios
            </a>
            <a href="{{ route('admin.reporte.servicios') }}"
                class="bg-pink-600 text-white w-full py-3 rounded-lg shadow hover:bg-pink-700 transition font-semibold mb-2 flex items-center justify-center gap-2">
                📝 Reporte de Servicios
            </a>
        </div>
        {{-- Recargas --}}
        <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center">
            <h2 class="text-lg font-semibold text-indigo-700 mb-4">Recargas</h2>
            <a href="{{ route('admin.recargas.proveedores.index') }}"
                class="bg-indigo-600 text-white w-full py-3 rounded-lg shadow hover:bg-indigo-700 transition font-semibold mb-2 flex items-center justify-center gap-2">
                🏬 Proveedores Recarga
            </a>
            <a href="{{ route('admin.recargas.paquetes.index') }}"
                class="bg-indigo-600 text-white w-full py-3 rounded-lg shadow hover:bg-indigo-700 transition font-semibold mb-2 flex items-center justify-center gap-2">
                📦 Paquetes Recarga
            </a>
            <a href="{{ route('admin.reportes.recargas') }}"
                class="bg-indigo-600 text-white w-full py-3 rounded-lg shadow hover:bg-indigo-700 transition font-semibold flex items-center justify-center gap-2">
                📊 Reporte Recargas
            </a>
        </div>

        {{-- Impresiones --}}
        <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center">
            <h2 class="text-lg font-semibold text-yellow-800 mb-4">Impresiones</h2>
            <a href="{{ route('admin.impresiones.servicios.index') }}"
                class="bg-yellow-600 text-white w-full py-3 rounded-lg shadow hover:bg-yellow-700 transition font-semibold mb-2 flex items-center justify-center gap-2">
                🖨 Servicios de Impresión
            </a>
            <a href="{{ route('admin.impresiones.tipos.index') }}"
                class="bg-yellow-700 text-white w-full py-3 rounded-lg shadow hover:bg-yellow-800 transition font-semibold flex items-center justify-center gap-2">
                🎨 Tipos de Impresión
            </a>
            <a href="{{ route('reportes.impresiones') }}"
                class="bg-yellow-600 text-white p-6 rounded-xl shadow hover:bg-yellow-700 transition font-semibold">
                📊 Reporte Impresiones
            </a>

        </div>
        {{-- Inventario --}}
        <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center">
            <h2 class="text-lg font-semibold text-green-700 mb-4">Inventario</h2>
            <a href="{{ route('admin.inventario.index') }}"
                class="bg-green-600 text-white w-full py-3 rounded-lg shadow hover:bg-green-700 transition font-semibold flex items-center justify-center gap-2">
                📦 Inventario
            </a>
        </div>

        {{-- Comisiones y Otros --}}
        <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center">
            <h2 class="text-lg font-semibold text-yellow-700 mb-4">Comisiones y Otros</h2>
            <a href="#"
                class="bg-yellow-500 text-white w-full py-3 rounded-lg shadow hover:bg-yellow-600 transition font-semibold flex items-center justify-center gap-2">
                💰 Comisiones y Servicios
            </a>
            <a href="#"
                class="bg-purple-600 text-white w-full py-3 rounded-lg shadow hover:bg-purple-700 transition font-semibold flex items-center justify-center gap-2">
                📈 Reportes
            </a>
        </div>

        {{-- Cerrar sesión --}}
        <div class="col-span-1 md:col-span-2 lg:col-span-3 flex justify-end">
            <form method="POST" action="{{ route('logout') }}" class="w-full md:w-1/3">
                @csrf
                <button type="submit"
                    class="w-full bg-red-600 text-white py-4 rounded-xl shadow hover:bg-red-700 transition font-semibold flex items-center justify-center gap-2">
                    🚪 Cerrar sesión
                </button>
            </form>
        </div>
    </div>
@endsection
