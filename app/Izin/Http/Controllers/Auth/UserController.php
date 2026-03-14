<?php

namespace App\Izin\Http\Controllers\Auth;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.user');
    }

    public function manajemenUser()
    {
        return view('pages.manajemen_user');
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:user,admin,superadmin',
        ]);

        // optional: cegah superadmin ubah dirinya sendiri
        if (auth()->id() === $user->id) {
            return back()->with('warning', 'Tidak dapat mengubah role diri sendiri.');
        }

        $user->role = $request->role;
        $user->save();

        return back()->with('success', 'Role user berhasil diperbarui.');
    }
}
