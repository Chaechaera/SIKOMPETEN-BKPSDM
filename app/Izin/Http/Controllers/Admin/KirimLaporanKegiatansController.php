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
     * Tampilkan Form Kirim Laporan Hasil Kegiatan Final
     */
    public function create($laporankegiatan_id)
    {
        // Temukan laporankegiatan berdasarkan id laporankegiatan
        $laporankegiatans = Izin_Laporankegiatans::findOrFail($laporankegiatan_id);

        // Redirect ke halaman kirim laporan hasil kegiatan
        return view('pages.laporankegiatan.kirim_laporan_kegiatan', ['laporankegiatans' => $laporankegiatans]);
    }

    /**
     * Simpan File Kirim Laporan Hasil Kegiatan Final
     */
    public function store(Request $request, IdentitasSuratsService $identitassuratservice)
    {
        // Ambil user yang sedang login saat ini
        $user = Auth::user();

        // Validasi request
        $request->validate([
            'filekirim_inputlaporankegiatan' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'laporankegiatan_id' => 'required',
        ]);

        // Transaksi DB berlangsung
        DB::transaction(function () use ($request, $identitassuratservice, $user) {

            // Eager load relasi dari model dan temukan laporan berdasarkan request id laporankegiatan
            $laporan = Izin_Laporankegiatans::with('inputlaporankegiatans')->findOrFail($request->laporankegiatan_id);

            // Simpan identitassurat
            $identitassurats = $identitassuratservice->create(
                $request->only([
                    'nomor_surat',
                    'tanggal_surat',
                    'perihal_surat',
                    'sifat_surat',
                    'lampiran_surat',
                ])
            );

            // Upload file kirim laporan hasil kegiatan final
            if ($request->hasFile('filekirim_inputlaporankegiatan')) {
                $kirimlaporankegiatans = $request->file('filekirim_inputlaporankegiatan')
                    ->storeAs(
                        'izin/filekirim_inputlaporankegiatan',
                        time() . '_' . $request->file('filekirim_inputlaporankegiatan')->getClientOriginalName(),
                        'public'
                    );
            }

            // Simpan data kirim laporan hasil kegiatan final
            Izin_Kirimlaporankegiatans::create([
                'inputlaporankegiatan_id' => $laporan->inputlaporankegiatans->id,
                'identitassurat_id' => $identitassurats->id,
                'filekirim_inputlaporankegiatan' => $kirimlaporankegiatans,
                'tanggalkirim_inputlaporankegiatan' => now(),
                'nipadmin_inputlaporankegiatan' => $user->nip,
                'statuslaporan_kegiatan' => 'need_review',
            ]);

            // Update status laporan kegiatan menjadi "need review"
            $laporan->update([
                'statuslaporan_kegiatan' => 'need_review',
            ]);
        });

        // Redirect ke halaman daftar pengajuan usulan kegiatan
        return redirect()->route('admin.usulankegiatan.index')->with('success', 'Usulan kegiatan berhasil dikirim!');
    }
}
