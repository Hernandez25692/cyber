@extends('layouts.admin')

@section('title', 'Editar Usuario')

@section('content')
    {{-- Font Awesome CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-300 px-4 py-10">
        <div class="w-full max-w-2xl">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-extrabold text-gray-900 mb-2 flex items-center justify-center gap-3">
                    <span class="inline-block bg-green-100 text-green-700 rounded-full px-3 py-1 text-2xl shadow">
                        <i class="fa-solid fa-user-pen"></i>
                    </span>
                    Editar Usuario
                </h1>
                <p class="text-gray-500">Actualiza la información del usuario de forma segura y profesional.</p>
            </div>

            <div class="mb-6 flex justify-center gap-4">
                <a href="{{ route('admin.usuarios.index') }}"
                    class="bg-gradient-to-r from-gray-500 to-gray-700 text-white px-5 py-2 rounded-lg shadow-lg hover:from-gray-600 hover:to-gray-800 transition flex items-center gap-2">
                    <i class="fa-solid fa-arrow-left"></i> Volver
                </a>
            </div>

            <div class="bg-white rounded-3xl shadow-2xl p-10 border border-gray-200">
                <form method="POST" action="{{ route('admin.usuarios.update', $usuario->id) }}" class="space-y-7">
                    @csrf
                    @method('PUT')

                    @if ($errors->any())
                        <div class="rounded-lg border border-red-300 bg-red-100 p-4 text-red-800 text-sm mb-4 shadow flex items-center gap-2">
                            <i class="fa-solid fa-circle-exclamation text-lg"></i>
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Nombre</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-green-500">
                                <i class="fa-solid fa-user"></i>
                            </span>
                            <input 
                                type="text" 
                                name="name" 
                                value="{{ old('name', $usuario->name) }}"
                                class="w-full border border-gray-300 rounded-xl p-3 pl-10 focus:ring-2 focus:ring-green-400 focus:border-green-400 transition text-gray-900 bg-gray-50" 
                                required
                                pattern="^([A-Za-zÁÉÍÓÚáéíóúÑñ]+(?:\s[A-Za-zÁÉÍÓÚáéíóúÑñ]+)*)$"
                                oninput="this.value = this.value
                                    .replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '')
                                    .replace(/\s+/g, ' ')
                                    .split(' ')
                                    .map(w => w.charAt(0).toUpperCase() + w.slice(1).toLowerCase())
                                    .join(' ');"
                                autocomplete="off"
                                placeholder="Ejemplo: Juan Pérez"
                            >
                        </div>
                    </div>

                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Email</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-green-500">
                                <i class="fa-solid fa-envelope"></i>
                            </span>
                            <input type="email" name="email" value="{{ old('email', $usuario->email) }}"
                                class="w-full border border-gray-300 rounded-xl p-3 pl-10 focus:ring-2 focus:ring-green-400 focus:border-green-400 transition text-gray-900 bg-gray-50" required>
                        </div>
                    </div>

                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Rol</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-green-500">
                                <i class="fa-solid fa-user-shield"></i>
                            </span>
                            <select name="rol" class="w-full border border-gray-300 rounded-xl p-3 pl-10 focus:ring-2 focus:ring-green-400 focus:border-green-400 transition text-gray-900 bg-gray-50" required>
                                <option value="admin" {{ old('rol', $usuario->rol) == 'admin' ? 'selected' : '' }}>
                                    Administrador</option>
                                <option value="cajero" {{ old('rol', $usuario->rol) == 'cajero' ? 'selected' : '' }}>Cajero
                                </option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Estado</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-green-500">
                                <i class="fa-solid fa-toggle-on"></i>
                            </span>
                            <select name="activo" class="w-full border border-gray-300 rounded-xl p-3 pl-10 focus:ring-2 focus:ring-green-400 focus:border-green-400 transition text-gray-900 bg-gray-50" required>
                                <option value="1" {{ old('activo', $usuario->activo) ? 'selected' : '' }}>✅ Activo</option>
                                <option value="0" {{ !old('activo', $usuario->activo) ? 'selected' : '' }}>🚫 Inactivo
                                </option>
                            </select>
                        </div>
                    </div>

                    {{-- Toggle para cambiar contraseña --}}
                    <div class="pt-4">
                        <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                            <input id="togglePassword" type="checkbox" class="h-4 w-4 rounded border-gray-300 accent-green-500 transition-all duration-200">
                            <span class="font-semibold text-gray-700 flex items-center gap-2">
                                <i class="fa-solid fa-key"></i>
                                Cambiar contraseña <span class="text-xs text-gray-400">(opcional)</span>
                            </span>
                        </label>
                    </div>

                    <div id="passwordFields" class="mt-3 hidden animate-fade-in">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block font-semibold text-gray-700 mb-2">Nueva contraseña</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-green-500">
                                        <i class="fa-solid fa-lock"></i>
                                    </span>
                                    <input id="password" type="password" name="password"
                                        class="w-full border border-gray-300 rounded-xl p-3 pl-10 pr-10 focus:ring-2 focus:ring-green-400 focus:border-green-400 transition text-gray-900 bg-gray-50" placeholder="Mínimo 6 caracteres">
                                    <button type="button" onclick="togglePasswordVisibility('password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-green-600 focus:outline-none">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div>
                                <label class="block font-semibold text-gray-700 mb-2">Confirmar contraseña</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-green-500">
                                        <i class="fa-solid fa-lock"></i>
                                    </span>
                                    <input id="password_confirmation" type="password" name="password_confirmation"
                                        class="w-full border border-gray-300 rounded-xl p-3 pl-10 pr-10 focus:ring-2 focus:ring-green-400 focus:border-green-400 transition text-gray-900 bg-gray-50" placeholder="Repite la contraseña">
                                    <button type="button" onclick="togglePasswordVisibility('password_confirmation', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-green-600 focus:outline-none">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <script>
                            function togglePasswordVisibility(fieldId, btn) {
                                const input = document.getElementById(fieldId);
                                const icon = btn.querySelector('i');
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
                        <p class="text-xs text-gray-500 mt-2 text-center">
                            Si dejas estos campos vacíos, la contraseña actual se mantiene.
                        </p>
                    </div>

                    <div class="flex justify-center mt-8">
                        <button type="submit"
                            class="bg-gradient-to-r from-green-500 to-green-700 text-white px-8 py-3 rounded-xl shadow-lg hover:from-green-600 hover:to-green-800 transition font-bold text-lg flex items-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i> Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Animación fade-in --}}
    <style>
        .animate-fade-in {
            animation: fadeIn 0.4s;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px);}
            to { opacity: 1; transform: translateY(0);}
        }
    </style>

    {{-- Script simple para mostrar/ocultar y requerir campos de contraseña --}}
    <script>
        const toggle = document.getElementById('togglePassword');
        const fields = document.getElementById('passwordFields');
        const pass = document.getElementById('password');
        const passConf = document.getElementById('password_confirmation');

        const setRequired = (on) => {
            if (on) {
                pass.setAttribute('required', 'required');
                passConf.setAttribute('required', 'required');
            } else {
                pass.removeAttribute('required');
                passConf.removeAttribute('required');
                pass.value = '';
                passConf.value = '';
            }
        };

        toggle.addEventListener('change', (e) => {
            const on = e.target.checked;
            fields.classList.toggle('hidden', !on);
            setRequired(on);
        });

        window.addEventListener('DOMContentLoaded', () => {
            if (pass.value || passConf.value) {
                toggle.checked = true;
                fields.classList.remove('hidden');
                setRequired(true);
            }
        });
    </script>
@endsection
