<?php

namespace App\Izin\Http\Controllers\Superadmin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Http\Controllers\User\SertifikatsController;
use App\Izin\Models\Izin_Laporankegiatans;
use App\Izin\Models\Izin_Sertifikats;
use App\Izin\Models\Izin_Verifikasilaporankegiatans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewLaporanKegiatansController extends Controller
{
    /**
     * Tampilkan Form Review Laporan Hasil Kegiatan
     */
    public function reviewForm($id)
    {
        // Eager load relasi dari model dan temukan laporan kegiatan berdasarkan id
        $laporankegiatans = Izin_Laporankegiatans::with([
            'detaillaporankegiatans',
            'inputlaporankegiatans',
            'inputlaporankegiatans.inputusulankegiatans',
            'inputlaporankegiatans.inputusulankegiatans.usulankegiatans',
        ])->findOrFail($id);

        // Redirect ke halaman review laporan kegiatan
        return view('pages.laporankegiatan.review_laporan_kegiatan', compact('laporankegiatans'));
    }

    /**
     * Simpan Hasil Review Laporan Hasil Kegiatan
     */
    public function reviewUpload(Request $request, $id)
    {
        // Ambil data laporan kegiatan
        $laporankegiatans = Izin_Laporankegiatans::findOrFail($id);

        // Validasi request
        $request->validate([
            'actionlaporan_kegiatan' => 'required|in:accepted,rejected',
            'catatan_verifikasilaporankegiatan' => 'nullable|string|max:2000',
        ]);

        // Transaksi DB berlangsung
        DB::transaction(function () use ($request, $id) {

            // Ambil data laporan kegiatan berdasarkan id
            $laporankegiatans = Izin_Laporankegiatans::findOrFail($id);

            // Update status laporan kegiatan jika itu "Rejected"
            if ($request->actionlaporan_kegiatan === 'rejected') {
                $laporankegiatans->update([
                    'statuslaporan_kegiatan' => 'revisi',
                ]);
            }

            // Simpan data verifikasi laporan hasil kegiatan
            Izin_Verifikasilaporankegiatans::create([
                'laporankegiatan_id' => $laporankegiatans->id,
                'tanggalverifikasi_inputlaporankegiatan' => now(),
                'nipadmin_verifikasilaporankegiatan' => Auth::user()->nip,
                'status_verifikasilaporankegiatan' => $request->actionlaporan_kegiatan,
                'catatan_verifikasilaporankegiatan' => $request->catatan_verifikasilaporankegiatan,
                'is_read' => false,
            ]);
        });

        // Generate sertifikat otomatis jika itu "Accepted"
        if ($request->actionlaporan_kegiatan === 'accepted') {
            $sertifikatController = new SertifikatsController();
            $sertifikats = $sertifikatController->create(new Request([
                'laporankegiatan_id' => $laporankegiatans->id,
            ]));

            // Ambil sertifikat berdasarkan id laporan kegiatan
            $sertifikat = Izin_Sertifikats::where('laporankegiatan_id', $id)->first();

            // Redirect ke halaman buat balasan laporan hasil kegiatan
            return redirect()
                ->route('superadmin.balasanlaporankegiatan.create', ['id' => $id])
                ->with([
                    'success' => "Usulan kegiatan telah berhasil di{$request->actionlaporan_kegiatan} dan catatan telah dikirim ke admin.",
                    'sertifikat_id' => optional($sertifikat)->id
                ]);
        }

        // Redirect ke halaman daftar usulan kegiatan yang perlu di review jika itu "Rejected"
        return redirect()
            ->route('superadmin.usulankegiatan.pending')
            ->with('success', "Usulan kegiatan telah berhasil di{$request->actionlaporan_kegiatan}.");
    }
}
