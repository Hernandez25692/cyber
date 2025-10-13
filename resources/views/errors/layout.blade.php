<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Ocurrió un error')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Usa Tailwind vía Vite si lo prefieres: @vite(['resources/css/app.css']) --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gray-50 flex items-center justify-center p-6">
    @php
        $isDebug = config('app.debug');
        $user = auth()->user();
        $homeRoute = $user ? ($user->rol === 'admin' ? route('admin.index') : route('pos')) : route('login');
    @endphp

    <div class="max-w-xl w-full bg-white rounded-2xl shadow-sm p-8">
        <div class="flex items-center gap-3">
            <div
                class="h-12 w-12 rounded-full bg-gradient-to-br from-indigo-500 to-blue-500 flex items-center justify-center text-white text-xl font-bold">
                @yield('code', 'Error')
            </div>
            <h1 class="text-2xl font-semibold text-gray-900">@yield('title')</h1>
        </div>

        <p class="mt-4 text-gray-600">@yield('message')</p>

        @hasSection('actions')
            <div class="mt-6">@yield('actions')</div>
        @else
            <div class="mt-6 flex flex-wrap items-center gap-3">
                <a href="{{ $homeRoute }}"
                    class="inline-flex items-center px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
                    Ir al panel
                </a>
                <a href="{{ url()->previous() }}"
                    class="inline-flex items-center px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                    Volver atrás
                </a>
            </div>
        @endif

        @if ($isDebug && isset($exception) && $exception->getMessage())
            <div class="mt-6 border-t pt-4">
                <p class="text-xs text-gray-400">Debug:</p>
                <pre class="text-xs text-gray-500 whitespace-pre-wrap">{{ $exception->getMessage() }}</pre>
            </div>
        @endif

        <p class="mt-6 text-xs text-gray-400">
            {{ now()->format('Y-m-d H:i:s') }} • {{ request()->method() }} {{ request()->path() }}
        </p>
    </div>
</body>

</html>
