@extends('layouts.admin')

@section('title', 'Panel de Administración')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-blue-100 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10">
                <div>
                    <h1 class="text-4xl font-extrabold text-indigo-900 tracking-tight drop-shadow">Panel de Administración</h1>
                    <p class="mt-2 text-gray-600 text-lg">Gestión integral de todos los servicios</p>
                </div>
                <div class="mt-4 md:mt-0 flex flex-col md:flex-row gap-2">
                    <a href="{{ route('admin.reportes.general') }}"
                        class="inline-flex items-center px-5 py-2 bg-white border border-gray-300 rounded-lg shadow text-base font-semibold text-gray-700 hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        <i data-feather="bar-chart-2" class="w-5 h-5 mr-2"></i>
                        Reporte Servicios
                    </a>
                    <a href="{{ route('admin.reportes.cyber') }}"
                        class="inline-flex items-center px-5 py-2 bg-indigo-600 border border-indigo-200 rounded-lg shadow text-base font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        <i data-feather="activity" class="w-5 h-5 mr-2"></i>
                        Reporte General Cyber
                    </a>
                </div>
            </div>

            <!-- Dashboard Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Usuarios Card -->
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-200 border-t-4 border-blue-500 group">
                    <div class="p-7">
                        <div class="flex items-center mb-5">
                            <div class="p-4 rounded-xl bg-blue-100 text-blue-600 group-hover:bg-blue-200 transition">
                                <i data-feather="users" class="w-7 h-7"></i>
                            </div>
                            <h2 class="ml-5 text-xl font-bold text-gray-800">Gestión de Usuarios</h2>
                        </div>
                        <a href="{{ route('admin.usuarios.index') }}"
                            class="inline-flex items-center justify-center w-full px-5 py-3 border border-transparent text-base font-semibold rounded-lg shadow text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                            Acceder al módulo
                        </a>
                    </div>
                </div>

                <!-- Remesas Card -->
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-200 border-t-4 border-yellow-400 group">
                    <div class="p-7">
                        <div class="flex items-center mb-5">
                            <div class="p-4 rounded-xl bg-yellow-100 text-yellow-600 group-hover:bg-yellow-200 transition">
                                <i data-feather="dollar-sign" class="w-7 h-7"></i>
                            </div>
                            <h2 class="ml-5 text-xl font-bold text-gray-800">Remesas</h2>
                        </div>
                        <div class="space-y-4">
                            <a href="{{ route('admin.remesas.index') }}"
                                class="inline-flex items-center justify-center w-full px-5 py-3 border border-transparent text-base font-semibold rounded-lg shadow text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition">
                                Gestión de Remesas
                            </a>
                            <a href="{{ route('admin.reportes.remesas') }}"
                                class="inline-flex items-center justify-center w-full px-5 py-3 border border-transparent text-base font-semibold rounded-lg shadow text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition">
                                Reportes de Remesas
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Retiros Card -->
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-200 border-t-4 border-green-500 group">
                    <div class="p-7">
                        <div class="flex items-center mb-5">
                            <div class="p-4 rounded-xl bg-green-100 text-green-600 group-hover:bg-green-200 transition">
                                <i data-feather="credit-card" class="w-7 h-7"></i>
                            </div>
                            <h2 class="ml-5 text-xl font-bold text-gray-800">Retiros</h2>
                        </div>
                        <div class="space-y-4">
                            <a href="{{ route('admin.retiros.config.index') }}"
                                class="inline-flex items-center justify-center w-full px-5 py-3 border border-transparent text-base font-semibold rounded-lg shadow text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition">
                                Configurar Comisión
                            </a>
                            <a href="{{ route('admin.retiros.reportes') }}"
                                class="inline-flex items-center justify-center w-full px-5 py-3 border border-transparent text-base font-semibold rounded-lg shadow text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                                Reporte de Retiros
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Servicios Card -->
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-200 border-t-4 border-pink-400 group">
                    <div class="p-7">
                        <div class="flex items-center mb-5">
                            <div class="p-4 rounded-xl bg-pink-100 text-pink-600 group-hover:bg-pink-200 transition">
                                <i data-feather="zap" class="w-7 h-7"></i>
                            </div>
                            <h2 class="ml-5 text-xl font-bold text-gray-800">Servicios</h2>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('admin.servicios.tipos.index') }}"
                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-semibold rounded shadow text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition">
                                Tipos
                            </a>
                            <a href="{{ route('admin.servicios.bancos.index') }}"
                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-semibold rounded shadow text-white bg-pink-500 hover:bg-pink-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition">
                                Bancos
                            </a>
                            <a href="{{ route('admin.servicios.config.index') }}"
                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-semibold rounded shadow text-white bg-pink-700 hover:bg-pink-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition">
                                Configuración
                            </a>
                            <a href="{{ route('admin.reporte.servicios') }}"
                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-semibold rounded shadow text-white bg-pink-400 hover:bg-pink-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition">
                                Reportes
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Recargas Card -->
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-200 border-t-4 border-indigo-500 group">
                    <div class="p-7">
                        <div class="flex items-center mb-5">
                            <div class="p-4 rounded-xl bg-indigo-100 text-indigo-600 group-hover:bg-indigo-200 transition">
                                <i data-feather="smartphone" class="w-7 h-7"></i>
                            </div>
                            <h2 class="ml-5 text-xl font-bold text-gray-800">Recargas</h2>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('admin.recargas.proveedores.index') }}"
                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-semibold rounded shadow text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                                Proveedores
                            </a>
                            <a href="{{ route('admin.recargas.paquetes.index') }}"
                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-semibold rounded shadow text-white bg-indigo-500 hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                                Paquetes
                            </a>
                            <a href="{{ route('admin.reportes.recargas') }}"
                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-semibold rounded shadow text-white bg-indigo-700 hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition col-span-2">
                                Reportes
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Impresiones Card -->
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-200 border-t-4 border-yellow-500 group">
                    <div class="p-7">
                        <div class="flex items-center mb-5">
                            <div class="p-4 rounded-xl bg-yellow-100 text-yellow-600 group-hover:bg-yellow-200 transition">
                                <i data-feather="printer" class="w-7 h-7"></i>
                            </div>
                            <h2 class="ml-5 text-xl font-bold text-gray-800">Impresiones</h2>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('admin.impresiones.servicios.index') }}"
                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-semibold rounded shadow text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition">
                                Servicios
                            </a>
                            <a href="{{ route('admin.impresiones.tipos.index') }}"
                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-semibold rounded shadow text-white bg-yellow-700 hover:bg-yellow-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition">
                                Tipos
                            </a>
                            <a href="{{ route('reportes.impresiones') }}"
                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-semibold rounded shadow text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition col-span-2">
                                Reportes
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Inventario Card -->
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-200 border-t-4 border-green-400 group">
                    <div class="p-7">
                        <div class="flex items-center mb-5">
                            <div class="p-4 rounded-xl bg-green-100 text-green-600 group-hover:bg-green-200 transition">
                                <i data-feather="package" class="w-7 h-7"></i>
                            </div>
                            <h2 class="ml-5 text-xl font-bold text-gray-800">Inventario</h2>
                        </div>
                        <div class="space-y-4">
                            <a href="{{ route('admin.inventario.index') }}"
                                class="inline-flex items-center justify-center w-full px-5 py-3 border border-transparent text-base font-semibold rounded-lg shadow text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition">
                                Gestionar Inventario
                            </a>
                            <div class="grid grid-cols-2 gap-3">
                                <a href="{{ route('inventario.entrada') }}"
                                    class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-semibold rounded shadow text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                                    <i data-feather="plus" class="w-4 h-4 mr-1"></i> Ingreso
                                </a>
                                <a href="{{ route('ordenes-entrada.index') }}"
                                    class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-semibold rounded shadow text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition">
                                    <i data-feather="list" class="w-4 h-4 mr-1"></i> Historial
                                </a>
                            </div>
                            <div class="pt-3 border-t border-gray-200">
                                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Ajustes</h3>
                                <div class="grid grid-cols-2 gap-3">
                                    <a href="{{ route('ajustes.formulario') }}"
                                        class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-semibold rounded shadow text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition">
                                        <i data-feather="edit" class="w-4 h-4 mr-1"></i> Ajustar
                                    </a>
                                    <a href="{{ route('ajustes.historial') }}"
                                        class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-semibold rounded shadow text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition">
                                        <i data-feather="file-text" class="w-4 h-4 mr-1"></i> Historial
                                    </a>
                                    <a href="{{ route('inventario.sugerencias') }}"
                                        class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-semibold rounded shadow text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition col-span-2">
                                        <i data-feather="shopping-cart" class="w-4 h-4 mr-1"></i> Sugerencias
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Animación de entrada para las tarjetas -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
            document.querySelectorAll('.group').forEach((card, i) => {
                card.style.opacity = 0;
                card.style.transform = 'translateY(30px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.5s cubic-bezier(.4,2,.3,1)';
                    card.style.opacity = 1;
                    card.style.transform = 'translateY(0)';
                }, 100 + i * 120);
            });
        });
    </script>
@endsection
