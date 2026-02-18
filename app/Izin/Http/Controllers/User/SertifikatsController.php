<?php

namespace App\Izin\Http\Controllers\User;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Balasanlaporankegiatans;
use App\Izin\Models\Izin_Laporankegiatans;
use App\Izin\Models\Izin_Pesertakegiatans;
use App\Izin\Models\Izin_Sertifikats;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\PDF;

class SertifikatsController extends Controller
{
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
        // Eager load relasi dari model dan temukan sertifikat berdasarkan id
        $sertifikat = Izin_Sertifikats::with([
            'pesertakegiatans'
        ])->findOrFail($sertifikat_id);

        // Ambil template sertifikat kegiatan
        $templateSertifikat = $sertifikat->templatesertifikat_kegiatan;
        if (!$templateSertifikat) {
            return back()->withErrors('Template sertifikat belum diupload.');
        }

        // Ambil path file sertifikat asli
        $backgroundPath = str_replace('\\', '/', public_path('storage/' . ltrim($templateSertifikat, '/')));
        if (!file_exists($backgroundPath)) {
            return back()->withErrors('File template tidak ditemukan: ' . $backgroundPath);
        }

        // Encode dan Mime file sertifikat asli
        $backgroundBase64 = base64_encode(file_get_contents($backgroundPath));
        $backgroundMime = mime_content_type($backgroundPath);

        // Decode posisi fields sertifikat
        $rawFields = $sertifikat->fieldstemplatesertifikat_kegiatan;
        $fieldstemplates = is_string($rawFields) ? json_decode($rawFields, true) : (is_array($rawFields) ? $rawFields : []);

        // Eager load relasi dari model dan temukan pesertakegiatan berdasarkan id
        $peserta = Izin_Pesertakegiatans::where('sertifikat_id', $sertifikat_id)->findOrFail($peserta_id);

        // Formating capaian JP ke text
        $totaljp = optional($sertifikat->balasanlaporankegiatans)->totalcapaianjp_kegiatan ?? 0;
        $totaljp_text = $totaljp > 0
            ? $totaljp . ' (' . $this->terbilangJP($totaljp) . ')'
            : '';

        // Load view PDF
        $pdf = PDF::loadView('pages.generatepdf.sertifikat_kegiatan', [
            'sertifikat' => $sertifikat,
            'peserta' => $peserta,
            'fieldstemplatesertifikat_kegiatan' => $fieldstemplates,
            'backgroundPath' => $backgroundPath, // <-- penting!
            'backgroundBase64' => $backgroundBase64,
            'backgroundMime' => $backgroundMime,
            'totalcapaianjp_text' => $totaljp_text,
        ])->setOptions([
            'dpi' => 96,
            'defaultFont' => 'Times New Roman',
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true,
            'fontHeightRatio' => 1.3,
            'chroot' => public_path(),
        ])
            ->setPaper('a4', 'landscape');

        // Penamaan file sertifikat
        $filename = 'Sertifikat_' . preg_replace('/[^A-Za-z0-9 _-]/', '', $peserta->nama_peserta) . '.pdf';

        // Redirect dan simpan file PDF
        return $pdf->stream($filename);
    }

    /**
     * Download Semua Sertifikat Peserta Kegiatan (ZIP)
     */
    public function downloadZIP($laporankegiatan_id)
    {
        // Eager load relasi dari model dan temukan sertifikat berdasarkan id laporankegiatan
        $sertifikat = Izin_Sertifikats::with([
            'pesertakegiatans'
        ])->where('laporankegiatan_id', $laporankegiatan_id)->first();

        // Jika sertifikat tidak ada munculkan peringatan
        if (!$sertifikat) {
            return back()->withErrors('Tidak ada sertifikat untuk kegiatan ini.');
        }

        // Ambil template sertifikat kegiatan
        $templateSertifikat = $sertifikat->templatesertifikat_kegiatan;
        if (!$templateSertifikat) {
            return back()->withErrors('Template sertifikat belum diupload.');
        }

        // Ambil path file sertifikat asli
        $backgroundPath = str_replace('\\', '/', public_path('storage/' . ltrim($templateSertifikat, '/')));
        if (!file_exists($backgroundPath)) {
            return back()->withErrors('File template tidak ditemukan: ' . $backgroundPath);
        }

        // Encode dan Mime file sertifikat asli
        $backgroundBase64 = base64_encode(file_get_contents($backgroundPath));
        $backgroundMime = mime_content_type($backgroundPath);

        // Decode posisi fields sertifikat
        $rawFields = $sertifikat->fieldstemplatesertifikat_kegiatan;
        $fieldstemplates = is_string($rawFields) ? json_decode($rawFields, true) : (is_array($rawFields) ? $rawFields : []);

        // Ambil list peserta kegiatan
        $pesertaList = $sertifikat->pesertakegiatans;
        if ($pesertaList->isEmpty()) {
            return back()->withErrors('Tidak ada peserta.');
        }

        // Formating capaian JP ke text
        $totaljp = optional($sertifikat->balasanlaporankegiatans)->totalcapaianjp_kegiatan ?? 0;
        $totaljp_text = $totaljp > 0
            ? $totaljp . ' (' . $this->terbilangJP($totaljp) . ')'
            : '';


        // Buat folder temp untuk ZIP
        $folder = storage_path('app/public/izin/temp/');
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        // Penamaan file ZIP
        $zipFileName = "Sertifikat_Kegiatan_{$laporankegiatan_id}.zip";
        $zipPath = $folder . $zipFileName;

        // Proses pembuatan folder ZIP
        $zip = new \ZipArchive();
        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== TRUE) {
            return back()->withErrors('Gagal membuat ZIP.');
        }

        // Penamaan file di dalam ZIP dengan nama peserta kegiatan
        foreach ($pesertaList as $peserta) {
            $cleanName = preg_replace('/[^A-Za-z0-9 _-]/', '', $peserta->nama_peserta);
            $pdfFileName = "{$cleanName}.pdf";

            // Load view PDF
            $pdfContent = PDF::loadView('pages.generatepdf.sertifikat_kegiatan', [
                'sertifikat' => $sertifikat,
                'peserta' => $peserta,
                'fieldstemplatesertifikat_kegiatan' => $fieldstemplates,
                'backgroundPath' => $backgroundPath,
                'backgroundBase64' => $backgroundBase64,
                'backgroundMime' => $backgroundMime,
                'totalcapaianjp_text' => $totaljp_text,
            ])->setOptions([
                'dpi' => 96,
                'defaultFont' => 'Times New Roman',
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
                'chroot' => public_path(),
                'fontHeightRatio' => 1.3,
            ])->setPaper('a4', 'landscape')->output();

            $zip->addFromString($pdfFileName, $pdfContent);
        }
        $zip->close();

        // Redirect dan simpan folder ZIP
        return response()->download($zipPath, $zipFileName, ['Content-Type' => 'application/zip'])->deleteFileAfterSend(true);
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
