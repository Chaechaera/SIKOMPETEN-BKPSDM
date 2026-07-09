<?php

namespace App\Izin\Http\Controllers\Superadmin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Identitassurats;
use App\Izin\Models\Izin_Kirimbalasanusulankegiatans;
use App\Izin\Models\Izin_Kopunitkerjas;
use App\Izin\Models\Izin_Stempelunitkerjas;
use App\Izin\Models\Izin_Ttdunitkerjas;
use Illuminate\Foundation\Auth\User;
use App\Izin\Models\Izin_Usulankegiatans;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CetakBalasanUsulanKegiatansController extends Controller
{
    /**
     * Simpan Data Cetak Balasan Pengajuan Usulan Kegiatan Final
     */
    public function store($id)
    {
        // Eager load relasi dari model dan temukan usulankegiatan berdasarkan id
        $usulan = Izin_Usulankegiatans::with([
            'verifikasiusulankegiatanterakhir',
            'cetakusulankegiatans',
            'inputusulankegiatans'
        ])->findOrFail($id);

        // Transaksi DB berlangsung
        DB::transaction(function () use ($usulan) {

            // Ambil user yang sedang login saat ini
            $user = Auth::user();

            // Simpan dan update data kirim balasan usulan kegiatan final
            Izin_Kirimbalasanusulankegiatans::updateOrCreate([
                'inputusulankegiatan_id' => $usulan->inputusulankegiatans->id,
            ], [
                'nipadmin_cetakbalasanusulankegiatan' => $user->nip,
                'tanggalcetak_balasanusulankegiatan' => now(),
            ]);
        });

        // Redirect ke halaman download surat balasan usulan kegiatan
        return redirect()->route('superadmin.usulankegiatan.downloadBalasan', $usulan->id)->with('success', 'Usulan berhasil dicetak.');
    }

    public function preview($id)
    {
        $usulan = Izin_Usulankegiatans::with([
            'detailusulankegiatans',
            'inputusulankegiatans.usulankegiatans'
        ])->findOrFail($id);

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
            $usulan
                ->inputusulankegiatans
                ?->usulankegiatans
                ?->subunitkerja_id
        )->latest()->first();

        $kop_path = public_path('build/assets/kop_surat.png');

        if (!file_exists($kop_path)) {
            $kop_path = null;
        }

        $pdf = Pdf::loadView(
            'pages.generatepdf.balasan_usulan_kegiatan',
            [
                'id' => $id,
                'usulankegiatans' => $usulan,
                'kop_path' => $kop_path,
                'kop' => $kop,
                'ttd' => $ttd,
                'stempel' => $stempel,
                'ttdPengusul' => $ttdPengusul,
            ]
        );

        return response(
            $pdf->output(),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="preview.pdf"',
            ]
        );
    }
}
