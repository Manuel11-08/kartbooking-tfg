<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si el usuario está logueado y es administrador, le dejamos pasar
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        
        return redirect('/')->with('error', 'Acceso denegado: Zona exclusiva de Boxes.');
    }
}