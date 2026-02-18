<?php

namespace App\Izin\Http\Controllers\Superadmin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Kirimbalasanusulankegiatans;
use App\Izin\Models\Izin_Usulankegiatans;
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
}
