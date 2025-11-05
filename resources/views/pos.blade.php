<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Punto de Venta - Cyber</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100">

    <div class="p-6 bg-gradient-to-br from-green-50 via-white to-indigo-100 min-h-[calc(100vh-5rem)]"
        x-data="posApp()">
        @php
            $turnoAbierto = \App\Models\Apertura::abiertaPara(auth()->id()) !== null;
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 h-[calc(100vh-10rem)]">
            <!-- FACTURACIÓN -->
            <div
                class="col-span-2 bg-white rounded-2xl shadow-lg flex flex-col h-full p-6 overflow-hidden border border-green-100">
                <div class="flex items-center gap-3 mb-4">
                    <input type="text" x-model="search" @keydown.enter.prevent="addProducto()"
                        placeholder="Buscar por código o nombre"
                        class="w-full border-2 border-green-300 focus:border-green-500 p-3 rounded-lg text-lg shadow-sm transition"
                        autofocus>
                    <button @click="addProducto()"
                        class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg font-bold shadow transition">
                        <svg class="w-6 h-6 inline" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Agregar
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto border rounded-lg bg-gray-50 shadow-inner">
                    <table class="w-full text-base">
                        <thead class="sticky top-0 bg-green-100 z-10">
                            <tr>
                                <th class="p-3 border-b">Código</th>
                                <th class="p-3 border-b">Nombre</th>
                                <th class="p-3 border-b">Cant</th>
                                <th class="p-3 border-b">Precio</th>
                                <th class="p-3 border-b">Subtotal</th>
                                <th class="p-3 border-b">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-if="carrito.length === 0">
                                <tr>
                                    <td colspan="6" class="text-center py-8 text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <img src="{{ asset('storage/logo/logo1.png') }}" alt="Logo Cyber"
                                                class="mx-auto mb-5 w-52 h-52 object-contain opacity-80">
                                            <span class="text-lg font-semibold">No hay productos a facturar.</span>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                            <template x-for="(item, index) in carrito" :key="index">
                                <tr class="hover:bg-green-50 transition">
                                    <td class="border-b p-3 font-mono text-green-700" x-text="item.codigo"></td>
                                    <td class="border-b p-3" x-text="item.nombre"></td>
                                    <td class="border-b p-3 text-center">
                                        <input type="number" class="w-16 border rounded text-center bg-white"
                                            x-model.number="item.cantidad" min="1"
                                            @input="if(item.cantidad < 1) item.cantidad = 1; calcularTotal()">
                                    </td>
                                    <td class="border-b p-3 text-right font-semibold text-green-700"
                                        x-text="`L. ${item.precio.toFixed(2)}`"></td>
                                    <td class="border-b p-3 text-right font-bold text-indigo-700"
                                        x-text="`L. ${(item.precio * item.cantidad).toFixed(2)}`"></td>
                                    <td class="border-b p-3 text-center">
                                        <button @click="quitarProducto(index)"
                                            class="text-red-600 hover:text-red-800 transition" title="Eliminar">
                                            <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor"
                                                stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2"></path>
                                                <rect x="5" y="6" width="14" height="14" rx="2"></rect>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 11v6m4-6v6">
                                                </path>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-between items-center text-2xl font-bold pt-6 border-t mt-5">
                    <span>Total:</span>
                    <span class="text-green-700" x-text="`L. ${total.toFixed(2)}`"></span>
                </div>
            </div>

            <!-- MENÚ LATERAL MEJORADO -->
            <div
                class="bg-white rounded-2xl shadow-lg p-4 md:p-6 flex flex-col h-full relative border border-green-100 transition-all duration-200">
                <!-- Menú Principal -->
                <div x-show="menu === 'principal'" class="flex flex-col gap-4 md:gap-6 h-full">
                    <!-- Cobrar -->
                    <button
                        class="w-full h-14 md:h-16 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-2xl py-3 md:py-4 font-bold text-lg md:text-xl shadow transition disabled:opacity-60 flex items-center justify-center"
                        :disabled="carrito.length === 0 || !turnoAbierto"
                        @click="if(requireTurnoAbierto()) mostrarModalCobro = true">
                        <svg class="w-6 h-6 md:w-7 md:h-7 inline mr-2 md:mr-3 -mt-1" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a5 5 0 00-10 0v2"></path>
                            <rect width="20" height="12" x="2" y="9" rx="2"></rect>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 19v2m10-2v2"></path>
                        </svg>
                        Cobrar
                    </button>

                    <button
                        class="w-full h-14 md:h-16 bg-gradient-to-r from-gray-700 to-gray-800 hover:from-gray-800 hover:to-gray-900 text-white rounded-2xl py-3 md:py-4 font-bold text-lg md:text-xl shadow transition flex items-center justify-center"
                        @click="menu = 'editar'">
                        <svg class="w-6 h-6 md:w-7 md:h-7 inline mr-2 md:mr-3 -mt-1" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.232 5.232l3.536 3.536M9 13l6-6m2 2l-6 6m-2 2h6"></path>
                        </svg>
                        Editar transacción
                    </button>

                    <div class="grid grid-cols-2 gap-3 md:gap-4">
                        <!-- BOTÓN RECARGAS NUEVO -->
                        <button
                            @click="if(requireTurnoAbierto()) document.getElementById('modal-recarga').classList.remove('hidden')"
                            class="h-12 md:h-14 bg-yellow-500 hover:bg-yellow-600 text-white rounded-2xl font-semibold shadow transition flex items-center justify-center gap-2 md:gap-3 text-base md:text-lg">
                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3"></path>
                                <circle cx="12" cy="12" r="10"></circle>
                            </svg>
                            Recargas
                        </button>
                        <!-- BOTÓN REMESAS MODIFICADO -->
                        <button @click="if(requireTurnoAbierto()) mostrarModalRemesa = true"
                            class="h-12 md:h-14 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-semibold shadow transition flex items-center justify-center gap-2 md:gap-3 text-base md:text-lg">
                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a5 5 0 00-10 0v2">
                                </path>
                                <rect width="20" height="12" x="2" y="9" rx="2"></rect>
                            </svg>
                            Remesas
                        </button>
                        <!-- BOTÓN RETIROS NUEVO -->
                        <button @click="if(requireTurnoAbierto()) mostrarModalRetiro = true"
                            class="h-12 md:h-14 bg-purple-600 hover:bg-purple-700 text-white rounded-2xl font-semibold shadow transition flex items-center justify-center gap-2 md:gap-3 text-base md:text-lg">
                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8m0 0l-3-3m3 3l3-3">
                                </path>
                                <circle cx="12" cy="12" r="10"></circle>
                            </svg>
                            Retiros
                        </button>
                        <button type="button" id="btnSalidaEfectivo"
                            class="px-3 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">
                            ➖ Salida de efectivo
                        </button>

                        <!-- BOTÓN DEPÓSITOS (nuevo, igual que Retiros) -->
                        <button @click="if(requireTurnoAbierto()) mostrarModalDeposito = true"
                            class="h-12 md:h-14 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl font-semibold shadow transition flex items-center justify-center gap-2 md:gap-3 text-base md:text-lg">
                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 16V8m0 0l-3 3m3-3l3 3">
                                </path>
                                <circle cx="12" cy="12" r="10"></circle>
                            </svg>
                            Depósitos
                        </button>
                        <!-- BOTÓN SERVICIOS NUEVO -->
                        <button @click="if(requireTurnoAbierto()) mostrarModalServicio = true"
                            class="h-12 md:h-14 bg-teal-600 hover:bg-teal-700 text-white rounded-2xl font-semibold shadow transition flex items-center justify-center gap-2 md:gap-3 text-base md:text-lg">
                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6"></path>
                                <rect width="20" height="12" x="2" y="7" rx="2"></rect>
                            </svg>
                            Servicios
                        </button>
                        <!-- BOTÓN IMPRESIONES (abre modal de impresión) -->
                        <button
                            @click="if(requireTurnoAbierto()) document.getElementById('modal-impresion').classList.remove('hidden')"
                            class="h-12 md:h-14 bg-pink-600 hover:bg-pink-700 text-white rounded-2xl font-semibold shadow transition flex items-center justify-center gap-2 md:gap-3 text-base md:text-lg">
                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 16h8M8 12h8m-8-4h8"></path>
                                <rect width="20" height="12" x="2" y="6" rx="2"></rect>
                            </svg>
                            Impresiones
                        </button>
                        <!-- BOTÓN CONSULTA DE PRECIO -->
                        <button @click="mostrarModalConsulta = true"
                            class="h-12 md:h-14 bg-indigo-500 hover:bg-indigo-600 text-white rounded-2xl font-semibold shadow transition flex items-center justify-center gap-2 md:gap-3 text-base md:text-lg">
                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"></path>
                            </svg>
                            Consulta Precios
                        </button>
                        <!-- BOTÓN APERTURA DE TURNO -->
                        <a href="{{ $turnoAbierto ? 'javascript:void(0)' : route('aperturas.create') }}"
                            @if ($turnoAbierto) onclick="Swal.fire('Turno activo', 'Ya tienes un turno abierto. Ciérralo antes de abrir otro.', 'info')" @endif
                            class="h-12 md:h-14 {{ $turnoAbierto ? 'bg-gray-400 cursor-not-allowed' : 'bg-green-500 hover:bg-green-600' }} text-white rounded-2xl font-semibold shadow transition flex items-center justify-center gap-2 md:gap-3 text-base md:text-lg">
                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3"></path>
                            </svg>
                            {{ $turnoAbierto ? 'Turno abierto' : 'Apertura de Turno' }}
                        </a>

                        <!-- BOTÓN CIERRE DE TURNO -->
                        <a href="{{ $turnoAbierto ? route('cierres.create') : 'javascript:void(0)' }}"
                            @click="if(!turnoAbierto){ Swal.fire({icon: 'warning', title: 'Debes abrir turno', text: 'Abre un turno para poder cerrar.', confirmButtonColor: '#16a34a'}); return false; }"
                            class="h-12 md:h-14 {{ $turnoAbierto ? 'bg-red-500 hover:bg-red-600' : 'bg-gray-400 cursor-not-allowed' }} text-white rounded-2xl font-semibold shadow transition flex items-center justify-center gap-2 md:gap-3 text-base md:text-lg">
                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 16v-4l-3-3"></path>
                            </svg>
                            Cierre de Turno
                        </a>
                        <button
                            class="h-12 md:h-14 bg-red-600 hover:bg-red-700 text-white rounded-2xl font-semibold shadow transition flex items-center justify-center gap-2 md:gap-3 text-base md:text-lg"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h4"></path>
                            </svg>
                            Salir
                        </button>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>

                    </div>
                </div>

                <!-- Submenú Editar -->
                <div x-show="menu === 'editar'" class="flex flex-col gap-4 md:gap-6 h-full">
                    <button
                        class="w-full h-14 md:h-16 bg-red-600 hover:bg-red-700 text-white rounded-2xl font-bold shadow transition flex items-center justify-center text-lg md:text-xl"
                        @click="vaciarCarrito()">
                        <svg class="w-5 h-5 md:w-6 md:h-6 inline mr-2 md:mr-3 -mt-1" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Vaciar carrito
                    </button>
                    <button
                        class="w-full h-14 md:h-16 bg-yellow-700 hover:bg-yellow-800 text-white rounded-2xl font-bold shadow transition flex items-center justify-center text-lg md:text-xl"
                        @click="alert('Función en desarrollo')">
                        <svg class="w-5 h-5 md:w-6 md:h-6 inline mr-2 md:mr-3 -mt-1" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9"></path>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 3.5a2.121 2.121 0 013 3L7 19.5 3 21l1.5-4L16.5 3.5z"></path>
                        </svg>
                        Editar líneas
                    </button>
                    <button
                        class="w-full h-14 md:h-16 bg-gray-500 hover:bg-gray-600 text-white rounded-2xl font-bold shadow transition flex items-center justify-center text-lg md:text-xl"
                        @click="menu = 'principal'">
                        <svg class="w-5 h-5 md:w-6 md:h-6 inline mr-2 md:mr-3 -mt-1" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18"></path>
                        </svg>
                        Principal
                    </button>
                </div>

                <!-- Submenú Admin -->
                <div x-show="menu === 'admin'" class="flex flex-col gap-4 md:gap-6 h-full">
                    <a href="{{ route('productos.index') }}"
                        class="w-full h-14 md:h-16 bg-blue-800 hover:bg-blue-900 text-white rounded-2xl font-bold shadow transition text-center flex items-center justify-center gap-2 md:gap-3 text-lg md:text-xl">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M3 12h18M3 17h18"></path>
                        </svg>
                        Gestión de Productos
                    </a>
                    <button
                        class="w-full h-14 md:h-16 bg-gray-500 hover:bg-gray-600 text-white rounded-2xl font-bold shadow transition flex items-center justify-center text-lg md:text-xl"
                        @click="menu = 'principal'">
                        <svg class="w-5 h-5 md:w-6 md:h-6 inline mr-2 md:mr-3 -mt-1" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18"></path>
                        </svg>
                        Principal
                    </button>
                </div>
            </div>

            <!-- MODAL DE COBRO -->
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                x-show="mostrarModalCobro" x-transition
                x-effect="if(mostrarModalCobro){ $nextTick(()=>{ $refs.montoInput?.focus(); $refs.montoInput?.select(); }); }"
                @keydown.enter.window.prevent="if(!(montoRecibido < total || carrito.length === 0)) registrarVenta()">
                <div class="bg-white w-full max-w-md rounded-2xl shadow-xl p-8 border-2 border-green-200 relative">
                    <button @click="cerrarModalCobro()"
                        class="absolute top-3 right-3 text-gray-400 hover:text-red-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    <h2 class="text-2xl font-bold mb-6 text-green-700 flex items-center gap-2">
                        <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a5 5 0 00-10 0v2"></path>
                            <rect width="20" height="12" x="2" y="9" rx="2"></rect>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 19v2m10-2v2"></path>
                        </svg>
                        Finalizar Cobro
                    </h2>
                    <div class="mb-5">
                        <label class="block mb-1 font-medium text-gray-700">Total a pagar (L):</label>
                        <input type="text"
                            class="w-full border-2 border-green-200 rounded-lg p-3 bg-gray-100 font-bold text-xl text-green-700"
                            :value="total.toFixed(2)" readonly>
                    </div>
                    <div class="mb-5">
                        <label class="block mb-1 font-medium text-gray-700">Monto recibido (L):</label>
                        <input type="number" min="0" step="0.01" x-model.number="montoRecibido"
                            x-ref="montoInput"
                            @input="calcularCambio()"
                            class="w-full border-2 border-green-200 rounded-lg p-3 font-bold text-xl">
                    </div>
                    <div class="mb-5">
                        <label class="block mb-1 font-medium text-gray-700">Cambio (L):</label>
                        <input type="text"
                            class="w-full border-2 border-green-200 rounded-lg p-3 bg-gray-100 font-bold text-xl"
                            :class="cambio >= 0 ? 'text-green-700' : 'text-red-700'" :value="cambio.toFixed(2)"
                            readonly>
                    </div>
                    <div class="flex justify-end gap-4 mt-6">
                        <button
                            class="bg-gray-500 text-white px-6 py-3 rounded-xl hover:bg-gray-600 font-semibold shadow transition"
                            @click="cerrarModalCobro()">Cancelar</button>
                        <button
                            class="bg-green-600 text-white px-6 py-3 rounded-xl hover:bg-green-700 font-semibold shadow transition"
                            :disabled="montoRecibido < total || carrito.length === 0" @click="registrarVenta()">
                            <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Confirmar
                        </button>
                    </div>
                </div>
            </div>

            <!-- MODAL DE CAMBIO PERSONALIZADO -->
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                x-show="mostrarModalCambio" x-transition>
                <div
                    class="bg-white max-w-sm w-full p-8 rounded-2xl shadow-xl border-2 border-green-300 text-center relative">
                    <button @click="cerrarModalCambio()"
                        class="absolute top-3 right-3 text-gray-400 hover:text-red-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    <h2 class="text-3xl font-extrabold text-green-700 mb-3 flex items-center justify-center gap-2">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                        </svg>
                        ¡Venta exitosa!
                    </h2>
                    <p class="text-lg text-gray-700 mb-2">Gracias por su compra en <span
                            class="font-bold text-green-800">CYBER Y VARIEDADES SANDOVAL</span>.</p>
                    <template x-if="cambioVenta > 0">
                        <p class="text-3xl mb-6 font-extrabold text-white bg-indigo-600 rounded-xl py-4 shadow-lg">
                            Cambio: <span class="text-yellow-300">L <span
                                    x-text="cambioVenta.toFixed(2)"></span></span>
                        </p>
                    </template>
                    <template x-if="cambioVenta <= 0">
                        <p class="text-xl mb-4 font-semibold text-green-600">
                            No hay cambio a entregar.
                        </p>
                    </template>
                    <button @click="cerrarModalCambio()"
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-8 rounded-xl shadow mt-4 text-lg">
                        Cerrar
                    </button>
                </div>
            </div>
            <!-- Modal Salida de Efectivo -->
            <div id="modalSalidaEfectivo" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">
                <div class="bg-white w-full max-w-md rounded-2xl shadow-xl p-6">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-lg font-semibold">Registrar salida de efectivo</h2>
                        <button type="button" id="btnCloseSalida"
                            class="text-gray-500 hover:text-gray-700">&times;</button>
                    </div>

                    <form id="formSalidaEfectivo" action="{{ route('salidas.store') }}" method="POST">
                        @csrf
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium mb-1">Motivo <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="motivo" required
                                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring"
                                    placeholder="Ej: Compra de insumos, caja chica, viáticos, etc.">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Monto (L) <span
                                        class="text-red-500">*</span></label>
                                <input type="number" name="monto" step="0.01" min="0.01" required
                                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring"
                                    placeholder="0.00">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Observación (opcional)</label>
                                <textarea name="observacion" rows="3" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring"
                                    placeholder="Detalle opcional"></textarea>
                            </div>
                        </div>

                        <div class="flex justify-end gap-2 mt-5">
                            <button type="button" id="btnCancelSalida"
                                class="px-3 py-2 rounded-lg border">Cancelar</button>
                            <button type="submit"
                                class="px-3 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">
                                Guardar salida
                            </button>
                        </div>
                    </form>

                    <p id="salidaError" class="mt-3 text-sm text-red-600 hidden"></p>
                    <p id="salidaOk" class="mt-3 text-sm text-green-600 hidden"></p>
                </div>
            </div>
            <!-- MODAL DE REMESA -->
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                x-show="mostrarModalRemesa" x-transition>
                <div class="bg-white w-full max-w-lg rounded-2xl shadow-xl p-8 border-2 border-blue-300 relative">
                    <button @click="cerrarModalRemesa()"
                        class="absolute top-3 right-3 text-gray-400 hover:text-red-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>

                    <h2 class="text-2xl font-bold mb-6 text-blue-700 flex items-center gap-2">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a5 5 0 00-10 0v2"></path>
                            <rect width="20" height="12" x="2" y="9" rx="2"></rect>
                        </svg>
                        Registrar Remesa
                    </h2>

                    <form action="{{ route('remesas.store') }}" method="POST" class="space-y-4"
                        @submit="mostrarModalRemesa = false">
                        @csrf

                        <div>
                            <label class="block font-semibold">Monto</label>
                            <input type="number" step="0.01" name="monto" id="monto"
                                class="w-full border rounded p-2" required oninput="calcularComision()">
                        </div>
                        <div>
                            <label class="block font-semibold">Banco</label>
                            <select name="banco_id" class="w-full border rounded p-2" required>
                                @foreach ($bancos as $banco)
                                    <option value="{{ $banco->id }}">{{ $banco->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block font-semibold">Comisión</label>
                            <input type="text" id="comision"
                                class="w-full border rounded p-2 bg-gray-100 font-bold text-blue-700" readonly>
                        </div>

                        <div>
                            <label class="block font-semibold">Referencia (opcional)</label>
                            <input type="text" name="referencia" class="w-full border rounded p-2">
                        </div>

                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                            Registrar
                        </button>
                    </form>
                </div>
            </div>
            <!-- FIN MODAL REMESA -->

            <!-- MODAL DE RETIRO -->
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                x-show="mostrarModalRetiro" x-transition>
                <div class="bg-white w-full max-w-lg rounded-2xl shadow-xl p-8 border-2 border-purple-300 relative">
                    <button @click="cerrarModalRetiro()"
                        class="absolute top-3 right-3 text-gray-400 hover:text-red-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>

                    <h2 class="text-2xl font-bold mb-6 text-purple-700 flex items-center gap-2">
                        <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8m0 0l-3-3m3 3l3-3"></path>
                            <circle cx="12" cy="12" r="10"></circle>
                        </svg>
                        Registrar Retiro
                    </h2>

                    <form action="{{ route('pos.retiros.store') }}" method="POST" class="space-y-4"
                        @submit="mostrarModalRetiro = false">
                        @csrf

                        <div>
                            <label class="block font-semibold">Monto</label>
                            <input type="number" step="0.01" name="monto" id="montoRetiro"
                                class="w-full border rounded p-2" required oninput="calcularComisionRetiro()">
                        </div>
                        <div>
                            <label class="block font-semibold">Banco</label>
                            <select name="banco_id" class="w-full border rounded p-2" required>
                                @foreach ($bancos as $banco)
                                    <option value="{{ $banco->id }}">{{ $banco->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block font-semibold">Comisión</label>
                            <input type="text" id="comisionRetiro"
                                class="w-full border rounded p-2 bg-gray-100 font-bold text-purple-700" readonly>
                            <!-- input oculto con el valor real -->
                            <input type="hidden" name="comision" id="inputComisionRetiro">
                        </div>

                        <div>
                            <label class="block font-semibold">Referencia (opcional)</label>
                            <input type="text" name="referencia" class="w-full border rounded p-2">
                        </div>

                        <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded hover:bg-purple-700">
                            Registrar
                        </button>
                    </form>

                </div>
            </div>
            <!-- FIN MODAL RETIRO -->

            <!-- MODAL DE DEPÓSITO (igual a RETIRO, cambiando rutas/ids) -->
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                x-show="mostrarModalDeposito" x-transition>
                <div class="bg-white w-full max-w-lg rounded-2xl shadow-xl p-8 border-2 border-emerald-300 relative">
                    <button @click="cerrarModalDeposito()"
                        class="absolute top-3 right-3 text-gray-400 hover:text-red-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>

                    <h2 class="text-2xl font-bold mb-6 text-emerald-700 flex items-center gap-2">
                        <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 16V8m0 0l-3 3m3-3l3 3"></path>
                            <circle cx="12" cy="12" r="10"></circle>
                        </svg>
                        Registrar Depósito
                    </h2>

                    <form action="{{ route('pos.depositos.store') }}" method="POST" class="space-y-4"
                        @submit="mostrarModalDeposito = false">
                        @csrf

                        <div>
                            <label class="block font-semibold">Monto</label>
                            <input type="number" step="0.01" name="monto" id="montoDeposito"
                                class="w-full border rounded p-2" required oninput="calcularComisionDeposito()">
                        </div>

                        <div>
                            <label class="block font-semibold">Banco</label>
                            <select name="banco_id" class="w-full border rounded p-2" required>
                                @foreach ($bancos as $banco)
                                    <option value="{{ $banco->id }}">{{ $banco->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block font-semibold">Comisión</label>
                            <div class="flex gap-2">
                                <!-- Valor sugerido (calculo automático, solo lectura) -->
                                <input type="text" id="comisionDeposito"
                                    class="w-1/2 border rounded p-2 bg-gray-100 font-bold text-emerald-700"
                                    readonly placeholder="--">

                                <!-- Valor editable que se enviará al servidor -->
                                <input type="number" name="comision" id="inputComisionDeposito" step="0.01" min="0"
                                    class="w-1/2 border rounded p-2" placeholder="Editar comisión (L)">
                            </div>
                        </div>

                        <div>
                            <label class="block font-semibold">Referencia (opcional)</label>
                            <input type="text" name="referencia" class="w-full border rounded p-2">
                        </div>

                        <button type="submit"
                            class="bg-emerald-600 text-white px-6 py-2 rounded hover:bg-emerald-700">
                            Registrar
                        </button>
                    </form>
                </div>
            </div>
            <!-- FIN MODAL DEPÓSITO -->

            <!-- MODAL DE SERVICIO -->
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                x-show="mostrarModalServicio" x-transition>
                <div class="bg-white w-full max-w-md rounded shadow-lg p-6 relative border-2 border-teal-300">
                    <button class="absolute top-2 right-2 text-red-500 text-xl font-bold"
                        @click="cerrarModalServicio()">
                        &times;
                    </button>
                    <h2 class="text-xl font-bold mb-4 text-center text-teal-700">Registrar Servicio</h2>
                    <form action="{{ route('pos.servicios.store') }}" method="POST" class="space-y-4"
                        @submit="mostrarModalServicio = false">
                        @csrf

                        <div>
                            <label class="block font-semibold">Tipo de Servicio</label>
                            <select name="tipo_servicio_id" class="w-full border rounded p-2" required>
                                @foreach ($tipos as $tipo)
                                    <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block font-semibold">Banco</label>
                            <select name="banco_id" class="w-full border rounded p-2" required>
                                @foreach ($bancos as $banco)
                                    <option value="{{ $banco->id }}">{{ $banco->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block font-semibold">Total</label>
                            <input type="number" name="total" step="0.01"
                                class="w-full border rounded px-3 py-2" required value="0">
                        </div>

                        <div>
                            <label class="block font-semibold">Referencia</label>
                            <input type="text" name="referencia" class="w-full border rounded px-3 py-2">
                        </div>

                        <div>
                            <label class="block font-semibold">Comisión</label>
                            <input type="number" name="comision" step="0.01"
                                class="w-full border rounded px-3 py-2" required value="15">
                        </div>

                        <div class="text-right">
                            <button type="submit"
                                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                                Guardar Servicio
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- FIN MODAL SERVICIO -->

            <!-- MODAL DE RECARGA -->
            <div id="modal-recarga"
                class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
                <div class="bg-white rounded shadow-lg max-w-md w-full p-6 relative">
                    <!-- Botón cerrar -->
                    <button onclick="document.getElementById('modal-recarga').classList.add('hidden')"
                        class="absolute top-2 right-2 text-gray-600 hover:text-red-500 text-xl">&times;</button>

                    <h2 class="text-xl font-bold mb-4">📲 Registrar Recarga</h2>

                    @if (session('success'))
                        <div class="bg-green-100 text-green-800 p-3 mb-4 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('recargas.store') }}">
                        @csrf

                        <!-- Proveedor -->
                        <label class="block mb-1 font-semibold">Proveedor</label>
                        <select id="recarga_proveedor" class="w-full border rounded px-3 py-2 mb-3" required>
                            <option value="">-- Selecciona un proveedor --</option>
                            @foreach ($proveedores as $proveedor)
                                <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                            @endforeach
                        </select>

                        <!-- Paquete -->
                        <label class="block mb-1 font-semibold">Paquete</label>
                        <select name="paquete_id" id="recarga_paquete" class="w-full border rounded px-3 py-2 mb-3"
                            required>
                            <option value="">-- Selecciona un paquete --</option>
                        </select>

                        <!-- Precio -->
                        <div id="recarga_precio_container" class="mb-3 hidden">
                            <label class="block font-semibold mb-1">Precio</label>
                            <input type="text" id="recarga_precio"
                                class="w-full border px-3 py-2 rounded bg-gray-100" readonly>
                        </div>

                        <!-- Número -->
                        <label class="block font-semibold mb-1">Número de Celular (opcional)</label>
                        <input type="text" name="numero" class="w-full border px-3 py-2 rounded mb-4"
                            placeholder="Ej: 99887766" maxlength="8" pattern="\d{0,8}" inputmode="numeric"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,8)">

                        <button type="submit"
                            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 w-full">✅
                            Registrar</button>
                    </form>
                </div>
            </div>
            <!-- FIN MODAL RECARGA -->

            <!-- MODAL: Registrar Impresión -->
            <div id="modal-impresion"
                class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
                <div class="bg-white rounded-lg max-w-md w-full p-6 relative shadow-lg">
                    <!-- Cerrar -->
                    <button onclick="document.getElementById('modal-impresion').classList.add('hidden')"
                        class="absolute top-2 right-2 text-gray-600 hover:text-red-500 text-xl">&times;</button>

                    <h2 class="text-xl font-bold mb-4">🖨 Registrar Impresión</h2>

                    <form method="POST" action="{{ route('impresiones.store') }}">
                        @csrf

                        <!-- Servicio de Impresión -->
                        <label class="block font-semibold mb-1">Servicio</label>
                        <select name="servicio_id" class="w-full border rounded px-3 py-2 mb-3" required>
                            <option value="">-- Selecciona un servicio --</option>
                            @foreach ($serviciosImpresion as $servicio)
                                <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
                            @endforeach
                        </select>

                        <!-- Tipo de Impresión -->
                        <label class="block font-semibold mb-1">Tipo de Impresión</label>
                        <select name="tipo_id" class="w-full border rounded px-3 py-2 mb-3" required>
                            <option value="">-- Selecciona un tipo --</option>
                            @foreach ($tiposImpresion as $tipo)
                                <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                            @endforeach
                        </select>

                        <!-- Precio -->
                        <label class="block font-semibold mb-1">Precio (L)</label>
                        <input type="number" name="precio" step="0.01" required
                            class="w-full border px-3 py-2 rounded mb-3" placeholder="Ej: 10.00">

                        <!-- Descripción -->
                        <label class="block font-semibold mb-1">Descripción (opcional)</label>
                        <input type="text" name="descripcion" class="w-full border px-3 py-2 rounded mb-4"
                            placeholder="Ej: Impresión doble cara">

                        <button type="submit"
                            class="bg-green-600 text-white px-4 py-2 rounded w-full hover:bg-green-700">✅
                            Registrar</button>
                    </form>
                </div>
            </div>
            <!-- FIN MODAL IMPRESION -->

            <!-- MODAL CONSULTA DE PRECIO -->
            <div class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50"
                x-show="mostrarModalConsulta" x-transition>
                <div class="bg-white max-w-3xl w-full p-6 rounded-2xl shadow-2xl border-4 border-blue-900 relative font-sans"
                    style="max-height: 90vh; display: flex; flex-direction: column;">
                    <button @click="cerrarModalConsulta()"
                        class="absolute top-4 right-4 text-blue-900 hover:text-red-600 transition text-2xl font-bold">
                        &times;
                    </button>

                    <h2 class="text-2xl font-bold mb-4 text-blue-900 text-center tracking-wide">Consulta de Precios
                    </h2>

                    <div class="mb-4 flex gap-3 items-center">
                        <input type="text" x-model="consultaBusqueda" placeholder="Buscar por código ó nombre"
                            class="flex-1 border border-blue-900 rounded px-4 py-2 text-base focus:ring-2 focus:ring-blue-900 bg-blue-50 font-semibold text-blue-900 transition"
                            @input="buscarProductosConsulta">
                    </div>

                    <div class="overflow-x-auto rounded border border-blue-200 bg-blue-50 flex-1"
                        style="max-height: 50vh; min-height: 200px; overflow-y: auto;">
                        <table class="min-w-full text-sm text-blue-900">
                            <thead class="bg-blue-900 text-white sticky top-0 z-10">
                                <tr>
                                    <th class="px-3 py-2 border-b border-blue-200 font-bold text-left">Código</th>
                                    <th class="px-3 py-2 border-b border-blue-200 font-bold text-left">Nombre</th>
                                    <th class="px-3 py-2 border-b border-blue-200 font-bold text-right">Precio</th>
                                    <th class="px-3 py-2 border-b border-blue-200 font-bold text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-if="productosFiltrados.length === 0 && consultaBusqueda.length >= 3">
                                    <tr>
                                        <td colspan="5"
                                            class="text-center py-8 text-red-600 font-semibold bg-white">
                                            ❌ No se encontraron productos.
                                        </td>
                                    </tr>
                                </template>
                                <template x-for="prod in productosFiltrados" :key="prod.id">
                                    <tr class="hover:bg-blue-100 transition cursor-pointer"
                                        @dblclick="agregarDesdeConsulta(prod)">
                                        <td class="px-3 py-2 border-b border-blue-100 font-mono" x-text="prod.codigo">
                                        </td>
                                        <td class="px-3 py-2 border-b border-blue-100 font-semibold"
                                            x-text="prod.nombre"></td>
                                        <td class="px-3 py-2 border-b border-blue-100 text-right font-bold text-green-700"
                                            x-text="`L. ${parseFloat(prod.precio_venta).toFixed(2)}`"></td>
                                        <td class="px-3 py-2 border-b border-blue-100 text-center">
                                            <button @click="agregarDesdeConsulta(prod)"
                                                class="bg-blue-900 hover:bg-blue-700 text-white px-3 py-1 rounded shadow text-xs font-bold transition">
                                                Agregar
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-2 text-xs text-gray-500 text-right">
                        Doble clic en una fila también agrega el producto.
                    </div>
                </div>
            </div>

            <!-- FIN MODAL CONSULTA DE PRECIO PERSONALIZADO -->

        </div>

        <script>
            function posApp() {
                return {
                    turnoAbierto: @json($turnoAbierto),
                    requireTurnoAbierto() {
                        if (!this.turnoAbierto) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Debes abrir turno',
                                text: 'Abre un turno para poder operar en el POS.',
                                confirmButtonColor: '#16a34a'
                            });
                            return false;
                        }
                        return true;
                    },


                    search: '',
                    carrito: [],
                    total: 0,
                    productos: @json($productos),
                    menu: 'principal',
                    mostrarModalCobro: false,
                    montoRecibido: 0,
                    cambio: 0,
                    // Nuevas variables
                    ventaExitosa: false,
                    mostrarModalCambio: false,
                    cambioVenta: 0,
                    // Remesa modal variable
                    mostrarModalRemesa: false,
                    // Retiro modal variable
                    mostrarModalRetiro: false,
                    // Servicio modal variable
                    mostrarModalServicio: false,
                    // Depósito modal variable
                    mostrarModalDeposito: false,

                    // Consulta de precio
                    // MODAL CONSULTA DE PRECIO
                    mostrarModalConsulta: false,
                    consultaBusqueda: '',
                    productosFiltrados: [],

                    cerrarModalConsulta() {
                        this.mostrarModalConsulta = false;
                        this.consultaBusqueda = '';
                        this.productosFiltrados = [];
                    },

                    buscarProductosConsulta() {
                        const q = this.consultaBusqueda.trim().toLowerCase();
                        if (q.length < 3) {
                            this.productosFiltrados = [];
                            return;
                        }

                        this.productosFiltrados = this.productos.filter(p =>
                            p.codigo.toLowerCase().includes(q) ||
                            p.nombre.toLowerCase().includes(q) ||
                            (p.descripcion && p.descripcion.toLowerCase().includes(q))
                        );
                    },

                    agregarDesdeConsulta(producto) {
                        const existente = this.carrito.find(item => item.id === producto.id);
                        if (existente) {
                            existente.cantidad += 1;
                        } else {
                            this.carrito.push({
                                ...producto,
                                cantidad: 1,
                                precio: parseFloat(producto.precio_venta),
                            });
                        }
                        this.calcularTotal();
                        this.guardarCarritoLocal();
                        this.cerrarModalConsulta();
                    },


                    // --- LOCAL STORAGE ---
                    guardarCarritoLocal() {
                        localStorage.setItem('pos_carrito', JSON.stringify(this.carrito));
                    },
                    cargarCarritoLocal() {
                        const data = localStorage.getItem('pos_carrito');
                        if (data) {
                            try {
                                this.carrito = JSON.parse(data);
                            } catch (e) {
                                this.carrito = [];
                            }
                        }
                    },
                    limpiarCarritoLocal() {
                        localStorage.removeItem('pos_carrito');
                    },
                    // --- FIN LOCAL STORAGE ---

                    init() {
                        this.cargarCarritoLocal();
                        this.calcularTotal();
                    },

                    addProducto() {
                        const query = this.search.trim().toLowerCase();
                        if (!query) return;
                        const producto = this.productos.find(p =>
                            p.codigo.toLowerCase() === query || p.nombre.toLowerCase().includes(query)
                        );
                        if (producto) {
                            const existente = this.carrito.find(item => item.id === producto.id);
                            if (existente) {
                                existente.cantidad += 1;
                            } else {
                                this.carrito.push({
                                    ...producto,
                                    cantidad: 1,
                                    precio: parseFloat(producto.precio_venta),
                                });
                            }
                            this.calcularTotal();
                            this.search = '';
                            this.guardarCarritoLocal();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Producto no encontrado',
                                text: 'Verifica el código ingresado o escaneado.',
                                confirmButtonColor: '#e3342f'
                            });
                        }

                    },

                    quitarProducto(index) {
                        this.carrito.splice(index, 1);
                        this.calcularTotal();
                        this.guardarCarritoLocal();
                    },

                    vaciarCarrito() {
                        this.carrito = [];
                        this.total = 0;
                        this.montoRecibido = 0;
                        this.cambio = 0;
                        this.limpiarCarritoLocal();
                    },

                    calcularTotal() {
                        this.total = this.carrito.reduce((acc, item) => acc + (item.precio * item.cantidad), 0);
                        this.calcularCambio();
                        this.guardarCarritoLocal();
                    },

                    calcularCambio() {
                        this.cambio = this.montoRecibido - this.total;
                    },

                    cerrarModalCobro() {
                        this.mostrarModalCobro = false;
                        this.montoRecibido = 0;
                        this.cambio = 0;
                    },

                    registrarVenta() {
                        if (!this.requireTurnoAbierto()) return;
                        if (this.montoRecibido < this.total || this.carrito.length === 0) return;
                        const payload = {
                            productos: this.carrito.map(p => ({
                                id: p.id,
                                cantidad: p.cantidad,
                                precio: p.precio
                            })),
                            total: this.total,
                            monto_recibido: this.montoRecibido
                        };


                        fetch('{{ route('ventas.store') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                        'content'),
                                },
                                body: JSON.stringify(payload)
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    this.cambioVenta = this.cambio;
                                    this.ventaExitosa = true;
                                    this.mostrarModalCambio = true;
                                    this.limpiarCarritoLocal();
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: '❌ No se pudo guardar la venta.',
                                        confirmButtonColor: '#e3342f'
                                    });
                                }
                            })
                            .catch(() => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error de red',
                                    text: '❌ No se pudo conectar con el servidor. Intente nuevamente.',
                                    confirmButtonColor: '#e3342f'
                                });
                            });

                    },

                    cerrarModalCambio() {
                        this.vaciarCarrito();
                        this.mostrarModalCambio = false;
                        this.ventaExitosa = false;
                        this.cerrarModalCobro();
                    },

                    cerrarModalRemesa() {
                        this.mostrarModalRemesa = false;
                    },

                    cerrarModalRetiro() {
                        this.mostrarModalRetiro = false;
                    },

                    cerrarModalServicio() {
                        this.mostrarModalServicio = false;
                    },

                    cerrarModalDeposito() {
                        this.mostrarModalDeposito = false;
                    }

                }
            }
        </script>
        <script>
            // Apertura/cierre modal
            const $modal = document.getElementById('modalSalidaEfectivo');
            const $openBtn = document.getElementById('btnSalidaEfectivo');
            const $closeX = document.getElementById('btnCloseSalida');
            const $cancel = document.getElementById('btnCancelSalida');
            const $form = document.getElementById('formSalidaEfectivo');
            const $err = document.getElementById('salidaError');
            const $ok = document.getElementById('salidaOk');

            function toggleSalidaModal(show) {
                if (show) {
                    $modal.classList.remove('hidden');
                    $modal.classList.add('flex');
                } else {
                    $modal.classList.add('hidden');
                    $modal.classList.remove('flex');
                }
                $err.classList.add('hidden');
                $ok.classList.add('hidden');
                $err.textContent = '';
                $ok.textContent = '';
            }

            $openBtn?.addEventListener('click', () => toggleSalidaModal(true));
            $closeX?.addEventListener('click', () => toggleSalidaModal(false));
            $cancel?.addEventListener('click', () => toggleSalidaModal(false));

            // Envío AJAX (evita recargar POS)
            $form?.addEventListener('submit', async (e) => {
                e.preventDefault();
                $err.classList.add('hidden');
                $ok.classList.add('hidden');

                const fd = new FormData($form);
                try {
                    const resp = await fetch($form.action, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: fd
                    });

                    const data = await resp.json();

                    if (!resp.ok || data.ok === false) {
                        const msg = data?.message ||
                            (data?.errors ? Object.values(data.errors).flat().join(' ') :
                                'Error al registrar salida.');
                        $err.textContent = msg;
                        $err.classList.remove('hidden');
                        return;
                    }

                    $ok.textContent = `Salida registrada: L ${data.monto} (${data.motivo})`;
                    $ok.classList.remove('hidden');
                    $form.reset();

                    // Cerrar modal tras 1s (opcional)
                    setTimeout(() => toggleSalidaModal(false), 1000);

                    // TODO (opcional): refrescar totales visibles de caja si los muestras en POS.
                } catch (ex) {
                    $err.textContent = 'Error de red/servidor.';
                    $err.classList.remove('hidden');
                }
            });
        </script>
        <script>
            const remesaRangos = @json(\App\Models\RemesaConfig::all());

            function calcularComision() {
                const monto = parseFloat(document.getElementById('monto').value);
                const input = document.getElementById('comision');
                if (isNaN(monto)) return input.value = '';
                const r = remesaRangos.find(x =>
                    parseFloat(x.monto_min) <= monto && parseFloat(x.monto_max) >= monto
                );
                input.value = r ? `L. ${parseFloat(r.comision).toFixed(2)}` : '❌ No definido';
            }
        </script>
        <script>
            function registrarRetiro() {
                const monto = parseFloat(document.getElementById('montoRetiro').value);
                const comision = parseFloat(document.getElementById('comisionRetiro').value);
                const referencia = document.getElementById('referenciaRetiro').value;

                if (isNaN(monto) || isNaN(comision)) {
                    alert('Debe ingresar un monto válido y calcular la comisión antes de guardar.');
                    return;
                }

                axios.post("{{ route('pos.retiros.store') }}", {
                        monto: monto,
                        comision: comision,
                        referencia: referencia
                    })
                    .then(response => {
                        alert('Retiro registrado exitosamente.');
                        document.getElementById('montoRetiro').value = '';
                        document.getElementById('comisionRetiro').value = '';
                        document.getElementById('referenciaRetiro').value = '';
                        const modal = document.getElementById('modal-retiro');
                        if (modal) {
                            modal.style.display = 'none';
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        alert('Error al registrar el retiro.');
                    });
            }
        </script>

        <script>
            const retiroRangos = @json(\App\Models\RetiroConfig::all());

            function calcularComisionRetiro() {
                const monto = document.getElementById('montoRetiro').value;

                if (monto && parseFloat(monto) > 0) {
                    fetch('/pos/retiros/calcular', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                monto: monto
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.comision) {
                                document.getElementById('comisionRetiro').value =
                                    `L. ${parseFloat(data.comision).toFixed(2)}`;
                                document.getElementById('inputComisionRetiro').value = data.comision;
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            document.getElementById('comisionRetiro').value = 'No disponible';
                            document.getElementById('inputComisionRetiro').value = '';
                        });
                }
            }
        </script>
        <script>
            function calcularComisionDeposito() {
                const monto = document.getElementById('montoDeposito').value;

                if (monto && parseFloat(monto) > 0) {
                    fetch("{{ route('pos.depositos.calcular-comision') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                monto: monto
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.comision) {
                                document.getElementById('comisionDeposito').value =
                                    `L. ${parseFloat(data.comision).toFixed(2)}`;
                                document.getElementById('inputComisionDeposito').value = data.comision;
                            } else {
                                document.getElementById('comisionDeposito').value = '❌ No definido';
                                document.getElementById('inputComisionDeposito').value = '';
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            document.getElementById('comisionDeposito').value = 'No disponible';
                            document.getElementById('inputComisionDeposito').value = '';
                        });
                } else {
                    document.getElementById('comisionDeposito').value = '';
                    document.getElementById('inputComisionDeposito').value = '';
                }
            }
        </script>
        <!-- Recarga JS Dinámico -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const proveedor = document.getElementById('recarga_proveedor');
                const paquete = document.getElementById('recarga_paquete');
                const precio = document.getElementById('recarga_precio');
                const precioContainer = document.getElementById('recarga_precio_container');

                if (proveedor) {
                    proveedor.addEventListener('change', function() {
                        const proveedorId = this.value;
                        paquete.innerHTML = '<option value="">Cargando...</option>';
                        precio.value = '';
                        precioContainer.classList.add('hidden');

                        if (proveedorId) {
                            fetch(`/paquetes-por-proveedor/${proveedorId}`)
                                .then(res => res.json())
                                .then(data => {
                                    paquete.innerHTML =
                                        '<option value="">-- Selecciona un paquete --</option>';
                                    data.forEach(p => {
                                        const opt = document.createElement('option');
                                        opt.value = p.id;
                                        // Enviamos precio de VENTA en el data-atributo
                                        opt.dataset.precio = p.precio_venta;
                                        opt.textContent =
                                            `${p.descripcion} - L ${parseFloat(p.precio_venta).toFixed(2)}`;
                                        paquete.appendChild(opt);
                                    });
                                });
                        }
                    });
                }

                if (paquete) {
                    paquete.addEventListener('change', function() {
                        const selected = this.options[this.selectedIndex];
                        const valor = selected?.dataset?.precio;
                        if (valor) {
                            precio.value = `L ${parseFloat(valor).toFixed(2)}`;
                            precioContainer.classList.remove('hidden');
                        } else {
                            precioContainer.classList.add('hidden');
                        }
                    });
                }
            });
        </script>

        <div
            class="fixed bottom-0 left-0 w-full bg-white border-t border-green-200 py-2 px-6 flex flex-col md:flex-row items-center justify-between text-sm text-gray-700 z-40">
            <div>
                <span class="font-semibold text-green-700">{{ auth()->user()->role ?? 'Usuario' }}:
                    {{ auth()->user()->name ?? '' }}</span>
                &nbsp;|&nbsp;
                <span class="font-semibold text-indigo-700">CYBER Y VARIEDADES SANDOVAL</span>
            </div>
            <div class="flex items-center gap-4">
                <span class="font-semibold text-gray-700">
                    IP: {{ request()->ip() }}
                </span>
            </div>
            <div class="flex items-center gap-4 mt-1 md:mt-0">
                <span id="fechaHoraActual"></span>
                <span id="estadoConexion" class="ml-4 flex items-center gap-1">
                    <svg id="iconoConexion" class="w-3 h-3" fill="currentColor" viewBox="0 0 8 8">
                        <circle cx="4" cy="4" r="4" />
                    </svg>
                    <span id="textoConexion">Conectado</span>
                </span>
            </div>
        </div>
        <script>
            function actualizarEstadoConexion() {
                const online = navigator.onLine;
                const icono = document.getElementById('iconoConexion');
                const texto = document.getElementById('textoConexion');
                if (online) {
                    icono.style.color = '#22c55e'; // verde
                    texto.textContent = 'Conectado';
                } else {
                    icono.style.color = '#ef4444'; // rojo
                    texto.textContent = 'Sin conexión';
                }
            }
            window.addEventListener('online', actualizarEstadoConexion);
            window.addEventListener('offline', actualizarEstadoConexion);
            actualizarEstadoConexion();
        </script>
        <script>
            function actualizarFechaHora() {
                const opciones = {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                };
                const ahora = new Date();
                document.getElementById('fechaHoraActual').textContent = ahora.toLocaleString('es-HN', opciones);
            }
            actualizarFechaHora();
            setInterval(actualizarFechaHora, 1000);
        </script>
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('posApp', posApp);
            });
        </script>
    </div>
</body>

</html>
