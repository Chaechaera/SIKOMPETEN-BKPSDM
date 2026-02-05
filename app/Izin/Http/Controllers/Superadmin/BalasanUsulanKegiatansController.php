<?php

namespace App\Izin\Http\Controllers\Superadmin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Kirimbalasanusulankegiatans;
use App\Izin\Models\Izin_Usulankegiatans;
use App\Izin\Services\IdentitasSuratsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Facades\DB;

class BalasanUsulanKegiatansController extends Controller
{
    /**
     * Download Surat dan KAK Pengajuan Usulan Kegiatan
     */
    public function downloadBalasan($id)
    {
        // Ambil data lengkap dengan relasi
        $usulankegiatans = Izin_Usulankegiatans::with([
            //'identitassurats',
            'inputusulankegiatans',
            'balasanusulankegiatans',
            'detailusulankegiatans'
        ])->findOrFail($id);

        // Ambil gambar logo surakarta sebagai kop surat dari asset
        $kop_path = public_path('build/assets/kop_surat.png'); // contoh nama file
        if (!file_exists($kop_path)) {
            $kop_path = null; // fallback kalau tidak ada file kop
        }

        $ttd_path = null;
        if (!empty($usulankegiatans->tandatangan_pjkegiatan)) {
            $tandatangan_path = storage_path('app/public/' . $usulankegiatans->tandatangan_pjkegiatan);
            if (file_exists($tandatangan_path)) {
                $ttd_path = $tandatangan_path;
            }
        } elseif (session()->has('tandatangan_pjkegiatan')) {
            // fallback kalau diambil dari upload session
            $tandatangan_path = storage_path('app/public/' . session('tandatangan_pjkegiatan'));
            if (file_exists($tandatangan_path)) {
                $ttd_path = $tandatangan_path;
            }
        }

        $user = Auth::user();

        $pdf = PDF::loadView('pages.generatepdf.balasan_usulan_kegiatan', [
            'usulankegiatans' => $usulankegiatans,
            'kop_path' => $kop_path,
            'ttd_path' => $ttd_path,
            'user'   => $user,
        ])->setPaper('A4', 'portrait');

        return $pdf->stream('Surat Balasan Pengajuan Usulan Kegiatan ' . $usulankegiatans->inputusulankegiatans->nama_kegiatan . '.pdf');
    }

    /**
     * Tampilkan Form Kirim Usulan Kegiatan
     */
    public function create($id)
    {
        $usulankegiatan = Izin_Usulankegiatans::findOrFail($id);

        return view('pages.balasanusulankegiatan.kirim_balasan_usulan_kegiatan', compact('usulankegiatan'));
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
            'filekirim_balasanusulankegiatan' => 'required|file|mimes:pdf,doc,docx|max:10240',
            //'identitassurat_id' => 'required|exists:izin_identitassurats,id',
            'usulankegiatan_id' => 'required',
        ]);

        // Ambil Usulan Kegiatan
        //$usulan = Izin_Usulankegiatans::findOrFail($request->usulankegiatan_id);

        // Upload file
        if ($request->hasFile('filekirim_balasanusulankegiatan')) {
            $kirimbalasanusulankegiatans = $request->file('filekirim_balasanusulankegiatan')
                ->storeAs(
                    'izin/filekirim_balasanusulankegiatan',
                    time() . '_' . $request->file('filekirim_balasanusulankegiatan')->getClientOriginalName(),
                    'public'
                );
        }

        // Simpan ke tabel Kirim Usulan Kegiatan
        Izin_Kirimbalasanusulankegiatans::updateOrCreate([
            'inputusulankegiatan_id' => $request->usulankegiatan_id],
            [
            'identitassurat_id' => $identitassurats->id,
            'filekirim_balasanusulankegiatan' => $kirimbalasanusulankegiatans,
            'tanggalkirim_balasanusulankegiatan' => now(),
            'nipadmin_kirimbalasanusulankegiatan' => $user->nip,
        ]);

        // 🔥 UPDATE STATUS USULAN
        /*Izin_Usulankegiatans::where('id', $request->usulankegiatan_id)
            ->update([
                'statususulan_kegiatan' => 'need_review'
            ]);*/
        });

        // Redirect dengan notifikasi sukses
        return redirect()->route('superadmin.usulankegiatan.pending')->with('success', 'Usulan kegiatan berhasil dikirim!');
    }
}
