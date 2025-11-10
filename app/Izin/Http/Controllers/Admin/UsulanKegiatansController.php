<?php

namespace App\Izin\Http\Controllers\Admin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Identitassurats;
use App\Izin\Models\Izin_RefCarapelatihans;
use App\Izin\Models\Izin_RefMetodepelatihans;
use App\Izin\Models\Izin_Usulankegiatans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\PDF;
use PhpOffice\PhpSpreadsheet\IOFactory;

class UsulanKegiatansController extends Controller
{
    /**
     * Tampilkan List Pengajuan Usulan Kegiatan
     */
    public function index()
    {
        $usulankegiatans = Izin_Usulankegiatans::with([
            'identitassurats:id,nomor_surat,perihal_surat',
            //'laporankegiatan:id,usulankegiatan_id,statuslaporan_kegiatan',
            //'laporankegiatan.balasanlaporankegiatan:id,laporan_kegiatan_id,file_surat',
            //'laporankegiatan.balasanlaporankegiatan.sertifikat:id,balasan_laporan_kegiatan_id,file_path'
        ])
            ->select('id', 'nama_kegiatan', 'identitassurat_id', 'tanggalpelaksanaan_kegiatan', 'lokasi_kegiatan', 'statususulan_kegiatan')
            ->get();

        return view('pages.usulankegiatan.list_usulan_kegiatan', compact('usulankegiatans'));
    }

    /**
     * Tampilkan Form Bagian Usulan Kegiatan Pada Form Ajukan Usulan Kegiatan
     */
    public function create()
    {
        $user = Auth::user();
        //$identitas = Identitassurat::findOrFail();

        return view('pages.usulankegiatan.ajukan_usulan_kegiatan', [
            //'identitassurats' => Izin_Identitassurats::select('id', 'nomor_surat', 'tanggal_surat', 'perihal_surat')->get(),
            'subunitkerjas' => $user->subunitkerjas->sub_unitkerja ?? null,
            'dibuat_oleh' => $user->nama,
            'carapelatihans' => Izin_RefCarapelatihans::select('id', 'cara_pelatihan')->get(),
            'metodepelatihans' => Izin_RefMetodepelatihans::select('id', 'metode_pelatihan')->get(),
        ]);
    }

    /**
     * Simpan Data Usulan Kegiatan
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $identitassurats = Izin_Identitassurats::create([
            'nomor_surat' => $request->nomor_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'perihal_surat' => $request->perihal_surat,
            'lampiran_surat' => $request->lampiran_surat,
            'subunitkerja_id' => $user->subunitkerja_id,
            'dibuat_oleh' => $user->id,
        ]);

        // Mapping status untuk memastikan sesuai enum
        $statususulan_kegiatanMapping = [
            'submit' => 'pending', // jika masih ada yang kirim 'submit'
            'draft' => 'draft',
            'pending' => 'pending',
            'accepted' => 'accepted',
            'rejected' => 'rejected',
            'in_progress' => 'in_progress',
            'completed' => 'completed',
            'finish' => 'finish',
        ];

        $statususulan_kegiatan = $statususulan_kegiatanMapping[$request->statususulan_kegiatan ?? 'draft'] ?? 'draft';

        $usulankegiatans = Izin_Usulankegiatans::create([
            'identitassurat_id' => $identitassurats->id,
            'subunitkerja_id' => $user->subunitkerja_id,
            'nama_kegiatan' => $request->nama_kegiatan,
            'lokasi_kegiatan' => $request->lokasi_kegiatan,
            'carapelatihan_id' => $request->carapelatihan_id,
            'tanggalpelaksanaan_kegiatan' => $request->tanggalpelaksanaan_kegiatan,
            'statususulan_kegiatan' => $statususulan_kegiatan,
            'dibuat_oleh' => $user->id,
        ]);

        $request->merge(['usulankegiatan_id' => $usulankegiatans->id]);

        // Lanjut ke controller detail
        return app(DetailUsulanKegiatansController::class)->store($request);
    }

    /**
     * Download Surat dan KAK Pengajuan Usulan Kegiatan
     */
    public function download($id)
    {
        // Ambil data lengkap dengan relasi
        $usulankegiatans = Izin_Usulankegiatans::with([
            'identitassurats',
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

        // --- baca file Excel jadwal kalau ada ---
        $jadwalpelaksanaan_kegiatan = [];
        if ($usulankegiatans->detailusulankegiatans?->jadwalpelaksanaan_kegiatan) {
            $path = storage_path('app/public/' . $usulankegiatans->detailusulankegiatans->jadwalpelaksanaan_kegiatan);
            if (file_exists($path)) {
                try {
                    $spreadsheet = IOFactory::load($path);
                    $sheet = $spreadsheet->getActiveSheet();
                    // Ambil semua baris, termasuk yang kosong
                    $jadwalpelaksanaan_kegiatan = [];
                    foreach ($sheet->toArray(null, true, true, true) as $row) {
                        $values = array_values($row);
                        $jadwalpelaksanaan_kegiatan[] = $values;
                    }
                } catch (\Exception $e) {
                    $jadwalpelaksanaan_kegiatan = [];
                }
            }
        }

        $pdf = PDF::loadView('pages.generatepdf.surat_usulan_kegiatan', [
            'usulankegiatans' => $usulankegiatans,
            'jadwalpelaksanaan_kegiatan' => $jadwalpelaksanaan_kegiatan,
            'kop_path' => $kop_path,
            'ttd_path' => $ttd_path,
        ])->setPaper('A4', 'portrait');

        return $pdf->stream('Surat_Pengajuan_' . $usulankegiatans->nama_kegiatan . '.pdf');
    }

    public function uploadTTD(Request $request)
    {
        $request->validate([
            'tandatangan_pjkegiatan' => 'required|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        // File upload
        if ($request->hasFile('tandatangan_pjkegiatan')) {
            $ttd_path = $request->file('tandatangan_pjkegiatan')
                ->store('izin/tandatangan_pjkegiatan', 'public');
        }

        // Simpan path ke session biar bisa dipakai lagi saat generate PDF
        session(['tandatangan_pjkegiatan' => $ttd_path]);

        return back()->with('success', 'Tanda tangan berhasil diupload!');
    }

    public function createTTD()
    {
        return view('pages.upload_ttd_surat');
    }
}
