<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | CYBER Y VARIEDADES SANDOVAL</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f2027 0%, #2c5364 100%);
            min-height: 100vh;
        }
        .login-card {
            background: rgba(30, 41, 59, 0.95);
            border-radius: 2rem;
            box-shadow: 0 20px 60px 0 rgba(0,0,0,0.7), 0 1.5px 6px 0 rgba(16,185,129,0.08);
            border: 1.5px solid rgba(16,185,129,0.15);
            transition: box-shadow 0.3s;
        }
        .login-card:hover {
            box-shadow: 0 30px 80px 0 rgba(16,185,129,0.15), 0 1.5px 6px 0 rgba(16,185,129,0.12);
        }
        .input-field {
            transition: box-shadow 0.2s, border 0.2s;
            background: rgba(51,65,85,0.85);
            border: 1.5px solid rgba(16,185,129,0.15);
        }
        .input-field:focus {
            box-shadow: 0 0 0 3px rgba(16,185,129,0.25);
            border-color: #10b981;
            background: rgba(51,65,85,1);
        }
        .btn-login {
            background: linear-gradient(90deg, #10b981 0%, #059669 100%);
            letter-spacing: 1px;
            text-transform: uppercase;
            font-weight: 700;
            box-shadow: 0 4px 20px 0 rgba(16,185,129,0.18);
            transition: transform 0.15s, box-shadow 0.2s;
        }
        .btn-login:hover {
            transform: translateY(-3px) scale(1.03);
            box-shadow: 0 8px 32px 0 rgba(16,185,129,0.25);
        }
        .brand-glow {
            text-shadow: 0 0 8px #10b981, 0 0 16px #10b98144;
        }
        .logo-glow {
            box-shadow: 0 0 0 6px #10b98122, 0 0 24px #10b98144;
        }
        .glass {
            background: rgba(255,255,255,0.04);
            backdrop-filter: blur(8px);
            border-radius: 1.5rem;
        }
        .divider {
            border-top: 1.5px solid rgba(16,185,129,0.12);
        }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen p-4">

    <div class="login-card w-full max-w-lg p-10 glass">
        <div class="flex flex-col items-center mb-8">
            <div class="bg-white p-2 rounded-full logo-glow mb-4 flex items-center justify-center w-32 h-32 mx-auto border-4 border-emerald-400/30">
                <img src="{{ asset('storage/logo/logo1.png') }}" alt="Logo CYBER Y VARIEDADES SANDOVAL" class="w-28 h-28 object-contain rounded-full">
            </div>
            <h1 class="text-3xl font-extrabold text-white text-center brand-glow tracking-wide drop-shadow-lg">
                CYBER Y VARIEDADES <span class="text-emerald-400">SANDOVAL</span>
            </h1>
            <p class="text-gray-300 text-base mt-2 text-center font-medium tracking-wide">Sistema de Punto de Venta</p>
        </div>

        @if (session('status'))
            <div class="mb-4 p-3 bg-emerald-500/10 text-emerald-400 text-sm rounded-lg border border-emerald-500/30">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-6">
                <label for="email" class="block text-gray-200 text-sm font-semibold mb-1">Usuario o Correo</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </div>
                    <input id="email" type="email" name="email" required autofocus
                        class="input-field w-full pl-10 pr-4 py-3 rounded-lg text-gray-100 placeholder-gray-400 focus:outline-none"
                        placeholder="usuario@ejemplo.com" value="{{ old('email') }}">
                </div>
                @error('email')
                    <p class="text-red-400 text-xs mt-1 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password" class="block text-gray-200 text-sm font-semibold mb-1">Contraseña</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input id="password" type="password" name="password" required
                        class="input-field w-full pl-10 pr-12 py-3 rounded-lg text-gray-100 placeholder-gray-400 focus:outline-none"
                        placeholder="••••••••">
                    <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-emerald-400 focus:outline-none">
                        <svg id="eyeIcon" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path id="eyeOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0c0 5-4.03 9-9 9S3 17 3 12 7.03 3 12 3s9 4.03 9 9z" />
                            <path id="eyeClosed" style="display:none;" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18M9.53 9.53A3 3 0 0012 15a3 3 0 002.47-5.47M7.05 7.05A9.003 9.003 0 003 12c0 5 4.03 9 9 9a8.96 8.96 0 005.95-2.05M17.94 17.94A9.003 9.003 0 0021 12c0-5-4.03-9-9-9a8.96 8.96 0 00-5.95 2.05" />
                        </svg>
                    </button>
                </div>
                <script>
                    function togglePassword() {
                        const passwordInput = document.getElementById('password');
                        const eyeOpen = document.getElementById('eyeOpen');
                        const eyeClosed = document.getElementById('eyeClosed');
                        if (passwordInput.type === 'password') {
                            passwordInput.type = 'text';
                            eyeOpen.style.display = 'none';
                            eyeClosed.style.display = '';
                        } else {
                            passwordInput.type = 'password';
                            eyeOpen.style.display = '';
                            eyeClosed.style.display = 'none';
                        }
                    }
                </script>
                @error('password')
                    <p class="text-red-400 text-xs mt-1 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <button type="submit"
                class="btn-login w-full text-white font-bold py-3 px-4 rounded-lg transition-all duration-200 shadow-lg flex items-center justify-center gap-2">
                Acceder al Sistema
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </form>
        
        <div class="mt-8 pt-6 divider text-center">
            <p class="text-gray-400 text-xs tracking-wide">
                © 2025 CYBER Y VARIEDADES SANDOVAL v1.0.0
            </p>
        </div>
    </div>

</body>

</html>