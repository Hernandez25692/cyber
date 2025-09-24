@extends('layouts.admin')

@section('title', 'Panel de Administración')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Panel de Administración</h1>
                    <p class="mt-2 text-gray-600">Gestión integral de todos los servicios</p>
                </div>
                <div class="mt-4 md:mt-0 flex flex-col md:flex-row gap-2">
                    <a href="{{ route('admin.reportes.general') }}"
                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <i data-feather="bar-chart-2" class="w-4 h-4 mr-2"></i>
                        Reporte Servicios
                    </a>
                    <a href="{{ route('admin.reportes.cyber') }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-50 border border-indigo-200 rounded-md shadow-sm text-sm font-medium text-indigo-700 hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                        <i data-feather="activity" class="w-4 h-4 mr-2"></i>
                        Reporte General Cyber
                    </a>
                    
                </div>
            </div>

            <!-- Dashboard Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Usuarios Card -->
                <div class="bg-white rounded-lg shadow overflow-hidden transition-all duration-200 hover:shadow-md">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="p-3 rounded-lg bg-blue-50 text-blue-600">
                                <i data-feather="users" class="w-6 h-6"></i>
                            </div>
                            <h2 class="ml-4 text-lg font-semibold text-gray-800">Gestión de Usuarios</h2>
                        </div>
                        <a href="{{ route('admin.usuarios.index') }}"
                            class="inline-flex items-center justify-center w-full px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            Acceder al módulo
                        </a>
                    </div>
                </div>

                <!-- Remesas Card -->
                <div class="bg-white rounded-lg shadow overflow-hidden transition-all duration-200 hover:shadow-md">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="p-3 rounded-lg bg-yellow-50 text-yellow-600">
                                <i data-feather="dollar-sign" class="w-6 h-6"></i>
                            </div>
                            <h2 class="ml-4 text-lg font-semibold text-gray-800">Remesas</h2>
                        </div>
                        <div class="space-y-3">
                            <a href="{{ route('admin.remesas.index') }}"
                                class="inline-flex items-center justify-center w-full px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors duration-200">
                                Gestión de Remesas
                            </a>
                            <a href="{{ route('admin.reportes.remesas') }}"
                                class="inline-flex items-center justify-center w-full px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors duration-200">
                                Reportes de Remesas
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Retiros Card -->
                <div class="bg-white rounded-lg shadow overflow-hidden transition-all duration-200 hover:shadow-md">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="p-3 rounded-lg bg-green-50 text-green-600">
                                <i data-feather="credit-card" class="w-6 h-6"></i>
                            </div>
                            <h2 class="ml-4 text-lg font-semibold text-gray-800">Retiros</h2>
                        </div>
                        <div class="space-y-3">
                            <a href="{{ route('admin.retiros.config.index') }}"
                                class="inline-flex items-center justify-center w-full px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                Configurar Comisión
                            </a>
                            <a href="{{ route('admin.retiros.reportes') }}"
                                class="inline-flex items-center justify-center w-full px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                Reporte de Retiros
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Servicios Card -->
                <div class="bg-white rounded-lg shadow overflow-hidden transition-all duration-200 hover:shadow-md">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="p-3 rounded-lg bg-pink-50 text-pink-600">
                                <i data-feather="zap" class="w-6 h-6"></i>
                            </div>
                            <h2 class="ml-4 text-lg font-semibold text-gray-800">Servicios</h2>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <a href="{{ route('admin.servicios.tipos.index') }}"
                                class="inline-flex items-center justify-center px-3 py-2 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-colors duration-200">
                                Tipos
                            </a>
                            <a href="{{ route('admin.servicios.bancos.index') }}"
                                class="inline-flex items-center justify-center px-3 py-2 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-pink-500 hover:bg-pink-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-colors duration-200">
                                Bancos
                            </a>
                            <a href="{{ route('admin.servicios.config.index') }}"
                                class="inline-flex items-center justify-center px-3 py-2 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-pink-700 hover:bg-pink-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-colors duration-200">
                                Configuración
                            </a>
                            <a href="{{ route('admin.reporte.servicios') }}"
                                class="inline-flex items-center justify-center px-3 py-2 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-pink-400 hover:bg-pink-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-colors duration-200">
                                Reportes
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Recargas Card -->
                <div class="bg-white rounded-lg shadow overflow-hidden transition-all duration-200 hover:shadow-md">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="p-3 rounded-lg bg-indigo-50 text-indigo-600">
                                <i data-feather="smartphone" class="w-6 h-6"></i>
                            </div>
                            <h2 class="ml-4 text-lg font-semibold text-gray-800">Recargas</h2>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <a href="{{ route('admin.recargas.proveedores.index') }}"
                                class="inline-flex items-center justify-center px-3 py-2 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                Proveedores
                            </a>
                            <a href="{{ route('admin.recargas.paquetes.index') }}"
                                class="inline-flex items-center justify-center px-3 py-2 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-indigo-500 hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                Paquetes
                            </a>
                            <a href="{{ route('admin.reportes.recargas') }}"
                                class="inline-flex items-center justify-center px-3 py-2 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-indigo-700 hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200 col-span-2">
                                Reportes
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Impresiones Card -->
                <div class="bg-white rounded-lg shadow overflow-hidden transition-all duration-200 hover:shadow-md">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="p-3 rounded-lg bg-yellow-50 text-yellow-600">
                                <i data-feather="printer" class="w-6 h-6"></i>
                            </div>
                            <h2 class="ml-4 text-lg font-semibold text-gray-800">Impresiones</h2>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <a href="{{ route('admin.impresiones.servicios.index') }}"
                                class="inline-flex items-center justify-center px-3 py-2 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors duration-200">
                                Servicios
                            </a>
                            <a href="{{ route('admin.impresiones.tipos.index') }}"
                                class="inline-flex items-center justify-center px-3 py-2 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-yellow-700 hover:bg-yellow-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors duration-200">
                                Tipos
                            </a>
                            <a href="{{ route('reportes.impresiones') }}"
                                class="inline-flex items-center justify-center px-3 py-2 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors duration-200 col-span-2">
                                Reportes
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Inventario Card -->
                <div class="bg-white rounded-lg shadow overflow-hidden transition-all duration-200 hover:shadow-md">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="p-3 rounded-lg bg-green-50 text-green-600">
                                <i data-feather="package" class="w-6 h-6"></i>
                            </div>
                            <h2 class="ml-4 text-lg font-semibold text-gray-800">Inventario</h2>
                        </div>
                        <div class="space-y-3">
                            <a href="{{ route('admin.inventario.index') }}"
                                class="inline-flex items-center justify-center w-full px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                Gestionar Inventario
                            </a>
                            <div class="grid grid-cols-2 gap-2">
                                <a href="{{ route('inventario.entrada') }}"
                                    class="inline-flex items-center justify-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                    <i data-feather="plus" class="w-3 h-3 mr-1"></i> Ingreso
                                </a>
                                <a href="{{ route('ordenes-entrada.index') }}"
                                    class="inline-flex items-center justify-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                                    <i data-feather="list" class="w-3 h-3 mr-1"></i> Historial
                                </a>
                            </div>
                            <div class="pt-2 border-t border-gray-200">
                                <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Ajustes</h3>
                                <div class="grid grid-cols-2 gap-2">
                                    <a href="{{ route('ajustes.formulario') }}"
                                        class="inline-flex items-center justify-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                                        <i data-feather="edit" class="w-3 h-3 mr-1"></i> Ajustar
                                    </a>
                                    <a href="{{ route('ajustes.historial') }}"
                                        class="inline-flex items-center justify-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                                        <i data-feather="file-text" class="w-3 h-3 mr-1"></i> Historial
                                    </a>
                                    <a href="{{ route('inventario.sugerencias') }}"
                                        class="inline-flex items-center justify-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200 col-span-2">
                                        <i data-feather="shopping-cart" class="w-3 h-3 mr-1"></i> Sugerencias
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Comisiones Card -->
                <div class="bg-white rounded-lg shadow overflow-hidden transition-all duration-200 hover:shadow-md">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="p-3 rounded-lg bg-purple-50 text-purple-600">
                                <i data-feather="award" class="w-6 h-6"></i>
                            </div>
                            <h2 class="ml-4 text-lg font-semibold text-gray-800">Comisiones</h2>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <a href="#"
                                class="inline-flex items-center justify-center px-3 py-2 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors duration-200">
                                Comisiones
                            </a>
                            <a href="#"
                                class="inline-flex items-center justify-center px-3 py-2 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-purple-500 hover:bg-purple-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors duration-200">
                                Reportes
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
        });
    </script>
@endsection
