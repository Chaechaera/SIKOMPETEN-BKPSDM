<?php

namespace App\Izin\Http\Controllers\Admin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Kirimlaporankegiatans;
use App\Izin\Models\Izin_Kirimusulankegiatans;
use App\Izin\Models\Izin_Laporankegiatans;
use App\Izin\Models\Izin_Usulankegiatans;
use App\Izin\Services\IdentitasSuratsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KirimLaporanKegiatansController extends Controller
{
    /**
     * Tampilkan Form Kirim Usulan Kegiatan
     */
    public function create($laporankegiatan_id)
    {
        $laporankegiatans = Izin_Laporankegiatans::findOrFail($laporankegiatan_id);

        //return view('pages.laporankegiatan.kirim_laporan_kegiatan', compact('usulankegiatan'));
        return view('pages.laporankegiatan.kirim_laporan_kegiatan', [
            'laporankegiatans' => $laporankegiatans,
            //'metodepelatihans' => Izin_RefMetodepelatihans::select('id', 'metode_pelatihan')->get(),
        ]);
    }

    /**
     * Simpan file usulan kegiatan dari admin
     */
    public function store(Request $request, IdentitasSuratsService $identitassuratservice)
    {
        // Validasi input
        $request->validate([
            'filekirim_inputlaporankegiatan' => 'required|file|mimes:pdf,doc,docx|max:10240',
            //'identitassurat_id' => 'required|exists:izin_identitassurats,id',
            'laporankegiatan_id' => 'required',
        ]);

        $user = Auth::user();

        DB::transaction(function () use ($request, $identitassuratservice, $user) {

        // 1️⃣ Ambil laporan + inputlaporan
        $laporan = Izin_Laporankegiatans::with('inputlaporankegiatans')
            ->findOrFail($request->laporankegiatan_id);

        // 1️⃣ Simpan identitas surat
        $identitassurats = $identitassuratservice->create(
            $request->only([
                'nomor_surat',
                'tanggal_surat',
                'perihal_surat',
                'sifat_surat',
                'lampiran_surat',
            ])
        );

        // Ambil Usulan Kegiatan
        //$usulan = Izin_Usulankegiatans::findOrFail($request->usulankegiatan_id);

        // Upload file
        if ($request->hasFile('filekirim_inputlaporankegiatan')) {
            $kirimlaporankegiatans = $request->file('filekirim_inputlaporankegiatan')
                ->storeAs(
                    'izin/filekirim_inputlaporankegiatan',
                    time() . '_' . $request->file('filekirim_inputlaporankegiatan')->getClientOriginalName(),
                    'public'
                );
        }

        // Simpan ke tabel Kirim Usulan Kegiatan
        Izin_Kirimlaporankegiatans::create([
            'inputlaporankegiatan_id' => $laporan->inputlaporankegiatans->id,
            'identitassurat_id' => $identitassurats->id,
            'filekirim_inputlaporankegiatan' => $kirimlaporankegiatans,
            'tanggalkirim_inputlaporankegiatan' => now(),
            'nipadmin_inputlaporankegiatan' => $user->nip,
            'statuslaporan_kegiatan' => 'need_review',
        ]);

        // 🔥 UPDATE STATUS USULAN
        $laporan->update([
            'statuslaporan_kegiatan' => 'need_review',
        ]);
        /*Izin_Laporankegiatans::where('id', $request->laporankegiatan_id)
            ->update([
                'statuslaporan_kegiatan' => 'need_review'
            ]);*/
        });

        // Redirect dengan notifikasi sukses
        return redirect()->route('admin.usulankegiatan.index')->with('success', 'Usulan kegiatan berhasil dikirim!');
    }
}
