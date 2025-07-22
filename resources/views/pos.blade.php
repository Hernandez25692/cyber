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
                                    <td colspan="6" class="text-center py-8 text-gray-400">No hay productos en el
                                        carrito.</td>
                                </tr>
                            </template>
                            <template x-for="(item, index) in carrito" :key="index">
                                <tr class="hover:bg-green-50 transition">
                                    <td class="border-b p-3 font-mono text-green-700" x-text="item.codigo"></td>
                                    <td class="border-b p-3" x-text="item.nombre"></td>
                                    <td class="border-b p-3 text-center">
                                        <input type="number" class="w-16 border rounded text-center bg-white"
                                            x-model.number="item.cantidad" min="1" @input="calcularTotal()">
                                    </td>
                                    <td class="border-b p-3 text-right font-semibold text-green-700"
                                        x-text="`L. ${item.precio.toFixed(2)}`"></td>
                                    <td class="border-b p-3 text-right font-bold text-indigo-700"
                                        x-text="`L. ${(item.precio * item.cantidad).toFixed(2)}`"></td>
                                    <td class="border-b p-3 text-center">
                                        <button @click="quitarProducto(index)"
                                            class="text-red-600 hover:underline font-semibold transition">Eliminar</button>
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
            <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col h-full relative border border-green-100">
                <!-- Menú Principal -->
                <div x-show="menu === 'principal'" class="flex flex-col gap-6 h-full">
                    <button
                        class="w-full h-16 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-2xl py-4 font-bold text-xl shadow transition disabled:opacity-60 flex items-center justify-center"
                        :disabled="carrito.length === 0" @click="mostrarModalCobro = true">
                        <svg class="w-7 h-7 inline mr-3 -mt-1" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a5 5 0 00-10 0v2"></path>
                            <rect width="20" height="12" x="2" y="9" rx="2"></rect>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 19v2m10-2v2"></path>
                        </svg>
                        Cobrar
                    </button>

                    <button
                        class="w-full h-16 bg-gradient-to-r from-gray-700 to-gray-800 hover:from-gray-800 hover:to-gray-900 text-white rounded-2xl py-4 font-bold text-xl shadow transition flex items-center justify-center"
                        @click="menu = 'editar'">
                        <svg class="w-7 h-7 inline mr-3 -mt-1" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.232 5.232l3.536 3.536M9 13l6-6m2 2l-6 6m-2 2h6"></path>
                        </svg>
                        Editar transacción
                    </button>

                    <div class="grid grid-cols-2 gap-4">
                        <button
                            class="h-14 bg-yellow-500 hover:bg-yellow-600 text-white rounded-2xl font-semibold shadow transition flex items-center justify-center gap-3 text-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3"></path>
                                <circle cx="12" cy="12" r="10"></circle>
                            </svg>
                            Recargas
                        </button>
                        <a href="{{ route('remesas.form') }}"
                            class="h-14 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-semibold shadow transition flex items-center justify-center gap-3 text-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a5 5 0 00-10 0v2">
                                </path>
                                <rect width="20" height="12" x="2" y="9" rx="2"></rect>
                            </svg>
                            Remesas
                        </a>

                        <button
                            class="h-14 bg-purple-600 hover:bg-purple-700 text-white rounded-2xl font-semibold shadow transition flex items-center justify-center gap-3 text-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8m0 0l-3-3m3 3l3-3">
                                </path>
                                <circle cx="12" cy="12" r="10"></circle>
                            </svg>
                            Retiros
                        </button>
                        <button
                            class="h-14 bg-teal-600 hover:bg-teal-700 text-white rounded-2xl font-semibold shadow transition flex items-center justify-center gap-3 text-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6"></path>
                                <rect width="20" height="12" x="2" y="7" rx="2"></rect>
                            </svg>
                            Servicios
                        </button>
                        <button
                            class="h-14 bg-pink-600 hover:bg-pink-700 text-white rounded-2xl font-semibold shadow transition flex items-center justify-center gap-3 text-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 16h8M8 12h8m-8-4h8"></path>
                                <rect width="20" height="12" x="2" y="6" rx="2"></rect>
                            </svg>
                            Impresiones
                        </button>
                        <button
                            class="h-14 bg-red-600 hover:bg-red-700 text-white rounded-2xl font-semibold shadow transition flex items-center justify-center gap-3 text-lg"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
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
                        <button
                            class="col-span-2 h-14 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold shadow transition flex items-center justify-center gap-3 text-lg"
                            @click="menu = 'admin'">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Admin
                        </button>
                    </div>
                </div>

                <!-- Submenú Editar -->
                <div x-show="menu === 'editar'" class="flex flex-col gap-6 h-full">
                    <button
                        class="w-full h-16 bg-red-600 hover:bg-red-700 text-white rounded-2xl font-bold shadow transition flex items-center justify-center text-xl"
                        @click="vaciarCarrito()">
                        <svg class="w-6 h-6 inline mr-3 -mt-1" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Vaciar carrito
                    </button>
                    <button
                        class="w-full h-16 bg-yellow-700 hover:bg-yellow-800 text-white rounded-2xl font-bold shadow transition flex items-center justify-center text-xl"
                        @click="alert('Función en desarrollo')">
                        <svg class="w-6 h-6 inline mr-3 -mt-1" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9"></path>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 3.5a2.121 2.121 0 013 3L7 19.5 3 21l1.5-4L16.5 3.5z"></path>
                        </svg>
                        Editar líneas
                    </button>
                    <button
                        class="w-full h-16 bg-gray-500 hover:bg-gray-600 text-white rounded-2xl font-bold shadow transition flex items-center justify-center text-xl"
                        @click="menu = 'principal'">
                        <svg class="w-6 h-6 inline mr-3 -mt-1" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18"></path>
                        </svg>
                        Principal
                    </button>
                </div>

                <!-- Submenú Admin -->
                <div x-show="menu === 'admin'" class="flex flex-col gap-6 h-full">
                    <a href="{{ route('productos.index') }}"
                        class="w-full h-16 bg-blue-800 hover:bg-blue-900 text-white rounded-2xl font-bold shadow transition text-center flex items-center justify-center gap-3 text-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M3 12h18M3 17h18"></path>
                        </svg>
                        Gestión de Productos
                    </a>
                    <button
                        class="w-full h-16 bg-gray-500 hover:bg-gray-600 text-white rounded-2xl font-bold shadow transition flex items-center justify-center text-xl"
                        @click="menu = 'principal'">
                        <svg class="w-6 h-6 inline mr-3 -mt-1" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18"></path>
                        </svg>
                        Principal
                    </button>
                </div>
            </div>

            <!-- MODAL DE COBRO -->
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                x-show="mostrarModalCobro" x-transition>
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
                        <p class="text-xl mb-4 font-semibold">
                            Cambio a entregar: <span class="text-indigo-600">L. <span
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
        </div>

        <script>
            function posApp() {
                return {
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
                    },

                    vaciarCarrito() {
                        this.carrito = [];
                        this.total = 0;
                        this.montoRecibido = 0;
                        this.cambio = 0;
                    },

                    calcularTotal() {
                        this.total = this.carrito.reduce((acc, item) => acc + (item.precio * item.cantidad), 0);
                        this.calcularCambio();
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
                        if (this.montoRecibido < this.total || this.carrito.length === 0) return;
                        const payload = {
                            productos: this.carrito.map(p => ({
                                id: p.id,
                                cantidad: p.cantidad,
                                precio: p.precio
                            })),
                            total: this.total
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
                    }
                }
            }
        </script>
        <div
            class="fixed bottom-0 left-0 w-full bg-white border-t border-green-200 py-2 px-6 flex flex-col md:flex-row items-center justify-between text-sm text-gray-700 z-40">
            <div>
                <span class="font-semibold text-green-700">{{ auth()->user()->role ?? 'Usuario' }}:
                    {{ auth()->user()->name ?? '' }}</span>
                &nbsp;|&nbsp;
                <span class="font-semibold text-indigo-700">CYBER Y VARIEDADES SANDOVAL</span>
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
</body>

</html>
