<?php

namespace App\Izin\Http\Controllers\Auth;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Verifikasilaporankegiatans;
use App\Izin\Models\Izin_Verifikasiusulankegiatans;
use Illuminate\Support\Facades\Auth;
use App\Izin\Models\Izin_Laporanpesertakegiatans;
use App\Izin\Models\Izin_Sertifikats;
use App\Izin\Models\Izin_Usulankegiatans;
use Carbon\Carbon;

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

        $user = Auth::user();

        /* =========================================
        | FILTER BERDASARKAN UNIT KERJA ADMIN OPD
        ========================================= */

        $queryUsulan = Izin_Usulankegiatans::where(
            'subunitkerja_id',
            $user->subunitkerja_id
        );

        /* =========================
        | STATISTIK USULAN
        ========================= */

        $totalUsulan = (clone $queryUsulan)->count();

        $usulanPending = (clone $queryUsulan)
            ->get()
            ->filter(fn($item) => $item->status_ui === 'pending')
            ->count();

        $usulanDisetujui = (clone $queryUsulan)
            ->get()
            ->filter(fn($item) => $item->status_ui === 'accepted')
            ->count();

        $usulanDitolak = (clone $queryUsulan)
            ->get()
            ->filter(fn($item) => $item->status_ui === 'rejected')
            ->count();

        /* =========================
        | DATA USULAN TERBARU
        ========================= */

        $usulanTerbaru = (clone $queryUsulan)
            ->with([
                'dibuatoleh',
                'subunitkerjas',
                'inputusulankegiatans',
                'verifikasiusulankegiatanterakhir'
            ])
            ->latest()
            ->take(5)
            ->get();

        /* =========================
        | STATISTIK LAPORAN
        ========================= */

        $laporanMasuk = (clone $queryUsulan)
            ->get()
            ->filter(fn($item) => $item->isLaporan())
            ->count();

        $laporanPending = (clone $queryUsulan)
            ->get()
            ->filter(fn($item) => $item->isPendingLaporan())
            ->count();

        $laporanDisetujui = (clone $queryUsulan)
            ->get()
            ->filter(
                fn($item) =>
                $item->status_ui === 'accepted'
                    && $item->isLaporan()
            )
            ->count();

        $laporanDitolak = (clone $queryUsulan)
            ->get()
            ->filter(
                fn($item) =>
                $item->status_ui === 'rejected'
                    && $item->isLaporan()
            )
            ->count();

        /* =========================
        | LAPORAN TERBARU
        ========================= */

        $laporanTerbaru = (clone $queryUsulan)
            ->with([
                'dibuatoleh',
                'subunitkerjas',
                'inputlaporankegiatans'
            ])
            ->get()
            ->filter(fn($item) => $item->isLaporan())
            ->take(5);

        /* =========================
        | SERTIFIKAT TERBARU
        ========================= */

        $sertifikatTerbaru = Izin_Sertifikats::with([
            'inputusulankegiatans',
            'laporankegiatans',
            'pesertakegiatans'
        ])
            ->whereHas('inputusulankegiatans', function ($q) use ($user) {
                $q->where('subunitkerja_id', $user->subunitkerja_id);
            })
            ->latest()
            ->take(5)
            ->get();

        /* =========================
        | DATA MINGGU INI
        ========================= */

        $usulanMingguIni = (clone $queryUsulan)
            ->where(
                'created_at',
                '>=',
                Carbon::now()->subDays(7)
            )
            ->count();

        $laporanMingguIni = (clone $queryUsulan)
            ->whereHas('inputlaporankegiatans')
            ->where(
                'created_at',
                '>=',
                Carbon::now()->subDays(7)
            )
            ->count();

        /* =========================
        | PERSENTASE
        ========================= */

        $persenUsulanDisetujui = $totalUsulan > 0
            ? round(($usulanDisetujui / $totalUsulan) * 100)
            : 0;

        $persenUsulanDitolak = $totalUsulan > 0
            ? round(($usulanDitolak / $totalUsulan) * 100)
            : 0;

        $persenLaporanDisetujui = $laporanMasuk > 0
            ? round(($laporanDisetujui / $laporanMasuk) * 100)
            : 0;

        $persenLaporanDitolak = $laporanMasuk > 0
            ? round(($laporanDitolak / $laporanMasuk) * 100)
            : 0;

        return view('pages.dashboard.admin', compact(
            'catatan_verifikasi_usulan',
            'catatan_verifikasi_laporan',

            'totalUsulan',
            'usulanPending',
            'usulanDisetujui',
            'usulanDitolak',
            'usulanTerbaru',

            'laporanMasuk',
            'laporanPending',
            'laporanDisetujui',
            'laporanDitolak',
            'laporanTerbaru',

            'sertifikatTerbaru',

            'usulanMingguIni',
            'laporanMingguIni',

            'persenUsulanDisetujui',
            'persenUsulanDitolak',
            'persenLaporanDisetujui',
            'persenLaporanDitolak'
        ));
    }
}
