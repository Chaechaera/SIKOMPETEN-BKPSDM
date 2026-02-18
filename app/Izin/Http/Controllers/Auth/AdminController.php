<?php

namespace App\Izin\Http\Controllers\Auth;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Verifikasilaporankegiatans;
use App\Izin\Models\Izin_Verifikasiusulankegiatans;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Tampilkan Hasil Verifikasi di Halaman Dashboard
     */
    public function index()
    {
        // ================= HASIL VERIFIKASI USULAN KEGIATAN =================
        $catatan_verifikasi_usulan = Izin_Verifikasiusulankegiatans::whereHas('usulankegiatans', function ($q) {
            $q->where('dibuat_oleh', Auth::id());
        })
            ->where('is_read', false)
            ->latest()
            ->get();

        // Tandai sudah dibaca (USULAN)
        $idsUsulan = $catatan_verifikasi_usulan->pluck('id');
        if ($idsUsulan->isNotEmpty()) {
            Izin_Verifikasiusulankegiatans::whereIn('id', $idsUsulan)
                ->update([
                    'is_read' => true,
                    'read_at' => now(),
                ]);
        }

        // ================= HASIL VERIFIKASI LAPORAN KEGIATAN =================
        $catatan_verifikasi_laporan = Izin_Verifikasilaporankegiatans::whereHas('laporankegiatans.inputlaporankegiatans.inputusulankegiatans.usulankegiatans', function ($q) {
            $q->where('dibuat_oleh', Auth::id());
        })
            ->where('is_read', false)
            ->latest()
            ->get();

        // Tandai sudah dibaca (LAPORAN)
        $idsLaporan = $catatan_verifikasi_laporan->pluck('id');
        if ($idsLaporan->isNotEmpty()) {
            Izin_Verifikasilaporankegiatans::whereIn('id', $idsLaporan)
                ->update([
                    'is_read' => true,
                    'read_at' => now(),
                ]);
        }

        return view('pages.dashboard.admin', compact('catatan_verifikasi_usulan', 'catatan_verifikasi_laporan'));
    }
}
