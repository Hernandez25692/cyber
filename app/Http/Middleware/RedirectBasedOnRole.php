<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectBasedOnRole
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && $request->path() === 'dashboard') {
            $rol = Auth::user()->rol;
            return $rol === 'admin' ? redirect('/admin') : redirect('/pos');
        }


        return $next($request);
    }
}
