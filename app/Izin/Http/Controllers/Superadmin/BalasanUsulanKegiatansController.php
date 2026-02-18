<?php

namespace App\Izin\Http\Controllers\Superadmin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Inputusulankegiatans;
use App\Izin\Models\Izin_Kirimbalasanusulankegiatans;
use App\Izin\Models\Izin_Stempelunitkerjas;
use App\Izin\Models\Izin_Ttdunitkerjas;
use App\Izin\Models\Izin_Usulankegiatans;
use App\Izin\Services\IdentitasSuratsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Facades\DB;

class BalasanUsulanKegiatansController extends Controller
{
    /**
     * Download Surat Balasan Pengajuan Usulan Kegiatan
     */
    public function downloadBalasan($id)
    {
        // Ambil user yang sedang login saat ini
        $user = Auth::user();

        // Eager load relasi dari model dan temukan usulankegiatan berdasarkan id
        $usulankegiatans = Izin_Usulankegiatans::with([
            'inputusulankegiatans',
            'inputusulankegiatans.kopunitkerjas',
            'inputusulankegiatans.kirimusulankegiatans.identitassurats',
            'balasanusulankegiatans',
            'detailusulankegiatans'
        ])->findOrFail($id);

        // Ambil kop, ttd, dan stempel dari inputusulankegiatan pertama (1 unitkerja dianggap telah mengupload sekali)
        $kop = $usulankegiatans->inputusulankegiatans->first()?->kopunitkerjas ?? null;
        $ttd = Izin_Ttdunitkerjas::where('unitkerja_id', $user->subunitkerjas->unitkerja_id)->first();
        $stempel = Izin_Stempelunitkerjas::where('unitkerja_id', $user->subunitkerjas->unitkerja_id)->first();

        // Ambil gambar logo surakarta sebagai kop surat dari asset
        $kop_path = public_path('build/assets/kop_surat.png');
        if (!file_exists($kop_path)) {
            $kop_path = null;
        }

        // Load view PDF
        $pdf = PDF::loadView('pages.generatepdf.balasan_usulan_kegiatan', [
            'usulankegiatans' => $usulankegiatans,
            'kop_path' => $kop_path,
            'kop' => $kop,
            'ttd' => $ttd,
            'stempel' => $stempel,
            'user'   => $user,
        ])->setPaper('A4', 'portrait');

        // Redirect dan simpan file PDF
        return $pdf->stream('Surat Balasan Pengajuan Usulan Kegiatan ' . $usulankegiatans->inputusulankegiatans->nama_kegiatan . '.pdf');
    }

    /**
     * Tampilkan Form Kirim Balasan Pengajuan Usulan Kegiatan Final
     */
    public function create($id)
    {
        // Temukan usulankegiatan berdasarkan id
        $usulankegiatan = Izin_Usulankegiatans::findOrFail($id);

        // Redirect ke halaman kirim balasan usulan kegiatan
        return view('pages.balasanusulankegiatan.kirim_balasan_usulan_kegiatan', compact('usulankegiatan'));
    }

    /**
     * Simpan File Balasan Usulan Kegiatan Final
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
                'filekirim_balasanusulankegiatan' => 'required|file|mimes:pdf,doc,docx|max:10240',
                'usulankegiatan_id' => 'required',
            ]);

            // Ambil usulankegiatan dari id route
            $usulankegiatan = Izin_Usulankegiatans::with('inputusulankegiatans')->findOrFail($request->route('id'));
            $inputusulankegiatan_id = $usulankegiatan->inputusulankegiatans->id;

            // Upload file kirim balasan usulan kegiatan final
            if ($request->hasFile('filekirim_balasanusulankegiatan')) {
                $kirimbalasanusulankegiatans = $request->file('filekirim_balasanusulankegiatan')
                    ->storeAs(
                        'izin/filekirim_balasanusulankegiatan',
                        time() . '_' . $request->file('filekirim_balasanusulankegiatan')->getClientOriginalName(),
                        'public'
                    );
            }

            // Simpan dan update data kirim balasan usulan kegiatan final
            $kirimbalasanusulan = Izin_Kirimbalasanusulankegiatans::updateOrCreate(
                [
                    'inputusulankegiatan_id' => $inputusulankegiatan_id
                ],
                [
                    'identitassurat_id' => $identitassurats->id,
                    'filekirim_balasanusulankegiatan' => $kirimbalasanusulankegiatans,
                    'tanggalkirim_balasanusulankegiatan' => now(),
                    'nipadmin_kirimbalasanusulankegiatan' => $user->nip,
                ]
            );

            // Update FK pada inputusulankegiatan
            Izin_Inputusulankegiatans::where('id', $inputusulankegiatan_id)
                ->update([
                    'kirimbalasanusulankegiatan_id' => $kirimbalasanusulan->id
                ]);
        });

        // Redirect ke halaman daftar usulan kegiatan superadmin
        return redirect()->route('superadmin.usulankegiatan.pending')->with('success', 'Usulan kegiatan berhasil dikirim!');
    }
}
