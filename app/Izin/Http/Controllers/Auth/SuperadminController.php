<?php

namespace App\Izin\Http\Controllers\Auth;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Laporankegiatans;
use App\Izin\Models\Izin_Laporanpesertakegiatans;
use App\Izin\Models\Izin_Sertifikats;
use App\Izin\Models\Izin_Usulankegiatans;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SuperadminController extends Controller
{
    public function index()
    {
        /* =========================
        | STATISTIK USULAN
        ========================= */

        $totalUsulan = Izin_Usulankegiatans::count();

        $usulanPending = Izin_Usulankegiatans::get()
            ->filter(fn($item) => $item->status_ui === 'pending')
            ->count();

        $usulanDisetujui = Izin_Usulankegiatans::get()
            ->filter(fn($item) => $item->status_ui === 'accepted' || $item->status_ui === 'finish')
            ->count();

        $usulanDitolak = Izin_Usulankegiatans::get()
            ->filter(fn($item) => $item->status_ui === 'rejected')
            ->count();


        /* =========================
        | DATA USULAN TERBARU
        ========================= */

        $usulanTerbaru = Izin_Usulankegiatans::with([
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

        $laporanMasuk = Izin_Usulankegiatans::get()
            ->filter(fn($item) => $item->isLaporan())
            ->count();

        $laporanPending = Izin_Usulankegiatans::get()
            ->filter(fn($item) => $item->isPendingLaporan())
            ->count();

        $laporanDisetujui = Izin_Usulankegiatans::get()
            ->filter(fn($item) => $item->status_ui === 'accepted' && $item->isLaporan())
            ->count();

        $laporanDitolak = Izin_Usulankegiatans::get()
            ->filter(fn($item) => $item->status_ui === 'rejected' && $item->isLaporan())
            ->count();


        /* =========================
        | LAPORAN TERBARU
        ========================= */

        $laporanTerbaru = Izin_Usulankegiatans::with([
            'dibuatoleh',
            'subunitkerjas',
            'inputlaporankegiatans'
        ])
            ->get()
            ->filter(fn($item) => $item->isLaporan())
            ->take(5);

        /* ==========================
        | STATISTIK LAPORAN PESERTA
        ============================= */

        $totalLaporanPeserta = Izin_Laporanpesertakegiatans::count();

        $totalSertifikatPeserta = Izin_Sertifikats::count();

        $laporanPesertaDisetujui = Izin_Laporanpesertakegiatans::where(
            'statuslaporan_pesertakegiatan',
            'approved'
        )->orWhere(
            'statuslaporan_pesertakegiatan',
            'finish'
        )->count();

        $laporanPesertaDitolak = Izin_Laporanpesertakegiatans::where(
            'statuslaporan_pesertakegiatan',
            'rejected'
        )->count();

        /* =========================
        | DATA MINGGU INI
        ========================= */

        $usulanMingguIni = Izin_Usulankegiatans::where(
            'created_at',
            '>=',
            Carbon::now()->subDays(7)
        )->count();

        $laporanMingguIni = Izin_Usulankegiatans::whereHas('inputlaporankegiatans')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->count();

        $laporanPesertaMingguIni = Izin_Laporanpesertakegiatans::where(
            'created_at',
            '>=',
            Carbon::now()->subDays(7)
        )->count();

        $sertifikatMingguIni = Izin_Sertifikats::where(
            'created_at',
            '>=',
            Carbon::now()->subDays(7)
        )->count();

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

        $persenLaporanPesertaDisetujui = $totalLaporanPeserta > 0
            ? round(($laporanPesertaDisetujui / $totalLaporanPeserta) * 100)
            : 0;

        $persenLaporanPesertaDitolak = $totalLaporanPeserta > 0
            ? round(($laporanPesertaDitolak / $totalLaporanPeserta) * 100)
            : 0;


        // TOTAL
        $total = Izin_Laporankegiatans::count();

        // DISETUJUI
        $disetujui = Izin_Laporankegiatans::get()
            ->filter(fn($item) =>
                in_array($item->status_laporan_ui, ['accepted', 'finish'])
            )->count();

        // MENUNGGU (FIX sesuai kebutuhan kamu)
        $menunggu = Izin_Laporankegiatans::get()
            ->filter(fn($item) =>
                $item->status_laporan_ui === 'need_review'
            )->count();

        // DATA TERBARU
        $laporans = Izin_Laporankegiatans::with([
            'inputlaporankegiatans.inputusulankegiatans.usulankegiatans.subunitkerjas'
        ])
        ->latest()
        ->take(5)
        ->get();

        return view('pages.dashboard.superadmin', compact(
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

            'totalLaporanPeserta',
            'totalSertifikatPeserta',
            'laporanPesertaDisetujui',
            'laporanPesertaDitolak',

            'usulanMingguIni',
            'laporanMingguIni',
            'laporanPesertaMingguIni',
            'sertifikatMingguIni',

            'persenUsulanDisetujui',
            'persenUsulanDitolak',
            'persenLaporanDisetujui',
            'persenLaporanDitolak',
            'persenLaporanPesertaDisetujui',
            'persenLaporanPesertaDitolak',

            'total',
            'disetujui',
            'menunggu',
            'laporans'
        ));
    }
}

