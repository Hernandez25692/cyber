@extends('layouts.admin')

@section('title', 'Nuevo Usuario')

@section('content')
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 via-gray-100 to-gray-200 px-4 py-6">
    <div class="w-full max-w-2xl">
        <!-- Título principal y subtítulo -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-extrabold text-gray-800 mb-2 flex items-center justify-center gap-3 drop-shadow">
                <i class="fa-solid fa-user-plus text-green-600"></i>
                Nuevo Usuario
            </h1>
            <p class="text-base text-gray-500">Registra un nuevo usuario para el sistema de administración.</p>
        </div>

        <!-- Sección de acciones -->
        <div class="mb-6 flex justify-center gap-4">
            <a href="{{ route('admin.index') }}" class="bg-gradient-to-r from-gray-500 to-gray-600 text-white px-4 py-2 rounded shadow-lg hover:scale-105 transition flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i>
                Regresar
            </a>
        </div>

        <!-- Tarjeta de formulario -->
        <div class="bg-white rounded-2xl shadow-2xl p-8 w-full border border-gray-200">
            <h2 class="text-xl font-semibold text-gray-700 mb-6 flex items-center justify-center gap-2">
                <i class="fa-solid fa-pen-to-square text-green-500"></i>
                Datos del Usuario
            </h2>
            @if ($errors->any())
                <div class="mb-4">
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative animate-fade-in">
                        <strong class="font-bold"><i class="fa-solid fa-triangle-exclamation"></i> ¡Error!</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            <form method="POST" action="{{ route('admin.usuarios.store') }}" class="space-y-5">
                @csrf

                <div class="relative">
                    <label class="block font-semibold text-gray-600 mb-1 text-center">Nombre</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fa-solid fa-user"></i>
                        </span>
                        <input 
                            type="text" 
                            name="name" 
                            class="w-full border border-gray-300 rounded-lg p-3 pl-10 focus:ring-2 focus:ring-green-500 text-center transition shadow-sm" 
                            required
                            pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$"
                            oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '').replace(/\b\w/g, l => l.toUpperCase()).replace(/\B\w/g, l => l.toLowerCase());"
                            placeholder="Ejemplo: Juan Pérez"
                            value="{{ old('name') }}"
                        >
                    </div>
                </div>

                <div class="relative">
                    <label class="block font-semibold text-gray-600 mb-1 text-center">Email</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                        <input type="email" name="email" class="w-full border border-gray-300 rounded-lg p-3 pl-10 focus:ring-2 focus:ring-green-500 text-center transition shadow-sm" required placeholder="ejemplo@correo.com" value="{{ old('email') }}">
                    </div>
                </div>

                <div class="relative">
                    <label class="block font-semibold text-gray-600 mb-1 text-center">Contraseña</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input type="password" name="password" id="password" class="w-full border border-gray-300 rounded-lg p-3 pl-10 focus:ring-2 focus:ring-green-500 text-center transition shadow-sm" required placeholder="••••••••">
                        <button type="button" onclick="togglePassword('password')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-green-600 transition">
                            <i class="fa-solid fa-eye" id="togglePasswordIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="relative">
                    <label class="block font-semibold text-gray-600 mb-1 text-center">Confirmar Contraseña</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border border-gray-300 rounded-lg p-3 pl-10 focus:ring-2 focus:ring-green-500 text-center transition shadow-sm" required placeholder="••••••••">
                        <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-green-600 transition">
                            <i class="fa-solid fa-eye" id="togglePasswordConfirmationIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="relative">
                    <label class="block font-semibold text-gray-600 mb-1 text-center">Rol</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fa-solid fa-user-shield"></i>
                        </span>
                        <select name="rol" class="w-full border border-gray-300 rounded-lg p-3 pl-10 focus:ring-2 focus:ring-green-500 text-center transition shadow-sm" required>
                            <option value="admin" {{ old('rol') == 'admin' ? 'selected' : '' }}>Administrador</option>
                            <option value="cajero" {{ old('rol') == 'cajero' ? 'selected' : '' }}>Cajero</option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row gap-4 mt-8 justify-center">
                    <button type="submit" class="bg-gradient-to-r from-green-600 to-green-500 text-white px-6 py-3 rounded-lg shadow-lg hover:scale-105 transition flex items-center justify-center gap-2 w-full md:w-auto font-semibold">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Guardar Usuario
                    </button>
                    <a href="{{ route('admin.usuarios.index') }}" class="bg-gradient-to-r from-gray-400 to-gray-500 text-white px-6 py-3 rounded-lg shadow-lg hover:scale-105 transition flex items-center justify-center gap-2 w-full md:w-auto font-semibold">
                        <i class="fa-solid fa-users"></i>
                        Ver Usuarios
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Animación fade-in -->
<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(-10px);}
    to { opacity: 1; transform: translateY(0);}
}
.animate-fade-in { animation: fade-in 0.5s ease; }
</style>

<!-- Toggle Password JS -->
<script>
function togglePassword(id) {
    const input = document.getElementById(id);
    const icon = id === 'password' ? document.getElementById('togglePasswordIcon') : document.getElementById('togglePasswordConfirmationIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
@endsection
