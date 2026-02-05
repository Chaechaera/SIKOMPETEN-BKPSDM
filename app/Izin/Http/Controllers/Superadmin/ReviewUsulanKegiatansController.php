<?php

namespace App\Izin\Http\Controllers\Superadmin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Usulankegiatans;
use App\Izin\Models\Izin_Verifikasiusulankegiatans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ReviewUsulanKegiatansController extends Controller
{
    public function pendingList(Request $request)
    {
        $usulankegiatans = Izin_Usulankegiatans::with([
            //'identitassurats:id,nomor_surat,perihal_surat',
            //'laporankegiatans',
            'inputusulankegiatans',
            'verifikasiusulankegiatanterakhir',
            'pelaksanaankegiatans',
            'cetakusulankegiatans',
            'balasanusulankegiatans'
        ]);
            //->select(['id', 'subunitkerja_id', 'tanggalmulai_kegiatan', 'lokasi_kegiatan', 'statususulan_kegiatan', 'created_at']);
        
        /*if ($request->has('statususulan_kegiatan') && $request->statususulan_kegiatan != '') {
            $usulankegiatans->where('statususulan_kegiatan', $request->statususulan_kegiatan);
        } else {
            // Default tetap "pending" biar perilaku lama tidak berubah
            $usulankegiatans->where('statususulan_kegiatan', 'pending');
        }*/

        $usulankegiatans = $usulankegiatans->get();

        if ($request->filled('statususulan_kegiatan')) {

    if (in_array($request->statususulan_kegiatan, ['accepted', 'rejected'])) {
        $usulankegiatans->whereHas('verifikasiusulankegiatanterakhir', function ($q) use ($request) {
            $q->where('status_verifikasiusulankegiatan', $request->statususulan_kegiatan);
        });
    } else {
        $usulankegiatans->where('statususulan_kegiatan', $request->statususulan_kegiatan);
    }
}

        // Jika dropdown status diisi, baru filter
        /*if ($request->filled('statususulan_kegiatan')) {
            $usulankegiatans->where('statususulan_kegiatan', $request->statususulan_kegiatan);
        }

        // Urutkan biar yang terbaru di atas
        $usulankegiatans = $usulankegiatans->orderByDesc('created_at')->get();*/

        return view('pages.usulankegiatan.pending_list_usulan_kegiatan', compact('usulankegiatans'));
    }

    public function reviewForm($id)
    {
        $usulankegiatans = Izin_Usulankegiatans::with([
            //'identitassurats', 
            'detailusulankegiatans',
            'inputusulankegiatans'])
            ->findOrFail($id);

        return view('pages.usulankegiatan.review_usulan_kegiatan', compact('usulankegiatans'));
    }

    public function reviewUpload(Request $request, $id)
    {   
        // Validasi input
        $request->validate([
            'actionusulan_kegiatan' => 'required|in:accepted,rejected',
            'catatan_verifikasiusulankegiatan' => 'nullable|string|max:2000',
        ]);

        // Ambil ID admin yang mengajukan usulan
        //$admin_Id = $usulankegiatans->dibuat_oleh;

        DB::transaction(function () use ($request, $id) {

        // Ambil data usulan
        $usulankegiatans = Izin_Usulankegiatans::findOrFail($id);

        // Simpan hanya status ke database
        /*$usulankegiatans->update([
            'statususulan_kegiatan' => $request->actionusulan_kegiatan,
        ]);*/

        // 🔥 PENTING: JANGAN UPDATE STATUS KECUALI REJECTED
        if ($request->actionusulan_kegiatan === 'rejected') {
            $usulankegiatans->update([
                'statususulan_kegiatan' => 'revisi',
            ]);
        }

        // Simpan histori verifikasi
        Izin_Verifikasiusulankegiatans::create([
            'usulankegiatan_id' => $usulankegiatans->id,
            'tanggalverifikasi_inputusulankegiatan' => now(),
            'nipadmin_verifikasiusulankegiatan' => Auth::user()->nip,
            'status_verifikasiusulankegiatan' => $request->actionusulan_kegiatan,
            'catatan_verifikasiusulankegiatan' => $request->catatan_verifikasiusulankegiatan,
            'is_read' => false,
            ]);
    });

        /* Simpan notes review ke cache untuk admin tersebut
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
