<?php

namespace App\Izin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Pastikan sudah login
        if (! $request->user()) {
            return redirect()->route('login');
        }

        // simple example: allow only role 'superadmin'
        if ($request->user()->role !== 'superadmin') {
            abort(403);
        }

        return $next($request);
    }
}
