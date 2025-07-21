<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen p-6">

    <div class="max-w-7xl mx-auto bg-white p-8 rounded-2xl shadow-xl border border-green-200">
        <h1 class="text-3xl font-bold text-green-700 mb-6">👨‍💼 Panel de Administración</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 text-center">
            <a href="#"
                class="bg-blue-600 text-white p-6 rounded-xl shadow hover:bg-blue-700 transition font-semibold">👥
                Gestión de Usuarios</a>
            <a href="#"
                class="bg-yellow-500 text-white p-6 rounded-xl shadow hover:bg-yellow-600 transition font-semibold">💰
                Comisiones y Servicios</a>
            <a href="#"
                class="bg-green-600 text-white p-6 rounded-xl shadow hover:bg-green-700 transition font-semibold">📦
                Inventario</a>
            <a href="#"
                class="bg-purple-600 text-white p-6 rounded-xl shadow hover:bg-purple-700 transition font-semibold">📈
                Reportes</a>
            <a href="/logout"
                class="bg-red-600 text-white p-6 rounded-xl shadow hover:bg-red-700 transition font-semibold">🚪 Cerrar
                sesión</a>
        </div>
    </div>

</body>

</html>
