<?php

namespace App\Izin\Http\Controllers\Admin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Kirimusulankegiatans;
use App\Izin\Models\Izin_Usulankegiatans;
use App\Izin\Services\IdentitasSuratsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KirimUsulanKegiatansController extends Controller
{
    /**
     * Tampilkan Form Kirim Usulan Kegiatan
     */
    public function create($id)
    {
        $usulankegiatan = Izin_Usulankegiatans::findOrFail($id);

        return view('pages.usulankegiatan.kirim_usulan_kegiatan', compact('usulankegiatan'));
    }

    /**
     * Simpan file usulan kegiatan dari admin
     */
    public function store(Request $request, IdentitasSuratsService $identitassuratservice)
    {
        $user = Auth::user();

        DB::transaction(function () use ($request, $identitassuratservice, $user) {

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
        
        // Validasi input
        $request->validate([
            'filekirim_inputusulankegiatan' => 'required|file|mimes:pdf,doc,docx|max:10240',
            //'identitassurat_id' => 'required|exists:izin_identitassurats,id',
            'usulankegiatan_id' => 'required',
        ]);

        // Ambil Usulan Kegiatan
        //$usulan = Izin_Usulankegiatans::findOrFail($request->usulankegiatan_id);

        // Upload file
        if ($request->hasFile('filekirim_inputusulankegiatan')) {
            $kirimusulankegiatans = $request->file('filekirim_inputusulankegiatan')
                ->storeAs(
                    'izin/filekirim_inputusulankegiatan',
                    time() . '_' . $request->file('filekirim_inputusulankegiatan')->getClientOriginalName(),
                    'public'
                );
        }

        // Simpan ke tabel Kirim Usulan Kegiatan
        Izin_Kirimusulankegiatans::create([
            'inputusulankegiatan_id' => $request->usulankegiatan_id,
            'identitassurat_id' => $identitassurats->id,
            'filekirim_inputusulankegiatan' => $kirimusulankegiatans,
            'tanggalkirim_inputusulankegiatan' => now(),
            'nipadmin_inputusulankegiatan' => $user->nip,
            'statususulan_kegiatan' => 'need_review',
        ]);

        // 🔥 UPDATE STATUS USULAN
        Izin_Usulankegiatans::where('id', $request->usulankegiatan_id)
            ->update([
                'statususulan_kegiatan' => 'need_review'
            ]);
        });

        // Redirect dengan notifikasi sukses
        return redirect()->route('admin.usulankegiatan.index')->with('success', 'Usulan kegiatan berhasil dikirim!');
    }
}
