<?php

namespace App\Izin\Http\Controllers\Superadmin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Kirimbalasanlaporankegiatans;
use App\Izin\Models\Izin_Laporankegiatans;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CetakBalasanLaporanKegiatansController extends Controller
{
    /**
     * Simpan Data Cetak Balasan Laporan Hasil Kegiatan Final
     */
    public function store($id)
    {
        // Eager load relasi dari model dan temukan laporankegiatan berdasarkan id
        $laporan = Izin_Laporankegiatans::with([
            'verifikasilaporankegiatanterakhir',
            'cetaklaporankegiatans',
            'inputlaporankegiatans'
        ])->findOrFail($id);

        // Transaksi DB berlangsung
        DB::transaction(function () use ($laporan) {

            // Ambil user yang sedang login saat ini
            $user = Auth::user();

            // Simpan dan update data kirim balasan laporan kegiatan final
            Izin_Kirimbalasanlaporankegiatans::updateOrCreate([
                'inputlaporankegiatan_id' => $laporan->inputlaporankegiatans->id,
            ], [
                'nipadmin_cetakbalasanlaporankegiatan' => $user->nip,
                'tanggalcetak_balasanlaporankegiatan' => now(),
            ]);
        });

        // Redirect ke halaman download surat balasan laporan kegiatan
        return redirect()->route('superadmin.balasanlaporankegiatan.download', $laporan->id)->with('success', 'Usulan berhasil dicetak.');
    }
}
