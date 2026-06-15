<?php

namespace App\Izin\Http\Controllers\User;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Laporanpesertakegiatans;
use App\Izin\Models\Izin_Sertifikats;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\PDF;

class LaporanPesertaKegiatansController extends Controller
{
    /**
     * Laporan Peserta Kegiatan Disetujui
     */
    public function approve($id)
    {
        $laporan = Izin_LaporanPesertakegiatans::findOrFail($id);
        
        $laporan->update([
            'statuslaporan_pesertakegiatan' => 'approved'
        ]);

        return back()->with('success', 'Laporan disetujui');
    }

    /**
     * Tampilkan Form Buat Laporan Peserta Kegiatan
     */
    public function create($sertifikat_id)
    {
        // Ambil user yang sedang login saat ini
        $user = Auth::user();

        // Eager load relasi
        $sertifikat = Izin_Sertifikats::with('pesertakegiatans')->findOrFail($sertifikat_id);
        $peserta = $sertifikat->pesertakegiatans()
            ->where('nip_nik_peserta', $user->nip)
            ->first();

        if (! $peserta) {
            return redirect()->back()->with('error', 'Anda bukan peserta kegiatan ini.');
        }

        $laporanpesertakegiatans = Izin_LaporanPesertakegiatans::where('pesertakegiatan_id', $peserta->id)
            ->where('sertifikat_id', $sertifikat_id)
            ->first();

        return view('pages.upload_laporanpeserta_kegiatan', compact('sertifikat', 'peserta', 'laporanpesertakegiatans'));
    }

    /**
     * Menyimpan Data pada Form Laporan Peserta Kegiatan
     */
    public function store(Request $request, $sertifikat_id)
    {
        // Ambil user yang sedang login saat ini
        $user = Auth::user();

        // Eager load 
        $sertifikat = Izin_Sertifikats::findOrFail($sertifikat_id);
        $peserta = $sertifikat->pesertakegiatans()
            ->where('nip_nik_peserta', $user->nip)
            ->first();

        if (!$peserta) {
            return redirect()->back()->with('error', 'Anda bukan peserta kegiatan ini.');
        }

        $laporanpesertakegiatans = $request->only([
            'uraianpeserta_kegiatan',
            'tujuanpeserta_kegiatan',
            'rangkumanpeserta_kegiatan',
            'kesimpulanpeserta_kegiatan',
        ]);

        // Ambil data lama
        $existing = Izin_LaporanPesertakegiatans::where('pesertakegiatan_id', $peserta->id)
            ->where('sertifikat_id', $sertifikat_id)
            ->first();

        // Ambil gambar lama
        $path_dokumentasipeserta = $existing->dokumentasipeserta_kegiatan ?? [];

        // Hapus gambar yang dicentang
        if ($request->has('hapus_gambar')) {
            foreach ($request->hapus_gambar as $index) {
                unset($path_dokumentasipeserta[$index]);
            }
            $path_dokumentasipeserta = array_values($path_dokumentasipeserta);
        }

        // Tambah gambar baru
        if ($request->hasFile('dokumentasipeserta_kegiatan')) {
            foreach ($request->file('dokumentasipeserta_kegiatan') as $file) {
                $path_dokumentasipeserta[] = $file->store('izin/dokumentasipeserta_kegiatan', 'public');
            }
        }

        // Tentukan status laporan peserta kegiatan
        $status = $existing ? 'revisi' : 'pending';

        // Simpan atau update laporan peserta kegiatan
        Izin_LaporanPesertakegiatans::updateOrCreate(
            [
                'pesertakegiatan_id' => $peserta->id,
                'sertifikat_id'      => $sertifikat_id,
            ],
            [
                'uraianpeserta_kegiatan' => $request->uraianpeserta_kegiatan,
                'tujuanpeserta_kegiatan' => $request->tujuanpeserta_kegiatan,
                'rangkumanpeserta_kegiatan' => $request->rangkumanpeserta_kegiatan,
                'kesimpulanpeserta_kegiatan' => $request->kesimpulanpeserta_kegiatan,
                'laporanpesertakegiatans' => $laporanpesertakegiatans,
                'dokumentasipeserta_kegiatan' => $path_dokumentasipeserta,
                'statuslaporan_pesertakegiatan' => $status,
                'uploaded_at' => now(),
            ]
        );

        return redirect()->route('user.sertifikat')
            ->with('success', 'Laporan peserta berhasil diunggah!');
    }

    /**
     * Download Laporan Hasil Kegiatan Pengembangan Kompetensi ASN
     */
    public function download($id)
    {
        // Eager load relasi dari model dan temukan laporankegiatan berdasarkan id
        $laporanpesertakegiatans = Izin_Laporanpesertakegiatans::with([
            'pesertakegiatans',
            'sertifikats.laporankegiatans.inputlaporankegiatans.inputusulankegiatans'
        ])->findOrFail($id);

        // Ambil gambar logo surakarta sebagai kop surat dari asset
        $kop_path = public_path('build/assets/kop_surat.png'); // contoh nama file
        if (!file_exists($kop_path)) {
            $kop_path = null; // fallback kalau tidak ada file kop
        }

        // Baca file gambar dokumentasi laporan kegiatan kalau ada
        $dokumentasipeserta_kegiatan = [];
        if ($laporanpesertakegiatans->dokumentasipeserta_kegiatan) {
            $files_gambardokumentasi = $laporanpesertakegiatans->dokumentasipeserta_kegiatan ?? [];
            foreach ($files_gambardokumentasi as $file) {
                $path = storage_path("app/public/" . $file);
                if (file_exists($path)) {
                    $dokumentasipeserta_kegiatan[] = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($path));
                } else {
                    $dokumentasipeserta_kegiatan[] = null;
                }
            }
        }

        // Load view PDF
        $pdf = PDF::loadView('pages.generatepdf.laporan_peserta_kegiatan', [
            'laporanpesertakegiatans' => $laporanpesertakegiatans,
            'dokumentasipeserta_kegiatan' => $dokumentasipeserta_kegiatan,
            'kop_path' => $kop_path,
        ])->setPaper('A4', 'portrait');

        // Redirect dan simpan file PDF
        return $pdf->stream('Laporan Hasil Kegiatan ' . $laporanpesertakegiatans->pesertakegiatans->nama_peserta . '.pdf');
    }
}
