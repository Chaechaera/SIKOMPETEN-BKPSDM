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

        // ambil atau set active role
        $activeRole = session('active_role');

        if (!$activeRole) {
            $activeRole = Auth::user()->role;
            session(['active_role' => $activeRole]);
        }

        $roles = is_array($roles) ? $roles : explode('|', $roles);

        if (!in_array($activeRole, $roles)) {
            abort(403);
        }

        return $next($request); // Tampilkan hasil request
    }
}
