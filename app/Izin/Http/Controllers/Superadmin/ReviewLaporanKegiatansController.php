<?php

namespace App\Izin\Http\Controllers\Superadmin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Http\Controllers\User\SertifikatsController;
use App\Izin\Models\Izin_Laporankegiatans;
use App\Izin\Models\Izin_Sertifikats;
use App\Izin\Models\Izin_Verifikasilaporankegiatans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ReviewLaporanKegiatansController extends Controller
{
    public function reviewForm($id)
    {
        $laporankegiatans = Izin_Laporankegiatans::with([
            //'identitassurats',
            'detaillaporankegiatans',
            'inputlaporankegiatans',
            'inputlaporankegiatans.inputusulankegiatans',
            'inputlaporankegiatans.inputusulankegiatans.usulankegiatans',
        ])
            ->findOrFail($id);

        return view('pages.laporankegiatan.review_laporan_kegiatan', compact('laporankegiatans'));
    }

    public function reviewUpload(Request $request, $id)
    {
        // Ambil data usulan
        $laporankegiatans = Izin_Laporankegiatans::findOrFail($id);

        // Validasi input
        $request->validate([
            'actionlaporan_kegiatan' => 'required|in:accepted,rejected',
            'catatan_verifikasilaporankegiatan' => 'nullable|string|max:2000',
        ]);

        //$statususulan_update = ($request->actionusulan_kegiatan == 'accepted') ? 'finish' : 'completed';

        DB::transaction(function () use ($request, $id) {

            // Ambil data usulan
            $laporankegiatans = Izin_Laporankegiatans::findOrFail($id);

            // Simpan hanya status ke database
            /*$usulankegiatans->update([
            'statususulan_kegiatan' => $request->actionusulan_kegiatan,
        ]);*/

            // 🔥 PENTING: JANGAN UPDATE STATUS KECUALI REJECTED
            if ($request->actionlaporan_kegiatan === 'rejected') {
                $laporankegiatans->update([
                    'statuslaporan_kegiatan' => 'revisi',
                ]);
            }

            // Simpan histori verifikasi
            Izin_Verifikasilaporankegiatans::create([
                'laporankegiatan_id' => $laporankegiatans->id,
                'tanggalverifikasi_inputlaporankegiatan' => now(),
                'nipadmin_verifikasilaporankegiatan' => Auth::user()->nip,
                'status_verifikasilaporankegiatan' => $request->actionlaporan_kegiatan,
                'catatan_verifikasilaporankegiatan' => $request->catatan_verifikasilaporankegiatan,
                'is_read' => false,
            ]);
        });

        // Simpan hanya status ke database
        /*if ($laporankegiatans->usulankegiatans) {
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
        if ($request->actionlaporan_kegiatan === 'accepted') {
            $sertifikatController = new SertifikatsController();
            $sertifikats = $sertifikatController->create(new Request([
                'laporankegiatan_id' => $laporankegiatans->id,
                'tanggalkeluarsertifikat_kegiatan' => now()->toDateString(),
            ]));

            $sertifikat = Izin_Sertifikats::where('laporankegiatan_id', $id)->first();

            return redirect()
                ->route('superadmin.balasanlaporankegiatan.create', ['id' => $id])
                ->with([
                    'success' => "Usulan kegiatan telah berhasil di{$request->actionlaporan_kegiatan} dan catatan telah dikirim ke admin.",
                    'sertifikat_id' => optional($sertifikat)->id
                ]);
            /*// Redirect ke halaman pending
            return redirect()
                ->route('superadmin.balasanlaporankegiatan.create', ['id' => $id])
                ->with(['success', "Usulan kegiatan telah berhasil di{$request->actionlaporan_kegiatan} dan catatan telah dikirim ke admin.", 'sertifikat_id' => $sertifikats->id]);*/
        }

        // Jika ditolak, kembali ke halaman daftar pending
        return redirect()
            ->route('superadmin.usulankegiatan.pending')
            ->with('success', "Usulan kegiatan telah berhasil di{$request->actionlaporan_kegiatan}.");
    }
}
