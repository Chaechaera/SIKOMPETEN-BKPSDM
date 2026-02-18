<?php

namespace App\Izin\Http\Controllers\Superadmin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Balasanlaporankegiatans;
use App\Izin\Models\Izin_Inputlaporankegiatans;
use App\Izin\Models\Izin_Kirimbalasanlaporankegiatans;
use App\Izin\Models\Izin_Laporankegiatans;
use App\Izin\Models\Izin_Sertifikats;
use App\Izin\Models\Izin_Stempelunitkerjas;
use App\Izin\Models\Izin_Ttdunitkerjas;
use App\Izin\Services\IdentitasSuratsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Facades\DB;

class BalasanLaporanKegiatansController extends Controller
{
    /**
     * Tampilkan Form Balasan Laporan Hasil Kegiatan Final
     */
    public function create($id)
    {
        // Eager load relasi dari model dan temukan laporankegiatan berdasarkan id
        $laporankegiatans = Izin_Laporankegiatans::with([
            'sertifikats',
            'inputlaporankegiatans',
            'inputlaporankegiatans.inputusulankegiatans',
            'inputlaporankegiatans.inputusulankegiatans.usulankegiatans',
            'inputlaporankegiatans.inputusulankegiatans.usulankegiatans.carapelatihans',
            'inputlaporankegiatans.inputusulankegiatans.usulankegiatans.subunitkerjas',
        ])->findOrFail($id);

        // Ambil data subunitkerja
        $subunitkerjas = $laporankegiatans->inputlaporankegiatans->inputusulankegiatans->usulankegiatans->subunitkerjas->sub_unitkerja ?? '-';
        $subunitkerja_id = $laporankegiatans->inputlaporankegiatans->inputusulankegiatans->usulankegiatans->subunitkerja_id ?? null;

        // Ambil data sertifikat
        $sertifikats = $laporankegiatans->sertifikats;

        // Redirect ke halaman ajukan balasan laporan kegiatan
        return view('pages.balasanlaporankegiatan.ajukan_balasan_laporan_kegiatan', compact('laporankegiatans', 'subunitkerjas', 'subunitkerja_id', 'sertifikats'));
    }

    /**
     * Simpan Data Balasan Laporan Hasil Kegiatan Final
     */
    public function store(Request $request, $id)
    {
        // Eager load relasi dari model dan temukan laporankegiatan berdasarkan id
        $laporankegiatans = Izin_Laporankegiatans::with([
            'inputlaporankegiatans',
            'inputlaporankegiatans.inputusulankegiatans',
            'inputlaporankegiatans.inputusulankegiatans.usulankegiatans',
            'inputlaporankegiatans.inputusulankegiatans.usulankegiatans.carapelatihans',
            'detaillaporankegiatans',
            'sertifikats',
        ])->findOrFail($id);

        // Ambil request data fields elemen sertifikat
        $dataFields = $request->fieldstemplatesertifikat_kegiatan;

        // Simpan dalam JSON
        if (is_string($dataFields)) {
            $dataFields = $dataFields === "" ? [] : json_decode($dataFields, true);
        }

        // Update sertifikat
        $sertifikats = Izin_Sertifikats::findOrFail($request->sertifikat_id);
        $sertifikats->update([
            'tanggalkeluarsertifikat_kegiatan' => $request->tanggalkeluarsertifikat_kegiatan,
            'fieldstemplatesertifikat_kegiatan' => $dataFields,
        ]);

        // Simpan balasan laporan kegiatan
        Izin_Balasanlaporankegiatans::create([
            'inputlaporankegiatan_id' => $laporankegiatans->inputlaporankegiatans->id,
            'inputusulankegiatan_id' => $laporankegiatans->inputlaporankegiatans->inputusulankegiatans->id,
            'sertifikat_id' => $request->sertifikat_id,
            'totalcapaianjp_kegiatan' => $request->totalcapaianjp_kegiatan,
        ]);

        // Redirect ke halaman list usulan kegiatan yang perlu direview
        return redirect()->route('superadmin.usulankegiatan.pending')->with('success', 'Usulan Kegiatan Berhasil Disimpan Secara Lengkap!');
    }

