<?php

namespace App\Izin\Http\Controllers\Superadmin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Laporanpesertakegiatans;

class ValidasiLaporanPesertaKegiatansController extends Controller
{
    // List laporan peserta
    public function index()
    {
        $laporans = Izin_Laporanpesertakegiatans::with(['users', 'sertifikats'])
            ->latest()
            ->paginate(10);

        return view('pages.laporanpesertakegiatan.validasi_laporan_peserta', compact('laporans'));
    }

    // Approve laporan
    public function approve($id)
    {
        $laporan = Izin_Laporanpesertakegiatans::findOrFail($id);

        $laporan->update([
            'statuslaporan_pesertakegiatan' => 'approved'
        ]);

        return back()->with('success', 'Laporan berhasil disetujui.');
    }

    // Reject laporan
    public function reject($id)
    {
        $laporan = Izin_Laporanpesertakegiatans::findOrFail($id);

        $laporan->update([
            'statuslaporan_pesertakegiatan' => 'rejected'
        ]);

        return back()->with('success', 'Laporan berhasil ditolak.');
    }
}
