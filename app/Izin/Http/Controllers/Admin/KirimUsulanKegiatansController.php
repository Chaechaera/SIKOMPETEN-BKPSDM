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
     * Tampilkan Form Kirim Pengajuan Usulan Kegiatan Final
     */
    public function create($id)
    {
        // Temukan usulankegiatan berdasarkan id
        $usulankegiatan = Izin_Usulankegiatans::findOrFail($id);

        // Redirect ke halaman kirim pengajuan usulan kegiatan
        return view('pages.usulankegiatan.kirim_usulan_kegiatan', compact('usulankegiatan'));
    }

    /**
     * Simpan File Kirim Pengajuan Usulan Kegiatan Final
     */
    public function store(Request $request, IdentitasSuratsService $identitassuratservice)
    {
        // Ambil user yang sedang login saat ini
        $user = Auth::user();

        // Transaksi DB berlangsung
        DB::transaction(function () use ($request, $identitassuratservice, $user) {

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

            // Validasi request
            $request->validate([
                'filekirim_inputusulankegiatan' => 'required|file|mimes:pdf,doc,docx|max:10240',
                'usulankegiatan_id' => 'required',
            ]);

            // Upload file kirim pengajuan usulan kegiatan final
            if ($request->hasFile('filekirim_inputusulankegiatan')) {
                $kirimusulankegiatans = $request->file('filekirim_inputusulankegiatan')
                    ->storeAs(
                        'izin/filekirim_inputusulankegiatan',
                        time() . '_' . $request->file('filekirim_inputusulankegiatan')->getClientOriginalName(),
                        'public'
                    );
            }

            // Simpan data kirim pengajuan usulan kegiatan final
            Izin_Kirimusulankegiatans::create([
                'inputusulankegiatan_id' => $request->usulankegiatan_id,
                'identitassurat_id' => $identitassurats->id,
                'filekirim_inputusulankegiatan' => $kirimusulankegiatans,
                'tanggalkirim_inputusulankegiatan' => now(),
                'nipadmin_inputusulankegiatan' => $user->nip,
                'statususulan_kegiatan' => 'need_review',
            ]);

            // Update status usulan kegiatan menjadi "need review"
            Izin_Usulankegiatans::where('id', $request->usulankegiatan_id)
                ->update([
                    'statususulan_kegiatan' => 'need_review'
                ]);
        });

        // Redirect ke halaman daftar pengajuan usulan kegiatan
        return redirect()->route('admin.usulankegiatan.index')->with('success', 'Usulan kegiatan berhasil dikirim!');
    }
}