    /**
     * Download Surat Balasan Laporan Hasil Kegiatan Final
     */
    public function download($id)
    {
        // Ambil user yang sedang login saat ini
        $user = Auth::user();

        // Eager load relasi dari model dan temukan balasanlaporankegiatan berdasarkan id
        $balasanlaporankegiatans = Izin_Balasanlaporankegiatans::with([
            'laporankegiatans',
            'laporankegiatans.inputlaporankegiatans',
            'laporankegiatans.inputlaporankegiatans.kirimlaporankegiatans.identitassurats',
            'sertifikats',
        ])->findOrFail($id);

        // Ambil kop, ttd, dan stempel dari inputusulankegiatan pertama (1 unitkerja dianggap telah mengupload sekali)
        $kop = $balasanlaporankegiatans->laporankegiatans->inputlaporankegiatans->inputusulankegiatans->first()?->kopunitkerjas ?? null;
        $ttd = Izin_Ttdunitkerjas::where('unitkerja_id', $user->subunitkerjas->unitkerja_id)->first();
        $stempel = Izin_Stempelunitkerjas::where('unitkerja_id', $user->subunitkerjas->unitkerja_id)->first();

        // Ambil gambar logo surakarta sebagai kop surat dari asset
        $kop_path = public_path('build/assets/kop_surat.png'); // contoh nama file
        if (!file_exists($kop_path)) {
            $kop_path = null; // fallback kalau tidak ada file kop
        }

        // Load view PDF
        $pdf = PDF::loadView('pages.generatepdf.balasan_laporan_kegiatan', [
            'balasanlaporankegiatans' => $balasanlaporankegiatans,
            'kop_path' => $kop_path,
            'kop' => $kop,
            'ttd' => $ttd,
            'stempel' => $stempel,
            'user'   => $user,
        ])->setPaper('A4', 'portrait');

        // Redirect dan simpan file PDF
        return $pdf->stream('Balasan_Laporan_Kegiatan' . $balasanlaporankegiatans->laporankegiatans->inputlaporankegiatans->inputusulankegiatans->nama_kegiatan . '.pdf');
    }

    /**
     * Tampilkan Form Kirim Balasan Laporan Hasil Kegiatan Final
     */
    public function kirim($id)
    {
        // Eager load relasi dari model dan temukan laporankegiatan berdasarkan id
        $laporankegiatans = Izin_Laporankegiatans::with([
            'sertifikats',
            'inputlaporankegiatans',
            'inputlaporankegiatans.inputusulankegiatans',
        ])->findOrFail($id);

        // Redirect ke halaman kirim balasan laporan kegiatan
        return view('pages.balasanlaporankegiatan.kirim_balasan_laporan_kegiatan', compact('laporankegiatans'));
    }

    /**
     * Simpan File Balasan Laporan Hasil Kegiatan Final
     */
    public function storeFinal(Request $request, IdentitasSuratsService $identitassuratservice)
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
                'filekirim_balasanlaporankegiatan' => 'required|file|mimes:pdf,doc,docx|max:10240',
                'laporankegiatan_id' => 'required',
            ]);

            // Ambil laporankegiatan dari id route
            $laporankegiatan = Izin_Laporankegiatans::with('inputlaporankegiatans')->findOrFail($request->route('id'));
            $inputlaporankegiatan_id = $laporankegiatan->inputlaporankegiatans->id;

            // Upload file kirim balasan laporan kegiatan final
            if ($request->hasFile('filekirim_balasanlaporankegiatan')) {
                $kirimbalasanlaporankegiatans = $request->file('filekirim_balasanlaporankegiatan')
                    ->storeAs(
                        'izin/filekirim_balasanlaporankegiatan',
                        time() . '_' . $request->file('filekirim_balasanlaporankegiatan')->getClientOriginalName(),
                        'public'
                    );
            }

            // Simpan dan update data kirim balasan laporan kegiatan final
            $kirimbalasanlaporan = Izin_Kirimbalasanlaporankegiatans::updateOrCreate(
                [
                    'inputlaporankegiatan_id' => $inputlaporankegiatan_id
                ],
                [
                    'identitassurat_id' => $identitassurats->id,
                    'filekirim_balasanlaporankegiatan' => $kirimbalasanlaporankegiatans,
                    'tanggalkirim_balasanlaporankegiatan' => now(),
                    'nipadmin_kirimbalasanlaporankegiatan' => $user->nip,
                ]
            );

            // Update FK pada inputlaporankegiatan
            Izin_Inputlaporankegiatans::where('id', $inputlaporankegiatan_id)
                ->update([
                    'kirimbalasanlaporankegiatan_id' => $kirimbalasanlaporan->id
                ]);
        });

        // Redirect ke halaman daftar usulan kegiatan superadmin
        return redirect()->route('superadmin.usulankegiatan.pending')->with('success', 'Usulan kegiatan berhasil dikirim!');
    }
}
