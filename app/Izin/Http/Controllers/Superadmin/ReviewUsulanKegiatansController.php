<?php

namespace App\Izin\Http\Controllers\Superadmin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Usulankegiatans;
use App\Izin\Models\Izin_Verifikasiusulankegiatans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewUsulanKegiatansController extends Controller
{
    /**
     * Tampilkan Daftar Usulan Kegiatan yang Perlu Direview
     */
    public function pendingList(Request $request)
    {
        // Eager load relasi dari model
        $usulankegiatans = Izin_Usulankegiatans::with([
            'inputusulankegiatans',
            'verifikasiusulankegiatanterakhir',
            'cetakusulankegiatans',
            'balasanusulankegiatans'
        ])->get();

        // Urutkan usulankegiatan yang perlu direview berdasarkan statusnya
        if ($request->filled('statususulan_kegiatan')) {
            if (in_array($request->statususulan_kegiatan, ['accepted', 'rejected'])) {
                $usulankegiatans->whereHas('verifikasiusulankegiatanterakhir', function ($q) use ($request) {
                    $q->where('status_verifikasiusulankegiatan', $request->statususulan_kegiatan);
                });
            } else {
                $usulankegiatans->where('statususulan_kegiatan', $request->statususulan_kegiatan);
            }
        }

        // Redirect ke halaman daftar usulan kegiatan yang perlu direview
        return view('pages.usulankegiatan.pending_list_usulan_kegiatan', compact('usulankegiatans'));
    }

    /**
     * Tampilkan Form Review Pengajuan Usulan Kegiatan
     */
    public function reviewForm($id)
    {
        // Eager load relasi dari model dan temukan usulan kegiatan berdasarkan id
        $usulankegiatans = Izin_Usulankegiatans::with([
            'detailusulankegiatans',
            'inputusulankegiatans'
        ])->findOrFail($id);

        // Redirect ke halaman review usulan kegiatan
        return view('pages.usulankegiatan.review_usulan_kegiatan', compact('usulankegiatans'));
    }

    /**
     * Simpan Hasil Review Pengajuan Usulan Kegiatan
     */
    public function reviewUpload(Request $request, $id)
    {
        // Validasi request
        $request->validate([
            'actionusulan_kegiatan' => 'required|in:accepted,rejected',
            'catatan_verifikasiusulankegiatan' => 'nullable|string|max:2000',
        ]);

        // Transaksi DB berlangsung
        DB::transaction(function () use ($request, $id) {

            // Ambil usulan kegiatan berdasarkan id
            $usulankegiatans = Izin_Usulankegiatans::findOrFail($id);

            // Update status usulan kegiatan jika itu "Rejected"
            if ($request->actionusulan_kegiatan === 'rejected') {
                $usulankegiatans->update([
                    'statususulan_kegiatan' => 'revisi',
                ]);
            }

            // Simpan data verifikasi pengajuan usulan kegiatan
            Izin_Verifikasiusulankegiatans::create([
                'usulankegiatan_id' => $usulankegiatans->id,
                'tanggalverifikasi_inputusulankegiatan' => now(),
                'nipadmin_verifikasiusulankegiatan' => Auth::user()->nip,
                'status_verifikasiusulankegiatan' => $request->actionusulan_kegiatan,
                'catatan_verifikasiusulankegiatan' => $request->catatan_verifikasiusulankegiatan,
                'is_read' => false,
            ]);
        });

        // Redirect ke halaman daftar usulan kegiatan yang perlu direview
        return redirect()->route('superadmin.usulankegiatan.pending')->with('success', "Usulan kegiatan telah berhasil di{$request->actionusulan_kegiatan} dan catatan telah dikirim ke admin.");
    }
}
