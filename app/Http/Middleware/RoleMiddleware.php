<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Belum login → ke halaman login
        if (!Auth::check()) {
            return redirect('/login');
        }

        $userRole = Auth::user()->role;

        // Role cocok → lanjutkan request
        if ($userRole === $role) {
            return $next($request);
        }

        // Sudah login tapi role beda → arahkan ke dashboard yang sesuai
        // Ini mencegah redirect loop
        return match($userRole) {
            'Admin'    => redirect('/admin/dashboard'),
            'Dokter'   => redirect('/dokter/dashboard'),
            'Pasien'   => redirect('/pasien/dashboard'),
            'Apoteker' => redirect('/apoteker/dashboard'),
            default    => redirect('/login'),
        };
    }
}