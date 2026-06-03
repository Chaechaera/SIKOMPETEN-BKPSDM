<?php

namespace App\Izin\Http\Controllers\Superadmin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_RefSubunitkerjas;
use App\Izin\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Mail;

class UserManagementController extends Controller
{
    // New: list all users
    public function index()
    {
        $search = request('search');
        $subunit = request('subunitkerja');

        $users = User::with('subunitkerjas')
            ->orderBy('created_at', 'desc')
            ->get()
            ->filter(function ($row) use ($search, $subunit) {

                $matchSearch = true;
                $matchSubunit = true;

                // 🔍 FILTER SEARCH
                if ($search) {
                    $matchSearch =
                        str_contains(strtolower($row->nama ?? ''), strtolower($search)) ||
                        str_contains(strtolower($row->subunitkerjas->sub_unitkerja ?? ''), strtolower($search));
                }

                // 🏢 FILTER SUBUNIT
                if ($subunit) {
                    $matchSubunit = optional($row->subunitkerjas)->id == $subunit;
                }

                return $matchSearch && $matchSubunit;
            });

        // 🔥 RESET INDEX
        $users = $users->values();

        // 🔥 PAGINATION (pakai users, bukan rekap)
        $page = request()->get('page', 1);
        $perPage = 20;

        $users = new LengthAwarePaginator(
            $users->forPage($page, $perPage),
            $users->count(),
            $perPage,
            $page,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );

        // ✅ DROPDOWN SUBUNIT (harus ambil full data, bukan pluck)
        $subunitkerjas = Izin_RefSubunitkerjas::orderBy('sub_unitkerja')->get();

        return view('pages.manajemen_user', compact('users', 'subunitkerjas'));
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
