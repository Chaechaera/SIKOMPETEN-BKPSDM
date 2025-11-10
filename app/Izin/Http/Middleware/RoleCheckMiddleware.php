<?php

namespace App\Izin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $roles): Response
    {
        // Cek apakah user sudah login dan punya role yang sesuai
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Ambil user saat ini
        $user = Auth::user();

        // Jika middleware dipanggil seperti 'role:superadmin|admin', ubah string jadi array
        $roles = is_array($roles) ? $roles : explode('|', $roles);

        // Kalau pakai kolom `role` di tabel users
        if (!in_array($user->role, $roles)) {
            abort(403, 'Unauthorized Access');
        }

        return $next($request);
    }
}
