<?php

namespace App\Izin\Http\Controllers\Superadmin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Http\Controllers\User\SertifikatsController;
use App\Izin\Models\Izin_Laporankegiatans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ReviewLaporanKegiatansController extends Controller
{
    public function reviewForm($id)
    {
        $laporankegiatans = Izin_Laporankegiatans::with([
            'identitassurats',
            'detaillaporankegiatans',
            'usulankegiatans'
        ])
            ->findOrFail($id);

        return view('pages.laporankegiatan.review_laporan_kegiatan', compact('laporankegiatans'));
    }

    public function reviewUpload(Request $request, $id)
    {
        // Ambil data usulan
        $laporankegiatans = Izin_Laporankegiatans::with('usulankegiatans')->findOrFail($id);

        // Validasi input
        $request->validate([
            'actionusulan_kegiatan' => 'required|in:accepted,rejected',
            'noteusulan_kegiatan' => 'nullable|string|max:2000',
        ]);

        $statususulan_update = ($request->actionusulan_kegiatan == 'accepted') ? 'finish' : 'completed';

        // Simpan hanya status ke database
        if ($laporankegiatans->usulankegiatans) {
            $laporankegiatans->usulankegiatans->update([
                'statususulan_kegiatan' => $statususulan_update,
            ]);
        }

        // Ambil ID admin yang mengajukan usulan
        $admin_Id = $laporankegiatans->usulankegiatans->dibuat_oleh;
        $status_text = $statususulan_update === 'finish' ? 'Disetujui' : 'Ditolak';

        // Simpan notes review ke cache untuk admin tersebut
        Cache::put(
            'pending_note_usulan_kegiatan_for_admin_' . $admin_Id,
            [
                'id' => $laporankegiatans->usulankegiatans->id,
                'nama_kegiatan' => $laporankegiatans->usulankegiatans->nama_kegiatan,
                'statususulan_kegiatan' => $status_text,
                'noteusulan_kegiatan' => $request->noteusulan_kegiatan,
                'waktu' => now()->format('d/m/Y H:i'),
            ],
            now()->addHours(2)
        );

        // Simpan notes review ke cache dengan key unik
        /*$noteusulan_kegiatan = [
            'id' => $usulankegiatans->id,
            'nama_kegiatan' => $usulankegiatans->nama_kegiatan,
            'statususulan_kegiatan' => $request->actionusulan_kegiatan,
            'noteusulan_kegiatan' => $request->noteusulan_kegiatan,
            'waktu' => now()->format('d/m/Y H:i'),
        ];

        // Simpan untuk semua admin 
        Cache::put('pending_note_usulan_kegiatan_for_admin', $noteusulan_kegiatan, now()->addHours(2));*/

        // Kalau diterima, generate sertifikat otomatis
        if ($request->actionusulan_kegiatan === 'accepted') {
            $sertifikatController = new SertifikatsController();
            $sertifikats = $sertifikatController->create(new Request([
                'laporankegiatan_id' => $laporankegiatans->id,
                'tanggalkeluarsertifikat_kegiatan' => now()->toDateString(),
            ]));

            // Redirect ke halaman pending
            return redirect()
                ->route('superadmin.balasanlaporankegiatan.create', ['id' => $id])
                ->with(['success', "Usulan kegiatan telah berhasil di{$request->actionusulan_kegiatan} dan catatan telah dikirim ke admin.", 'sertifikat_id' => $sertifikats->id]);
        }
        // Jika ditolak, kembali ke halaman daftar pending
        return redirect()
            ->route('superadmin.usulankegiatan.pending')
            ->with('success', "Usulan kegiatan telah berhasil di{$request->actionusulan_kegiatan}.");

    }
}
