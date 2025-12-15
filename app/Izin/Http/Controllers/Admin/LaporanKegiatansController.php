<?php

namespace App\Izin\Http\Controllers\Admin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Identitassurats;
use App\Izin\Models\Izin_Laporankegiatans;
use App\Izin\Models\Izin_RefCarapelatihans;
use App\Izin\Models\Izin_RefMetodepelatihans;
use App\Izin\Models\Izin_Sertifikats;
use App\Izin\Models\Izin_Usulankegiatans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\PDF;

class LaporanKegiatansController extends Controller
{
    /**
     * Tampilkan Form Bagian Usulan Kegiatan Pada Form Ajukan Usulan Kegiatan
     */
    public function create($id)
    {
        $user = Auth::user();
        $usulankegiatans = Izin_Usulankegiatans::with('carapelatihans')->findOrFail($id);

        return view('pages.laporankegiatan.ajukan_laporan_kegiatan', [
            //'identitassurats' => Izin_Identitassurats::select('id', 'nomor_surat', 'tanggal_surat', 'perihal_surat')->get(),
            'subunitkerjas' => $user->subunitkerjas->sub_unitkerja ?? null,
            'dibuat_oleh' => $user->nama,
            'usulankegiatans' => $usulankegiatans,
            'carapelatihans' => Izin_RefCarapelatihans::select('id', 'cara_pelatihan')->get(),
            'metodepelatihans' => Izin_RefMetodepelatihans::select('id', 'metode_pelatihan')->get(),
        ]);
    }

    /**
     * Simpan Data Usulan Kegiatan
     */
    public function store(Request $request, $id)
    {
        $user = Auth::user();

        $usulankegiatans = Izin_Usulankegiatans::findOrFail($id);

        $identitassurats = Izin_Identitassurats::create([
            'nomor_surat' => $request->nomor_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'perihal_surat' => $request->perihal_surat,
            'lampiran_surat' => $request->lampiran_surat,
            'subunitkerja_id' => $user->subunitkerja_id,
            'dibuat_oleh' => $user->id,
        ]);

        $config = config('atribut_khusus');
        $carapelatihans = Izin_RefCarapelatihans::find($request->carapelatihan_id);
        $atributInput = [];

        /*if ($carapelatihans && isset($config[$carapelatihans->cara_pelatihan])) {
            foreach ($config[$carapelatihans->cara_pelatihan] as $key => $label) {
                $atributInput[$key] = $request->input($key);
            }
        }*/

        if ($carapelatihans && isset($config[$carapelatihans->id]['fields'])) {
            foreach ($config[$carapelatihans->id]['fields'] as $key => $field) {
                $atributInput[$key] = $request->input($key);
            }
        }

        $laporankegiatans = Izin_Laporankegiatans::create([
            'usulankegiatan_id' => $usulankegiatans->id,
            'identitassurat_id' => $identitassurats->id,
            'carapelatihan_id' => $request->carapelatihan_id,
            'atribut_khusus' => json_encode($atributInput),
            'waktupelaksanaan_laporan' => $request->waktupelaksanaan_laporan,
            'latarbelakang_laporan' => $request->latarbelakang_laporan,
            'dasarhukum_laporan' => $request->dasarhukum_laporan,
            'maksud_laporan' => $request->maksud_laporan,
            'tujuan_laporan' => $request->tujuan_laporan,
            'ruanglingkup_laporan' => $request->ruanglingkup_laporan,
            'metodepelatihan_id' => $request->metodepelatihan_id,
            'narasumber_laporan' => $request->narasumber_laporan,
        ]);

        $request->merge(['laporankegiatan_id' => $laporankegiatans->id]);

        // Update Status Usulan Kegiatan ke Database
        $usulankegiatans->update([
            'statususulan_kegiatan' => 'completed',
        ]);

        // Lanjut ke controller detail
        return app(DetailLaporanKegiatansController::class)->store($request);
    }

    public function download($id)
    {
        // Ambil data lengkap dengan relasi
        $laporankegiatans = Izin_Laporankegiatans::with([
            'identitassurats',
            'detaillaporankegiatans',
            'usulankegiatans',
        ])->findOrFail($id);

        // Ambil gambar logo surakarta sebagai kop surat dari asset
        $kop_path = public_path('build/assets/kop_surat.png'); // contoh nama file
        if (!file_exists($kop_path)) {
            $kop_path = null; // fallback kalau tidak ada file kop
        }

        $ttd_path = null;
        if (!empty($laporankegiatans->tandatangan_pjkegiatan)) {
            $tandatangan_path = storage_path('app/public/' . $laporankegiatans->tandatangan_pjkegiatan);
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

        // RUNDOWN KEGIATAN (Excel)
        $rundown_laporan = [];
        if ($laporankegiatans->detaillaporankegiatans?->rundown_laporan) {
            $path = storage_path('app/public/' . $laporankegiatans->detaillaporankegiatans->rundown_laporan);
            if (file_exists($path)) {
                try {
                    $spreadsheet = IOFactory::load($path);
                    $sheet = $spreadsheet->getActiveSheet();
                    // Ambil semua baris, termasuk yang kosong
                    $rundown_laporan = [];
                    foreach ($sheet->toArray(null, true, true, true) as $row) {
                        $values = array_values($row);
                        $rundown_laporan[] = $values;
                    }
                } catch (\Exception $e) {
                    $rundown_laporan = [];
                }
            }
        }

        // PESERTA KEGIATAN (Excel)
        $peserta_laporan = [];
        if ($laporankegiatans->detaillaporankegiatans?->peserta_laporan) {
            $path = storage_path('app/public/' . $laporankegiatans->detaillaporankegiatans->peserta_laporan);
            if (file_exists($path)) {
                try {
                    $spreadsheet = IOFactory::load($path);
                    $sheet = $spreadsheet->getActiveSheet();
                    // Ambil semua baris, termasuk yang kosong
                    $peserta_laporan = [];
                    foreach ($sheet->toArray(null, true, true, true) as $row) {
                        $values = array_values($row);
                        $peserta_laporan[] = $values;
                    }
                } catch (\Exception $e) {
                    $peserta_laporan = [];
                }
            }
        }

        // DOKUMENTASI GAMBAR (multiple)
        $gambardokumentasi_laporan = [];
        if ($laporankegiatans->detaillaporankegiatans?->gambardokumentasi_laporan) {
            $files_gambardokumentasi = json_decode($laporankegiatans->detaillaporankegiatans->gambardokumentasi_laporan, true) ?? [];

            foreach ($files_gambardokumentasi as $file) {
                $path = storage_path("app/public/" . $file);
                if (file_exists($path)) {
                    $gambardokumentasi_laporan[] = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($path));
                } else {
                    $gambardokumentasi_laporan[] = null;
                }
            }
        }

        // ATRIBUT KHUSUS
        $atribut_khusus = json_decode($laporankegiatans->atribut_khusus, true) ?? [];

        $pdf = PDF::loadView('pages.generatepdf.laporan_hasil_kegiatan', [
            'laporankegiatans' => $laporankegiatans,
            'rundown_laporan' => $rundown_laporan,
            'peserta_laporan' => $peserta_laporan,
            'gambardokumentasi_laporan' => $gambardokumentasi_laporan,
            'atribut_khusus' => $atribut_khusus,
            'kop_path' => $kop_path,
            'ttd_path' => $ttd_path,
        ])->setPaper('A4', 'portrait');

        return $pdf->stream('Laporan_Hasil_' . $laporankegiatans->usulankegiatans->nama_kegiatan . '.pdf');
    }
}
