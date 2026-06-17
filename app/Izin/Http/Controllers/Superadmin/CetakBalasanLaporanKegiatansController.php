<?php

namespace App\Izin\Http\Controllers\Superadmin;
use App\Izin\Models\Izin_Identitassurats;
use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Kirimbalasanlaporankegiatans;
use App\Izin\Models\Izin_Laporankegiatans;
use App\Izin\Models\Izin_Balasanlaporankegiatans;
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

                    $balasan = Izin_Balasanlaporankegiatans::where(
                'inputlaporankegiatan_id',
                $laporan->inputlaporankegiatans->id
            )->first();

            if (!$balasan) {
                abort(404, 'Balasan tidak ditemukan');
            }

            return redirect()->route('superadmin.balasanlaporankegiatan.download', $balasan->id);
            }

public function preview($id)
{
    $laporan = Izin_Laporankegiatans::with('inputlaporankegiatans')
        ->findOrFail($id);

    $bulan = now()->month;
    $tahun = now()->year;

    $urutan = Izin_Identitassurats::count() + 1;
    $urutan = str_pad($urutan, 3, '0', STR_PAD_LEFT);
    $cara = optional(
    $laporan->inputlaporankegiatans
        ?->inputusulankegiatans
        ?->usulankegiatans
    )->carapelatihan_id ?? 0;
    $bulanRomawi = $this->bulanRomawi($bulan);
    $tahun = date('Y');

    $nomorSurat = "{$urutan}/BKPSDM/{$bulanRomawi}/{$cara}/{$tahun}";

    return view('pages.balasanlaporankegiatan.cetak_balasan_laporan', [
        'id' => $id,
        'laporankegiatans' => $laporan, // ✅ sekarang aman
        'nomorSurat' => $nomorSurat,
    ]);
}
private function bulanRomawi($bulan)
{
    $romawi = [
        1 => 'I',
        2 => 'II',
        3 => 'III',
        4 => 'IV',
        5 => 'V',
        6 => 'VI',
        7 => 'VII',
        8 => 'VIII',
        9 => 'IX',
        10 => 'X',
        11 => 'XI',
        12 => 'XII'
    ];

    return $romawi[(int)$bulan] ?? '-';
}


}