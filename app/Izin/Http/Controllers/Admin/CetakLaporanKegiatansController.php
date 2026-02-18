<?php

namespace App\Izin\Http\Controllers\Admin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Cetaklaporankegiatans;
use App\Izin\Models\Izin_Stempelunitkerjas;
use App\Izin\Models\Izin_Ttdunitkerjas;
use App\Izin\Models\Izin_Usulankegiatans;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CetakLaporanKegiatansController extends Controller
{
    /**
     * Simpan Data Cetak Laporan Hasil Kegiatan
     */
    public function store($id)
    {
        // Eager load model dari relasi dan temukan usulankegiatan berdasarkan id
        $usulan = Izin_Usulankegiatans::with([
            'inputlaporankegiatans.laporankegiatans'
        ])->findOrFail($id);

        // Ambil laporan kegiatan
        $input = $usulan->inputlaporankegiatans;
        $laporan = $input->laporankegiatans;

        // Verifikasi bahwa status laporankegiatan tidak sama dengan completed
        if ($laporan->statuslaporan_kegiatan !== 'completed') {
            abort(403, 'Laporan Kegiatan Sudah Dicetak');
        }

        // Transaksi DB berlangsung
        DB::transaction(function () use ($laporan, $input, $usulan) {

            // Ambil user yang sedang login saat ini
            $user = Auth::user();

            // Ambil ttdunitkerja terakhir user yang sedang login saat ini
            $ttdunitkerja_user = Izin_Ttdunitkerjas::where('subunitkerja_id', $user->subunitkerja_id)->latest()->first();
            $ttdunitkerja_id = $usulan->inputusulankegiatans?->ttdunitkerja_id ?? $ttdunitkerja_user?->id ?? null;

            // Ambil stempelunitkerja terakhir user yang sedang login saat ini
            $stempelunitkerja_user = Izin_Stempelunitkerjas::where('subunitkerja_id', $user->subunitkerja_id)->latest()->first();
            $stempelunitkerja_id = $usulan->inputusulankegiatans?->stempelunitkerja_id ?? $stempelunitkerja_user?->id ?? null;

            // Simpan data cetak laporan hasil kegiatan
            Izin_Cetaklaporankegiatans::create([
                'inputlaporankegiatan_id' => $input->id,
                'nipadmin_cetaklaporankegiatan' => $user->nip,
                'pjunitkerja_id' => $user->id,
                'statuslaporan_kegiatan' => 'pending',
                'ttdunitkerja_id' => $ttdunitkerja_id,
                'stempelunitkerja_id' => $stempelunitkerja_id
            ]);

            // Update status laporan kegiatan menjadi "pending"
            $laporan->update([
                'statuslaporan_kegiatan' => 'pending'
            ]);
        });

        // Redirect ke halaman download Laporan Hasil Kegiatan
        return redirect()->route('admin.laporankegiatan.download', $usulan->id)->with('success', 'Usulan berhasil dicetak.');
    }
}
