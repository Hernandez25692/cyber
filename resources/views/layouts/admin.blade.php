<!DOCTYPE html>
<html lang="es" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Panel de Administración')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Panel de administración del sistema">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" href="/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        .sidebar-transition {
            transition: all 0.3s ease-in-out;
        }
        .nav-item {
            position: relative;
        }
        .nav-item::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: currentColor;
            transition: width 0.3s ease;
        }
        .nav-item:hover::after {
            width: 100%;
        }
        .submenu-enter {
            opacity: 0;
            transform: translateY(-10px);
        }
        .submenu-enter-active {
            opacity: 1;
            transform: translateY(0);
            transition: all 0.2s ease-out;
        }
        .submenu-leave {
            opacity: 1;
            transform: translateY(0);
        }
        .submenu-leave-active {
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.2s ease-in;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen antialiased font-sans">
    <!-- Layout con sidebar y contenido -->
    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: window.innerWidth > 1024, mobileSubmenu: null }" @resize.window="sidebarOpen = window.innerWidth > 1024">
        <!-- Sidebar oscuro - Versión desktop -->
        <aside 
            class="fixed lg:static inset-y-0 left-0 z-40 w-64 bg-gray-900 text-white sidebar-transition transform lg:translate-x-0"
            :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}"
            @click.outside="if(window.innerWidth < 1024) sidebarOpen = false"
        >
            <div class="flex flex-col h-full">
                <!-- Logo y marca -->
                <div class="flex items-center justify-between h-16 px-6 py-4 border-b border-gray-800">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('storage/logo/LOGO1.png') }}" alt="Logo" class="w-10 h-10 object-contain rounded-full">
                        <span class="text-xl font-bold tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-green-400 to-blue-500">
                            Admin<span class="font-light">Pro</span>
                        </span>
                    </div>
                    <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-white">
                        <i data-feather="x"></i>
                    </button>
                </div>

                <!-- Menú principal -->
                <nav class="flex-1 overflow-y-auto py-4 px-2">
                    <div class="space-y-1">
                        <!-- Usuarios -->
                        <div x-data="{ open: false }" class="nav-item">
                            <button 
                                @click="open = !open; if(window.innerWidth < 1024) mobileSubmenu = mobileSubmenu === 'usuarios' ? null : 'usuarios'"
                                class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors duration-200"
                                :class="{'bg-gray-800': open}"
                            >
                                <div class="flex items-center">
                                    <i data-feather="users" class="w-5 h-5 mr-3"></i>
                                    <span>Usuarios</span>
                                </div>
                                <i data-feather="chevron-down" class="w-4 h-4 transition-transform duration-200" :class="{'transform rotate-180': open}"></i>
                            </button>
                            <div 
                                x-show="open || (window.innerWidth < 1024 && mobileSubmenu === 'usuarios')" 
                                x-collapse
                                class="mt-1 space-y-1 pl-12"
                            >
                                <a href="{{ route('admin.usuarios.index') }}" class="block px-3 py-2 text-sm rounded-lg hover:bg-gray-800 transition-colors duration-200">Gestión de Usuarios</a>
                            </div>
                        </div>

                        <!-- Remesas -->
                        <div x-data="{ open: false }" class="nav-item">
                            <button 
                                @click="open = !open; if(window.innerWidth < 1024) mobileSubmenu = mobileSubmenu === 'remesas' ? null : 'remesas'"
                                class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors duration-200"
                                :class="{'bg-gray-800': open}"
                            >
                                <div class="flex items-center">
                                    <i data-feather="dollar-sign" class="w-5 h-5 mr-3 text-yellow-400"></i>
                                    <span>Remesas</span>
                                </div>
                                <i data-feather="chevron-down" class="w-4 h-4 transition-transform duration-200" :class="{'transform rotate-180': open}"></i>
                            </button>
                            <div 
                                x-show="open || (window.innerWidth < 1024 && mobileSubmenu === 'remesas')" 
                                x-collapse
                                class="mt-1 space-y-1 pl-12"
                            >
                                <a href="{{ route('admin.remesas.index') }}" class="block px-3 py-2 text-sm rounded-lg hover:bg-gray-800 transition-colors duration-200">Gestión de Remesas</a>
                                <a href="{{ route('admin.reportes.remesas') }}" class="block px-3 py-2 text-sm rounded-lg hover:bg-gray-800 transition-colors duration-200">Reportes de Remesas</a>
                            </div>
                        </div>

                        <!-- Retiros -->
                        <div x-data="{ open: false }" class="nav-item">
                            <button 
                                @click="open = !open; if(window.innerWidth < 1024) mobileSubmenu = mobileSubmenu === 'retiros' ? null : 'retiros'"
                                class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors duration-200"
                                :class="{'bg-gray-800': open}"
                            >
                                <div class="flex items-center">
                                    <i data-feather="credit-card" class="w-5 h-5 mr-3 text-green-400"></i>
                                    <span>Retiros</span>
                                </div>
                                <i data-feather="chevron-down" class="w-4 h-4 transition-transform duration-200" :class="{'transform rotate-180': open}"></i>
                            </button>
                            <div 
                                x-show="open || (window.innerWidth < 1024 && mobileSubmenu === 'retiros')" 
                                x-collapse
                                class="mt-1 space-y-1 pl-12"
                            >
                                <a href="{{ route('admin.retiros.config.index') }}" class="block px-3 py-2 text-sm rounded-lg hover:bg-gray-800 transition-colors duration-200">Configurar Comisión</a>
                                <a href="{{ route('admin.retiros.reportes') }}" class="block px-3 py-2 text-sm rounded-lg hover:bg-gray-800 transition-colors duration-200">Reporte de Retiros</a>
                            </div>
                        </div>

                        <!-- Servicios -->
                        <div x-data="{ open: false }" class="nav-item">
                            <button 
                                @click="open = !open; if(window.innerWidth < 1024) mobileSubmenu = mobileSubmenu === 'servicios' ? null : 'servicios'"
                                class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors duration-200"
                                :class="{'bg-gray-800': open}"
                            >
                                <div class="flex items-center">
                                    <i data-feather="zap" class="w-5 h-5 mr-3 text-pink-400"></i>
                                    <span>Servicios</span>
                                </div>
                                <i data-feather="chevron-down" class="w-4 h-4 transition-transform duration-200" :class="{'transform rotate-180': open}"></i>
                            </button>
                            <div 
                                x-show="open || (window.innerWidth < 1024 && mobileSubmenu === 'servicios')" 
                                x-collapse
                                class="mt-1 space-y-1 pl-12"
                            >
                                <a href="{{ route('admin.servicios.tipos.index') }}" class="block px-3 py-2 text-sm rounded-lg hover:bg-gray-800 transition-colors duration-200">Tipos de Servicio</a>
                                <a href="{{ route('admin.servicios.bancos.index') }}" class="block px-3 py-2 text-sm rounded-lg hover:bg-gray-800 transition-colors duration-200">Bancos</a>
                                <a href="{{ route('admin.servicios.config.index') }}" class="block px-3 py-2 text-sm rounded-lg hover:bg-gray-800 transition-colors duration-200">Configuración</a>
                                <a href="{{ route('admin.reporte.servicios') }}" class="block px-3 py-2 text-sm rounded-lg hover:bg-gray-800 transition-colors duration-200">Reporte de Servicios</a>
                            </div>
                        </div>

                        <!-- Recargas -->
                        <div x-data="{ open: false }" class="nav-item">
                            <button 
                                @click="open = !open; if(window.innerWidth < 1024) mobileSubmenu = mobileSubmenu === 'recargas' ? null : 'recargas'"
                                class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors duration-200"
                                :class="{'bg-gray-800': open}"
                            >
                                <div class="flex items-center">
                                    <i data-feather="smartphone" class="w-5 h-5 mr-3 text-indigo-400"></i>
                                    <span>Recargas</span>
                                </div>
                                <i data-feather="chevron-down" class="w-4 h-4 transition-transform duration-200" :class="{'transform rotate-180': open}"></i>
                            </button>
                            <div 
                                x-show="open || (window.innerWidth < 1024 && mobileSubmenu === 'recargas')" 
                                x-collapse
                                class="mt-1 space-y-1 pl-12"
                            >
                                <a href="{{ route('admin.recargas.proveedores.index') }}" class="block px-3 py-2 text-sm rounded-lg hover:bg-gray-800 transition-colors duration-200">Proveedores</a>
                                <a href="{{ route('admin.recargas.paquetes.index') }}" class="block px-3 py-2 text-sm rounded-lg hover:bg-gray-800 transition-colors duration-200">Paquetes</a>
                                <a href="{{ route('admin.reportes.recargas') }}" class="block px-3 py-2 text-sm rounded-lg hover:bg-gray-800 transition-colors duration-200">Reportes</a>
                            </div>
                        </div>

                        <!-- Impresiones -->
                        <div x-data="{ open: false }" class="nav-item">
                            <button 
                                @click="open = !open; if(window.innerWidth < 1024) mobileSubmenu = mobileSubmenu === 'impresiones' ? null : 'impresiones'"
                                class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors duration-200"
                                :class="{'bg-gray-800': open}"
                            >
                                <div class="flex items-center">
                                    <i data-feather="printer" class="w-5 h-5 mr-3 text-yellow-400"></i>
                                    <span>Impresiones</span>
                                </div>
                                <i data-feather="chevron-down" class="w-4 h-4 transition-transform duration-200" :class="{'transform rotate-180': open}"></i>
                            </button>
                            <div 
                                x-show="open || (window.innerWidth < 1024 && mobileSubmenu === 'impresiones')" 
                                x-collapse
                                class="mt-1 space-y-1 pl-12"
                            >
                                <a href="{{ route('admin.impresiones.servicios.index') }}" class="block px-3 py-2 text-sm rounded-lg hover:bg-gray-800 transition-colors duration-200">Servicios</a>
                                <a href="{{ route('admin.impresiones.tipos.index') }}" class="block px-3 py-2 text-sm rounded-lg hover:bg-gray-800 transition-colors duration-200">Tipos</a>
                                <a href="{{ route('reportes.impresiones') }}" class="block px-3 py-2 text-sm rounded-lg hover:bg-gray-800 transition-colors duration-200">Reportes</a>
                            </div>
                        </div>

                        <!-- Inventario -->
                        <div x-data="{ open: false }" class="nav-item">
                            <button 
                                @click="open = !open; if(window.innerWidth < 1024) mobileSubmenu = mobileSubmenu === 'inventario' ? null : 'inventario'"
                                class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors duration-200"
                                :class="{'bg-gray-800': open}"
                            >
                                <div class="flex items-center">
                                    <i data-feather="package" class="w-5 h-5 mr-3 text-green-400"></i>
                                    <span>Inventario</span>
                                </div>
                                <i data-feather="chevron-down" class="w-4 h-4 transition-transform duration-200" :class="{'transform rotate-180': open}"></i>
                            </button>
                            <div 
                                x-show="open || (window.innerWidth < 1024 && mobileSubmenu === 'inventario')" 
                                x-collapse
                                class="mt-1 space-y-1 pl-12"
                            >
                                <a href="{{ route('admin.inventario.index') }}" class="block px-3 py-2 text-sm rounded-lg hover:bg-gray-800 transition-colors duration-200">Gestionar Inventario</a>
                                <a href="{{ route('inventario.entrada') }}" class="block px-3 py-2 text-sm rounded-lg hover:bg-gray-800 transition-colors duration-200">Ingreso de Inventario</a>
                                <a href="{{ route('ordenes-entrada.index') }}" class="block px-3 py-2 text-sm rounded-lg hover:bg-gray-800 transition-colors duration-200">Historial de Órdenes</a>
                                <div class="border-t border-gray-700 my-1"></div>
                                <a href="{{ route('ajustes.formulario') }}" class="block px-3 py-2 text-sm rounded-lg hover:bg-gray-800 transition-colors duration-200">Ajuste de Inventario</a>
                                <a href="{{ route('ajustes.historial') }}" class="block px-3 py-2 text-sm rounded-lg hover:bg-gray-800 transition-colors duration-200">Historial de Ajustes</a>
                                <a href="{{ route('inventario.sugerencias') }}" class="block px-3 py-2 text-sm rounded-lg hover:bg-gray-800 transition-colors duration-200">Sugerencias de Pedido</a>
                            </div>
                        </div>

                        <!-- Comisiones -->
                        <div x-data="{ open: false }" class="nav-item">
                            <button 
                                @click="open = !open; if(window.innerWidth < 1024) mobileSubmenu = mobileSubmenu === 'comisiones' ? null : 'comisiones'"
                                class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors duration-200"
                                :class="{'bg-gray-800': open}"
                            >
                                <div class="flex items-center">
                                    <i data-feather="award" class="w-5 h-5 mr-3 text-purple-400"></i>
                                    <span>Comisiones</span>
                                </div>
                                <i data-feather="chevron-down" class="w-4 h-4 transition-transform duration-200" :class="{'transform rotate-180': open}"></i>
                            </button>
                            <div 
                                x-show="open || (window.innerWidth < 1024 && mobileSubmenu === 'comisiones')" 
                                x-collapse
                                class="mt-1 space-y-1 pl-12"
                            >
                                <a href="#" class="block px-3 py-2 text-sm rounded-lg hover:bg-gray-800 transition-colors duration-200">Comisiones y Servicios</a>
                                <a href="#" class="block px-3 py-2 text-sm rounded-lg hover:bg-gray-800 transition-colors duration-200">Reportes</a>
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- Pie de sidebar -->
                <div class="p-4 border-t border-gray-800">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center px-4 py-2 text-sm font-medium text-red-400 hover:text-red-300 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                            <i data-feather="log-out" class="w-4 h-4 mr-2"></i>
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Contenido principal -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Barra superior -->
            <header class="bg-white shadow-sm z-30">
                <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                    <!-- Botón para abrir sidebar en móvil -->
                    <button 
                        @click="sidebarOpen = true" 
                        class="lg:hidden text-gray-500 hover:text-gray-600 focus:outline-none"
                    >
                        <i data-feather="menu"></i>
                    </button>

                    <!-- Espacio para breadcrumbs o título -->
                    <div class="flex-1 ml-4">
                        <h1 class="text-lg font-semibold text-gray-900">@yield('title', 'Panel de Administración')</h1>
                    </div>

                    <!-- Menú usuario -->
                    <div class="flex items-center space-x-4">
                        <div class="relative" x-data="{ open: false }">
                            <button 
                                @click="open = !open" 
                                class="flex items-center space-x-2 focus:outline-none"
                            >
                                <div class="h-8 w-8 rounded-full bg-gradient-to-r from-green-400 to-blue-500 flex items-center justify-center text-white font-semibold">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span class="hidden md:inline text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                                <i data-feather="chevron-down" class="hidden md:inline w-4 h-4 text-gray-500"></i>
                            </button>
                            
                            <div 
                                x-show="open" 
                                @click.outside="open = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
                                x-cloak
                            >
                                <div class="py-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Cerrar sesión
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Contenido -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50">
                <!-- Alertas -->
                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <i data-feather="check-circle" class="h-5 w-5 text-green-500 mr-3"></i>
                            <p class="font-medium text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <i data-feather="alert-circle" class="h-5 w-5 text-red-500 mr-3"></i>
                            <p class="font-medium text-red-700">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                <!-- Contenido principal -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Script para inicializar Feather Icons -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
            
            // Actualizar Feather Icons cuando Alpine.js actualice el DOM
            document.addEventListener('alpine:init', () => {
                Alpine.effect(() => {
                    Alpine.store('sidebarOpen');
                    setTimeout(() => feather.replace(), 10);
                });
            });
        });
    </script>
    
    @yield('scripts')
</body>
</html>