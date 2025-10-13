<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Uso: ->middleware('role:admin')  o  ->middleware('role:admin,cajero')
     */
    public function handle(Request $request, Closure $next, string $roles)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Soportar múltiples roles separados por coma
        $allowed = array_map('trim', explode(',', $roles));

        if (! in_array($user->rol, $allowed, true)) {
            // 403 para bloquear acceso cruzado admin/cajero
            abort(403, 'Acceso no autorizado.');
        }

        return $next($request);
    }
}
