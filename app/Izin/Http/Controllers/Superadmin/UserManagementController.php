<?php

namespace App\Izin\Http\Controllers\Superadmin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserManagementController extends Controller
{
    // New: list all users
    public function index()
    {
        $users = User::with('subunitkerjas')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('pages.manajemen_user', compact('users'));
    }

    public function verifyEmail(User $user)
    {
        // Check if already verified
        if ($user->hasVerifiedEmail()) {
            return back()->with('error', 'Email sudah terverifikasi');
        }

        // Mark email as verified
        $user->markEmailAsVerified();
        $user->status = 'aktif';
        $user->save();

        // Try to notify user — only attempt to send if mailable exists
        try {
            if (class_exists(\App\Izin\Mail\EmailVerified::class)) {
                Mail::to($user->email)->send(new \App\Izin\Mail\EmailVerified($user));
                return back()->with('success', 'Email berhasil diverifikasi dan notifikasi telah dikirim');
            }

            return back()->with('success', 'Email berhasil diverifikasi');
        } catch (\Exception $e) {
            return back()->with('warning', 'Email berhasil diverifikasi, tetapi gagal mengirim notifikasi');
        }
    }
}
