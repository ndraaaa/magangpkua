<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Cek 1: Apakah user sudah login?
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Cek 2: Apakah role user sesuai dengan yang diminta?
        if (Auth::user()->role !== $role) {
            // Jika tidak sesuai, tampilkan error 403 (Forbidden)
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}