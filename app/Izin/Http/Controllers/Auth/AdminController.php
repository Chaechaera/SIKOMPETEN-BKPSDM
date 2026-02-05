<?php

namespace App\Izin\Http\Controllers\Auth;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Verifikasiusulankegiatans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function index()
    {
        // Ambil note dari cache
        // $noteusulan_kegiatan = Cache::get('pending_note_usulan_kegiatan_for_admin');

        // (Opsional) Hapus cache setelah diambil supaya cuma muncul sekali
        //if ($noteusulan_kegiatan) {
        //Cache::forget('pending_note_usulan_kegiatan_for_admin');
        //}

        $catatan_verifikasi = Izin_Verifikasiusulankegiatans::whereHas('usulankegiatans', function ($q) {
            $q->where('dibuat_oleh', Auth::id());
        })
            ->where('is_read', false)
            ->latest()
            ->get();

        return view('pages.dashboard.admin', compact('catatan_verifikasi'));

        /*$user = Auth::user();

        // Ambil note dari session flash (kalau middleware udah jalan)
        $noteusulan_kegiatan = Session::get('noteusulan_kegiatan');

        // Kalau belum ada di session, cek cache berdasarkan user id
        if (!$noteusulan_kegiatan && $user) {
            $cacheKey = 'pending_note_usulan_kegiatan_for_admin_' . $user->id;
            $noteusulan_kegiatan = Cache::pull($cacheKey); // ambil + hapus dari cache

            // Simpan ke session biar bisa ditampilkan
            if ($noteusulan_kegiatan) {
                Session::flash('noteusulan_kegiatan', $noteusulan_kegiatan);
            }
        }

        return view('pages.dashboard.admin', compact('noteusulan_kegiatan'));*/
    }
}
