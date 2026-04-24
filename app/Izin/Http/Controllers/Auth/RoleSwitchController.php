<?php

namespace App\Izin\Http\Controllers\Auth;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controller untuk switching role/user dalam development mode
 * Hanya aktif jika APP_ENV=local
 */
class RoleSwitchController extends Controller
{
    /**
     * Show role switching interface
     */
    public function showSwitcher()
    {
        if (app()->isProduction()) {
            abort(404);
        }

        $currentUser = Auth::user();
        $users = User::all();
        
        return view('auth.role-switcher', [
            'userID' => $currentUser?->id,
            'users' => $users,
        ]);
    }

    /**
     * Switch to another user
     */
    public function switchUser(Request $request): RedirectResponse
    {
        if (app()->isProduction()) {
            abort(404);
        }

        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $user = User::find($request->user_id);
        Auth::login($user);
        
        $request->session()->regenerate();
        session(['active_role' => $user->role]);

        // Redirect berdasarkan role
        return match($user->role) {
            'superadmin' => redirect()->route('superadmin.dashboard'),
            'admin' => redirect()->route('admin.dashboard'),
            'user' => redirect()->route('user.dashboard'),
            default => redirect('/')
        };
    }
}
