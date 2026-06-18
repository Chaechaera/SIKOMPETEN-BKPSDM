<?php

namespace App\Izin\Http\Controllers\Auth;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Izin\Models\User;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = Auth::user();

if ($user->status !== 'aktif') {
    Auth::logout();

    return back()->withErrors([
        'email' => 'Akun Anda telah dinonaktifkan. Silakan hubungi administrator untuk mengaktifkan kembali.'
    ]);
}

if (! $user->hasVerifiedEmail()) {
    Auth::logout();

    return back()->withErrors([
        'email' => 'Alamat email belum diverifikasi. Silakan periksa email Anda atau minta tautan verifikasi baru.'
    ]);
}

$request->session()->regenerate();

session([
    'active_role' => $user->role
]);

return $this->authenticated($request, $user);

        /*$request->session()->regenerate();

        // ✅ SET ROLE AKTIF DEFAULT
    session(['active_role' => Auth::user()->role]);

        return $this->authenticated($request, Auth::user());*/
    }

    /**
     * Redirect berdasarkan role setelah login sukses.
     */
    protected function authenticated(Request $request, $user)
    {
        // Cek berdasarkan kolom 'role' di tabel users
        switch ($user->role) {
            case 'superadmin':
                return redirect()->route('superadmin.dashboard');
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'user':
                return redirect()->route('user.dashboard');
            default:
                Auth::logout();
                return redirect('/')->with('error', 'Role tidak dikenali.');
        }
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
