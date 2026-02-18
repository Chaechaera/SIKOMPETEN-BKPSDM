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
        // Cek apakah user telah login dan memiliki role?
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Ambil user saat ini
        $user = Auth::user();

        // Jika middleware untuk role dipanggil maka ubah string jadi array
        $roles = is_array($roles) ? $roles : explode('|', $roles);

        // Jika menggunakan kolom role pada database user
        if (!in_array($user->role, $roles)) {
            abort(403, 'Unauthorized Access');
        }

        return $next($request); // Tampilkan hasil request
    }
}
