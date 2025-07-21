<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectBasedOnRole
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && $request->is('/dashboard')) {
            $rol = Auth::user()->rol;

            if ($rol === 'admin') {
                return redirect('/admin');
            }

            return redirect('/pos');
        }

        return $next($request);
    }
}
