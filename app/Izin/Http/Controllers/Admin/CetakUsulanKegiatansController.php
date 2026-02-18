<?php

namespace App\Izin\Http\Controllers\Admin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Cetakusulankegiatans;
use App\Izin\Models\Izin_Stempelunitkerjas;
use App\Izin\Models\Izin_Ttdunitkerjas;
use App\Izin\Models\Izin_Usulankegiatans;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CetakUsulanKegiatansController extends Controller
{
    /**
     * Simpan Data Cetak Pengajuan Usulan Kegiatan
     */
    public function store($id)
    {
        // Temukan usulankegiatan berdasarkan id
        $usulan = Izin_Usulankegiatans::findOrFail($id);

        // Verifikasi bahwa status usulankegiatan tidak sama dengan draft
        if ($usulan->statususulan_kegiatan !== 'draft') {
            abort(403, 'Sudah Dicetak');
        }

        // Transaksi DB berlangsung
        DB::transaction(function () use ($usulan) {

            // Ambil user yang sedang login saat ini
            $user = Auth::user();

            // Ambil ttdunitkerja terakhir user yang sedang login saat ini
            $ttdunitkerja_user = Izin_Ttdunitkerjas::where('subunitkerja_id', $user->subunitkerja_id)->latest()->first();
            $ttdunitkerja_id = $usulan->inputusulankegiatans?->ttdunitkerja_id ?? $ttdunitkerja_user?->id ?? null;

            // Ambil stempelunitkerja terakhir user yang sedang login saat ini
            $stempelunitkerja_user = Izin_Stempelunitkerjas::where('subunitkerja_id', $user->subunitkerja_id)->latest()->first();
            $stempelunitkerja_id = $usulan->inputusulankegiatans?->stempelunitkerja_id ?? $stempelunitkerja_user?->id ?? null;

            // Simpan data cetak pengajuan usulan kegiatan
            Izin_Cetakusulankegiatans::create([
                'inputusulankegiatan_id' => $usulan->inputusulankegiatans->id,
                'nipadmin_cetakusulankegiatan' => $user->nip,
                'pjunitkerja_id' => $user->id,
                'statususulan_kegiatan' => 'pending',
                'ttdunitkerja_id' => $ttdunitkerja_id,
                'stempelunitkerja_id' => $stempelunitkerja_id
            ]);

            // Update status usulan kegiatan menjadi "pending"
            $usulan->update([
                'statususulan_kegiatan' => 'pending'
            ]);
        });

        // Redirect ke halaman download Surat Pengajuan dan KAK Usulan Kegiatan
        return redirect()->route('admin.usulankegiatan.download', $usulan->id)->with('success', 'Usulan berhasil dicetak.');
    }
}
