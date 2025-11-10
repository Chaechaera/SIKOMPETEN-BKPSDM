<?php

namespace App\Izin\Http\Controllers\Admin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Detailusulankegiatans;
use App\Izin\Models\Izin_RefMetodepelatihans;
use App\Izin\Models\Izin_Usulankegiatans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailUsulanKegiatansController extends Controller
{
    /**
     * Tampilkan Form Bagian Detail Usulan Kegiatan Pada Form Ajukan Usulan Kegiatan
     */
    public function create($usulankegiatan_id)
    {
        $usulankegiatans = Izin_Usulankegiatans::findOrFail($usulankegiatan_id);

    return view('pages.usulankegiatan.ajukan_usulan_kegiatan', [
        'usulankegiatans' => $usulankegiatans,
        'metodepelatihans' => Izin_RefMetodepelatihans::select('id', 'metode_pelatihan')->get(),
    ]);
    }

    /**
     * Simpan Data Detail Usulan Kegiatan
     */
    public function store(Request $request)
    {
        $detailusulankegiatans = $request->only([
        'usulankegiatan_id',
        'latarbelakang_kegiatan',
        'dasarhukum_kegiatan',
        'uraian_kegiatan',
        'maksud_kegiatan',
        'tujuan_kegiatan',
        'hasil_kegiatan',
        'narasumber_kegiatan',
        'peserta_kegiatan',
        'alokasianggaran_kegiatan',
        'metodepelatihan_id'
    ]);

    // File upload
    if ($request->hasFile('jadwalpelaksanaan_kegiatan')) {
        $detailusulankegiatans['jadwalpelaksanaan_kegiatan'] = $request->file('jadwalpelaksanaan_kegiatan')
            ->store('izin/jadwalpelaksanaan_kegiatan', 'public');
    }

    Izin_Detailusulankegiatans::create($detailusulankegiatans);

    return redirect()->route('admin.dashboard')
        ->with('success', 'Usulan Kegiatan Berhasil Disimpan Secara Lengkap!');
}
}

