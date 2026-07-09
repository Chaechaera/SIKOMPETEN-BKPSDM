<?php

namespace App\Izin\Http\Controllers\User;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Balasanlaporankegiatans;
use App\Izin\Models\Izin_Laporankegiatans;
use App\Izin\Models\Izin_Pesertakegiatans;
use App\Izin\Models\Izin_Sertifikats;
use App\Izin\Models\Izin_Usulankegiatans;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SertifikatsController extends Controller
{
    // New: list all users
    public function index()
    {
        $user   = Auth::user();
        $search = request('search');
        $tahun  = request('tahun');

        $query = Izin_Usulankegiatans::with([
            'inputusulankegiatans',
            'inputusulankegiatans.usulankegiatans',
            'inputusulankegiatans.usulankegiatans.subunitkerjas',
            'inputlaporankegiatans',
            'inputlaporankegiatans.laporankegiatans',
            'inputlaporankegiatans.laporankegiatans.sertifikats',
            'inputlaporankegiatans.laporankegiatans.detaillaporankegiatans',
            'inputlaporankegiatans.laporankegiatans.detaillaporankegiatans.pesertakegiatans',
        ]);

        // =========================
        // 🔍 SEARCH (QUERY LEVEL)
        // =========================
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('inputusulankegiatans', function ($q2) use ($search) {
                    $q2->where('nama_kegiatan', 'like', "%$search%");
                })
                    ->orWhereHas('inputusulankegiatans.usulankegiatans.subunitkerjas', function ($q2) use ($search) {
                        $q2->where('singkatan', 'like', "%$search%");
                    })
                    ->orWhereHas(
                        'inputlaporankegiatans.laporankegiatans.detaillaporankegiatans.pesertakegiatans',
                        function ($q2) use ($search) {
                            $q2->where('nomorsertifikatpeserta_kegiatan', 'like', "%$search%");
                        }
                    );
            });
        }

        // =========================
        // 📅 FILTER TAHUN
        // =========================
        if ($tahun) {
            $query->whereHas(
                'inputlaporankegiatans.laporankegiatans.sertifikats',
                function ($q) use ($tahun) {
                    $q->whereYear('tanggalkeluarsertifikat_kegiatan', $tahun);
                }
            );
        }

        // =========================
        // 🏢 FILTER BERDASARKAN OPD USER
        // =========================
        if ($user && $user->subunitkerja_id) {
            $query->whereHas('inputusulankegiatans.usulankegiatans.subunitkerjas', function ($q) use ($user) {
                $q->where('id', $user->subunitkerja_id);
            });
        }

        // =========================
        // 📄 AMBIL DATA + PAGINATION MANUAL
        // =========================
        $collection = $query->get()->values();

        $page    = request()->get('page', 1);
        $perPage = 10;

        $usulankegiatans = new LengthAwarePaginator(
            $collection->forPage($page, $perPage),
            $collection->count(),
            $perPage,
            $page,
            [
                'path'  => request()->url(),
                'query' => request()->query(),
            ]
        );

        // =========================
        // 📅 DROPDOWN TAHUN
        // =========================
        $tahuns = Izin_Sertifikats::selectRaw('YEAR(tanggalkeluarsertifikat_kegiatan) as tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        return view('pages.sertifikat.admin', compact(
            'usulankegiatans',
            'search',
            'tahuns',
            'tahun'
        ));
    }

    /**
     * Melihat List Sertifikat User
     */
    public function listSertif()
    {
        // Ambil user yang login saat ini
        $user = Auth::user();

        // Inisiasi request 
        $search = request('search');
        $sort = request('sort_tahun'); // asc / desc / null

        // Eager Loading
        $sertifikats = Izin_Sertifikats::with([
            'pesertakegiatans.subunitkerjas',
            'laporankegiatans.inputlaporankegiatans.inputusulankegiatans',
            'laporanpesertakegiatans',
            'pesertakegiatans' => function ($q) use ($user) {
                $q->where('nip_nik_peserta', $user->nip);
            }
        ])
            ->whereHas('pesertakegiatans', function ($q) use ($user) {
                $q->where('nip_nik_peserta', $user->nip);
            })
            ->get();

        // Filter search dengan collection
        if ($search) {
            $search = strtolower($search);

            $sertifikats = $sertifikats->filter(function ($s) use ($search) {

                // Berdasarkan nomor sertifikat peserta, tahun, nama kegiatan, atau OPD
                $p = $s->pesertakegiatans->first();
                $nomor = strtolower($p->nomorsertifikatpeserta_kegiatan ?? '');

                $tahun = \Carbon\Carbon::parse($s->tanggalkeluarsertifikat_kegiatan)->year;

                $namaKegiatan = strtolower(
                    optional($s->laporankegiatans)
                        ?->inputlaporankegiatans
                        ?->inputusulankegiatans
                        ?->nama_kegiatan ?? ''
                );

                $opd = strtolower(
                    optional($p->sertifikats)
                        ?->inputusulankegiatans
                        ?->subunitkerjas
                        ?->singkatan ?? ''
                );

                // Return hasil pencarian
                return
                    str_contains($nomor, $search) ||
                    str_contains((string)$tahun, $search) ||
                    str_contains($namaKegiatan, $search) ||
                    str_contains($opd, $search);
            });
        }

        // Filter Status
        $status = request('statuslaporan_pesertakegiatan');
        if ($status) {
            $sertifikats = $sertifikats->filter(function ($s) use ($status) {

                $laporan = $s->laporanpesertakegiatans->first();

                if ($status === 'belum_upload') {
                    return $laporan === null;
                }

                // Return hasil filtering
                return optional($laporan)->statuslaporan_pesertakegiatan === $status;
            });
        }

        // Sorting tahun
        if ($sort === 'asc') {
            $sertifikats = $sertifikats->sortBy('tanggalkeluarsertifikat_kegiatan');
        } else {
            $sertifikats = $sertifikats->sortByDesc('tanggalkeluarsertifikat_kegiatan');
        }

        // ===============================
        // Pagination Data Sertifikat
        // ===============================
        $sertifikats = $sertifikats->values();
        $page = request()->get('page', 1);
        $perPage = 20;

        $sertifikats = new LengthAwarePaginator(
            $sertifikats->forPage($page, $perPage),
            $sertifikats->count(),
            $perPage,
            $page,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );

        // Return halaman sertifikat user
        return view('pages.sertifikat.user', compact('sertifikats'));
    }

    /**
     * Generate dan Simpan Data Sertifikat Baru
     */
    public function create(Request $request)
    {
        // Eager load relasi dari model dan temukan laporankegiatan berdasarkan request id
        $laporankegiatans = Izin_Laporankegiatans::with([
            'inputlaporankegiatans',
            'inputlaporankegiatans.inputusulankegiatans',
            'inputlaporankegiatans.inputusulankegiatans.usulankegiatans',
            'detaillaporankegiatans.pesertakegiatans',
        ])->findOrFail($request->laporankegiatan_id);

        // Request tanggal sertifikat
        $tanggalsertifikat = $request->tanggalkeluarsertifikat_kegiatan;

        // Memastikan usulankegiatan ada
        $usulan = $laporankegiatans->inputlaporankegiatans->inputusulankegiatans->usulankegiatans;
        if (!$usulan) {
            return response()->json(['error' => 'Usulankegiatan tidak ditemukan'], 400);
        }

        // Generate nomor sertifikat kegiatan
        $carapelatihan_id = str_pad($usulan->carapelatihan_id, 2, '0', STR_PAD_LEFT);
        $count = Izin_Sertifikats::count() + 1;
        $urutan = str_pad($count, 3, '0', STR_PAD_LEFT);
        $bulanRomawi = $this->convertToRomawi(now()->format('n'));
        $tahun = now()->year;

        $nomorsertifikatkegiatans = "{$carapelatihan_id}/BKPSDM/{$urutan}/{$bulanRomawi}/{$tahun}";

        // Normalisasi fields elemen sertifikat dalam json
        $dataFields = $request->fieldstemplatesertifikat_kegiatan;
        if (is_string($dataFields)) {
            $dataFields = $dataFields === "" ? [] : json_decode($dataFields, true);
        }

        // Simpan dan update sertifikat
        $sertifikats = Izin_Sertifikats::updateOrCreate(
            ['laporankegiatan_id' => $request->laporankegiatan_id],
            [
                'inputusulankegiatan_id' => $laporankegiatans->inputlaporankegiatans->inputusulankegiatans->id,
                'nomorsertifikat_kegiatan' => $nomorsertifikatkegiatans,
                'tanggalkeluarsertifikat_kegiatan' => $tanggalsertifikat,
                'fieldstemplatesertifikat_kegiatan' => $dataFields,
            ]
        );

        // Hubungkan sertifikat_id yg telah dibuat ke balasan laporan kegiatan
        $balasan = Izin_Balasanlaporankegiatans::where('inputlaporankegiatan_id', $laporankegiatans->inputlaporankegiatans->id)->first();
        if ($balasan) {
            $balasan->update(['sertifikat_id' => $sertifikats->id]);
        }

        // Generate nomor sertifikat peserta dan update ke peserta kegiatan
        $detail = $laporankegiatans->detaillaporankegiatans;
        if ($detail && $detail->pesertakegiatans) {
            foreach ($detail->pesertakegiatans as $index => $peserta) {
                $nomorPeserta = $nomorsertifikatkegiatans . '/' . str_pad($index + 1, 3, '0', STR_PAD_LEFT);
                $peserta->update([
                    'nomorsertifikatpeserta_kegiatan' => $nomorPeserta,
                    'sertifikat_id' => $sertifikats->id,
                ]);
            }
        }

        return $sertifikats;
    }

    /**
     * Download Satu Sertifikat Peserta Kegiatan (PDF tunggal)
     */
    public function download($sertifikat_id, $peserta_id)
    {
        // Eager load and find sertifikat berdasarkan peserta id
        $peserta = Izin_Pesertakegiatans::where('sertifikat_id', $sertifikat_id)
            ->findOrFail($peserta_id);

        // Jika file generate sudah ada
        if (
            !$peserta->filesertifikatgenerate_path ||
            !Storage::disk('public')->exists($peserta->filesertifikatgenerate_path)
        ) {
            return back()->withErrors('PDF sertifikat belum difinalisasi.');
        }

        // Penamaan file sertifikat
        $filename = 'Sertifikat_' .
            preg_replace('/[^A-Za-z0-9 _-]/', '', $peserta->nama_peserta) .
            '.pdf';

        // Download file sertifikat hasil generate langsung
        return Storage::disk('public')->download(
            $peserta->filesertifikatgenerate_path,
            $filename
        );
    }

    /**
     * Download Semua Sertifikat Peserta Kegiatan (ZIP)
     */
    public function downloadZIP($laporankegiatan_id)
    {
        // Eager loading sertifikat
        $sertifikat = Izin_Sertifikats::with('pesertakegiatans')
            ->where('laporankegiatan_id', $laporankegiatan_id)
            ->first();

        // Jika tidak ada sertifikat maka return error
        if (!$sertifikat) {
            return back()->withErrors('Tidak ada sertifikat untuk kegiatan ini.');
        }

        // Jika tidak ada peserta kegiatan return error
        if ($sertifikat->pesertakegiatans->isEmpty()) {
            return back()->withErrors('Tidak ada peserta.');
        }

        // Folder sementara untuk ZIP
        $tempFolder = storage_path('app/public/izin/temp/');
        if (!file_exists($tempFolder)) {
            mkdir($tempFolder, 0777, true);
        }
        $zipFileName = "Sertifikat_Kegiatan_{$sertifikat->laporankegiatans->inputlaporankegiatans->inputusulankegiatans->nama_kegiatan}.zip";
        $zipPath = $tempFolder . $zipFileName;
        $zip = new \ZipArchive();
        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            return back()->withErrors('Gagal membuat ZIP.');
        }

        // Proses ZIP berlangsung
        foreach ($sertifikat->pesertakegiatans as $peserta) {

            // Pastikan PDF hasil finalisasi ada
            if (
                empty($peserta->filesertifikatgenerate_path) ||
                !Storage::disk('public')->exists($peserta->filesertifikatgenerate_path)
            ) {
                $zip->close();
                if (file_exists($zipPath)) {
                    unlink($zipPath);
                }
                return back()->withErrors(
                    "Sertifikat {$peserta->nama_peserta} belum difinalisasi."
                );
            }
            $cleanName = preg_replace(
                '/[^A-Za-z0-9 _-]/',
                '',
                $peserta->nama_peserta
            );

            $zip->addFile(
                storage_path('app/public/' . $peserta->filesertifikatgenerate_path),
                $cleanName . '.pdf'
            );
        }
        $zip->close();

        // Download file ZIP hasil generate langsung
        return response()
            ->download(
                $zipPath,
                $zipFileName,
                ['Content-Type' => 'application/zip']
            )
            ->deleteFileAfterSend(true);
    }

    /**
     * Finalisasi File Sertifikat Kegiatan Milik Peserta Kegiatan Sekaligus
     */
    public function finalisasi($sertifikat_id)
    {
        // Eager load and find by sertifikat id
        $sertifikat = Izin_Sertifikats::with([
            'pesertakegiatans'
        ])->findOrFail($sertifikat_id);

        // pilih view sertifikat yang digunakan
        $view = $sertifikat->jenissertifikat_kegiatan === 'template_opd'
            ? 'pages.generatepdf.sertifikat_kegiatan'
            : 'pages.generatepdf.sertifikat_kegiatan_general';

        // decode field template
        $rawFields = $sertifikat->fieldstemplatesertifikat_kegiatan;
        $fieldstemplates = is_string($rawFields)
            ? json_decode($rawFields, true)
            : (is_array($rawFields) ? $rawFields : []);

        // Ambil data total JP kegiatan
        $totaljp = optional($sertifikat->balasanlaporankegiatans)
            ->totalcapaianjp_kegiatan ?? 0;

        // Rubah menjadi terbilang angka JP kegiatan
        $totaljp_text = $totaljp > 0
            ? $totaljp . ' (' . $this->terbilangJP($totaljp) . ')'
            : '';

        // folder penyimpanan
        $folder = 'generated/sertifikat/kegiatan_' . $sertifikat->laporankegiatan_id;
        Storage::disk('public')->makeDirectory($folder);

        // Generate Sertifikat Kegiatan
        foreach ($sertifikat->pesertakegiatans as $peserta) {

            // ===========================
            //  JIKA TEMPLATE OPD
            // ===========================

            if ($sertifikat->jenissertifikat_kegiatan === 'template_opd') {

                // Ambil gambar sertifikat
                $backgroundPath = public_path(
                    'storage/' . ltrim($sertifikat->templatesertifikat_kegiatan, '/')
                );

                if (!file_exists($backgroundPath)) {
                    continue;
                }

                $backgroundBase64 = base64_encode(
                    file_get_contents($backgroundPath)
                );

                $backgroundMime = mime_content_type($backgroundPath);

                // Loadview sertifikat kegiatan milik peserta
                $pdf = PDF::loadView($view, [
                    'sertifikat' => $sertifikat,
                    'peserta' => $peserta,
                    'fieldstemplatesertifikat_kegiatan' => $fieldstemplates,
                    'backgroundPath' => $backgroundPath,
                    'backgroundBase64' => $backgroundBase64,
                    'backgroundMime' => $backgroundMime,
                    'totalcapaianjp_text' => $totaljp_text,
                ]);
            }

            // ===========================
            // JIKA TEMPLATE BKPSDM
            // ===========================

            else {

                // Ambil data ttd subunitkerja penyelenggara
                $ttd = $peserta->detaillaporankegiatans
                    ->laporankegiatans
                    ->inputlaporankegiatans
                    ->inputusulankegiatans
                    ->usulankegiatans
                    ->subunitkerjas
                    ->ttdunitkerjas
                    ->first();

                // Ambil data stempel subunitkerja penyelenggara
                $stempel = $peserta->detaillaporankegiatans
                    ->laporankegiatans
                    ->inputlaporankegiatans
                    ->inputusulankegiatans
                    ->usulankegiatans
                    ->subunitkerjas
                    ->stempelunitkerjas
                    ->first();

                $ttdBase64 = base64_encode(
                    file_get_contents(public_path('storage/' . $ttd->gambarttd_opd))
                );

                $stempelBase64 = base64_encode(
                    file_get_contents(public_path('storage/' . $stempel->gambarstempel_opd))
                );

                // Ambil gambar logo surakarta sebagai kop surat dari asset
                $kop_path = public_path('build/assets/kop_surat.png');
                if (!file_exists($kop_path)) {
                    $kop_path = null;
                }

                // Loadview sertifikat kegiatan milik peserta
                $pdf = PDF::loadView($view, [
                    'sertifikat' => $sertifikat,
                    'peserta' => $peserta,
                    'kop_path' => $kop_path,
                    'ttd' => $ttd,
                    'stempel' => $stempel,
                    'ttdBase64' => $ttdBase64,
                    'stempelBase64' => $stempelBase64,
                    'totalcapaianjp_text' => $totaljp_text,
                ]);
            }

            // Atur opsi PDF ditampilkan
            $pdf->setOptions([
                'dpi' => 96,
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
                'fontHeightRatio' => 1.0,
                'chroot' => public_path(),
            ])->setPaper('A4', 'landscape');

            // Simpan file sertifikat peserta kegiatan
            $path = $folder . '/peserta_' . $peserta->id . '.pdf';
            Storage::disk('public')->put(
                $path,
                $pdf->output()
            );

            // Update data pada database
            $peserta->update([
                'filesertifikatgenerate_path' => $path,
            ]);
        }

        return back()->with('success', 'Semua sertifikat berhasil difinalisasi.');
    }

    /**
     * Konversi angka bulan menjadi format Romawi
     */
    private function convertToRomawi($month)
    {
        $romawi = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII'
        ];
        return $romawi[$month] ?? '';
    }

    /**
     * Konversi angka JP menjadi format Huruf
     */
    private function terbilangJP($angka)
    {
        $angka = abs((int)$angka);

        $huruf = [
            "",
            "Satu",
            "Dua",
            "Tiga",
            "Empat",
            "Lima",
            "Enam",
            "Tujuh",
            "Delapan",
            "Sembilan",
            "Sepuluh",
            "Sebelas"
        ];

        // Konversikan terbilang huruf berdasarkan tingkatan
        if ($angka < 12) {
            return $huruf[$angka];
        } elseif ($angka < 20) {
            return $this->terbilangJP($angka - 10) . " Belas";
        } elseif ($angka < 100) {
            return $this->terbilangJP(intval($angka / 10)) . " Puluh " . $this->terbilangJP($angka % 10);
        } elseif ($angka < 200) {
            return "Seratus " . $this->terbilangJP($angka - 100);
        } elseif ($angka < 1000) {
            return $this->terbilangJP(intval($angka / 100)) . " Ratus " . $this->terbilangJP($angka % 100);
        } else {
            return (string)$angka;
        }
    }
}
