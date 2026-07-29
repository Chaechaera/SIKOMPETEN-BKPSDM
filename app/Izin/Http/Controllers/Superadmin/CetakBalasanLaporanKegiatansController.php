<?php

namespace App\Izin\Http\Controllers\Superadmin;

use App\Izin\Models\Izin_Identitassurats;
use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Kirimbalasanlaporankegiatans;
use App\Izin\Models\Izin_Laporankegiatans;
use App\Izin\Models\Izin_Balasanlaporankegiatans;
use App\Izin\Models\Izin_Kopunitkerjas;
use App\Izin\Models\Izin_Stempelunitkerjas;
use App\Izin\Models\Izin_Ttdunitkerjas;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
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

    public function preview(Request $request, $id)
    {
        $laporan = Izin_Laporankegiatans::with([
            'detaillaporankegiatans',
            'inputlaporankegiatans.inputusulankegiatans.usulankegiatans',
            'inputlaporankegiatans.kirimlaporankegiatans.identitassurats',
        ])->findOrFail($id);

        // dummy object supaya template PDF tetap jalan
        $balasanlaporankegiatans = (object) [
            'laporankegiatans' => $laporan,
            'totalcapaianjp_kegiatan' => $laporan->totalcapaianjp_kegiatan,
        ];

        $bulan = now()->month;
        $tahun = now()->year;

        $urutan = Izin_Identitassurats::count() + 1;
        $urutan = str_pad($urutan, 3, '0', STR_PAD_LEFT);

        $cara = optional(
            $laporan->inputlaporankegiatans
                ?->inputusulankegiatans
                ?->usulankegiatans
        )->carapelatihan_id ?? 0;

        $nomorSurat =
            "{$urutan}/BKPSDM/{$this->bulanRomawi($bulan)}/{$cara}/{$tahun}";

        $admin = User::where(
            'nip',
            Auth::user()->nip
        )->first();

        $kop = Izin_Kopunitkerjas::where(
            'subunitkerja_id',
            $admin->subunitkerja_id
        )->latest()->first();

        $ttd = Izin_Ttdunitkerjas::where(
            'subunitkerja_id',
            $admin->subunitkerja_id
        )->latest()->first();

        $stempel = Izin_Stempelunitkerjas::where(
            'subunitkerja_id',
            $admin->subunitkerja_id
        )->latest()->first();

        $ttdPengusul = Izin_Ttdunitkerjas::where(
            'subunitkerja_id',
            $laporan
                ->inputlaporankegiatans
                ->inputusulankegiatans
                ?->usulankegiatans
                ?->subunitkerja_id
        )->latest()->first();

        $kop_path = public_path('build/assets/kop_surat.png');
        if (!file_exists($kop_path)) {
            $kop_path = null;
        }

        // Ambil parameter untuk menampilkan ttd, stempel, NIP, dan jabatan
        $showTtd = $request->boolean('show_ttd');
        $showStempel = $request->boolean('show_stempel');
        $showNIP = $request->boolean('show_nip');
        $showJabatan = $request->boolean('show_jabatan');

        return view(
            'pages.balasanlaporankegiatan.cetak_balasan_laporan',
            [
                'id' => $id,
                'laporankegiatans' => $laporan,
                'nomorSurat' => $nomorSurat,
                'balasanlaporankegiatans' => $balasanlaporankegiatans,
                'kop_path' => $kop_path,
                'kop' => $kop,
                'ttd' => $ttd,
                'stempel' => $stempel,
                'ttdPengusul' => $ttdPengusul,
                'showTtd' => $showTtd,
                'showStempel' => $showStempel,
                'showNIP' => $showNIP,
                'showJabatan' => $showJabatan,
            ]
        );
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
