<?php

namespace App\Izin\Http\Controllers\Superadmin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Usulankegiatans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ReviewUsulanKegiatansController extends Controller
{
    public function pendingList(Request $request)
    {
        $usulankegiatans = Izin_Usulankegiatans::with([
            'identitassurats:id,nomor_surat,perihal_surat',
        ])
            ->select(['id', 'nama_kegiatan', 'subunitkerja_id', 'identitassurat_id', 'tanggalpelaksanaan_kegiatan', 'lokasi_kegiatan', 'statususulan_kegiatan']);
        
        /*if ($request->has('statususulan_kegiatan') && $request->statususulan_kegiatan != '') {
            $usulankegiatans->where('statususulan_kegiatan', $request->statususulan_kegiatan);
        } else {
            // Default tetap "pending" biar perilaku lama tidak berubah
            $usulankegiatans->where('statususulan_kegiatan', 'pending');
        }

        $usulankegiatans = $usulankegiatans->get();*/

        // Jika dropdown status diisi, baru filter
        if ($request->filled('statususulan_kegiatan')) {
            $usulankegiatans->where('statususulan_kegiatan', $request->statususulan_kegiatan);
        }

        // Urutkan biar yang terbaru di atas
        $usulankegiatans = $usulankegiatans->orderByDesc('created_at')->get();

        return view('pages.usulankegiatan.pending_list_usulan_kegiatan', compact('usulankegiatans'));
    }

    public function reviewForm($id)
    {
        $usulankegiatans = Izin_Usulankegiatans::with([
            'identitassurats', 
            'detailusulankegiatans'])
            ->findOrFail($id);

        return view('pages.usulankegiatan.review_usulan_kegiatan', compact('usulankegiatans'));
    }

    public function reviewUpload(Request $request, $id)
    {
        // Ambil data usulan
        $usulankegiatans = Izin_Usulankegiatans::findOrFail($id);
        
        // Validasi input
        $request->validate([
            'actionusulan_kegiatan' => 'required|in:accepted,rejected',
            'noteusulan_kegiatan' => 'nullable|string|max:2000',
        ]);

        // Simpan hanya status ke database
        $usulankegiatans->update([
            'statususulan_kegiatan' => $request->actionusulan_kegiatan,
        ]);

        // Ambil ID admin yang mengajukan usulan
        $admin_Id = $usulankegiatans->dibuat_oleh;

        // Simpan notes review ke cache untuk admin tersebut
        Cache::put(
        'pending_note_usulan_kegiatan_for_admin_' . $admin_Id,
        [
            'id' => $usulankegiatans->id,
            'nama_kegiatan' => $usulankegiatans->nama_kegiatan,
            'statususulan_kegiatan' => $request->actionusulan_kegiatan,
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

        // Redirect ke halaman pending
        return redirect()
            ->route('superadmin.usulankegiatan.pending')
            ->with('success', "Usulan kegiatan telah berhasil di{$request->actionusulan_kegiatan} dan catatan telah dikirim ke admin.");
    }
}
