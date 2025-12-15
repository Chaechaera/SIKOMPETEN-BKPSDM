<?php

namespace App\Izin\Http\Controllers\User;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Balasanlaporankegiatans;
use App\Izin\Models\Izin_Detaillaporankegiatans;
use App\Izin\Models\Izin_Laporankegiatans;
use App\Izin\Models\Izin_Pesertakegiatans;
use App\Izin\Models\Izin_Sertifikats;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Facades\Storage;

class SertifikatsController extends Controller
{
    /**
     * Generate dan simpan sertifikat baru
     */
    public function create(Request $request)
    {
        $laporankegiatans = Izin_Laporankegiatans::with([
            'usulankegiatans',
            'detaillaporankegiatans.pesertakegiatans'
        ])->findOrFail($request->laporankegiatan_id);

        $tanggalsertifikat = $request->tanggalkeluarsertifikat_kegiatan;

        // ===== CEGAH DUPLIKAT SERTIFIKAT KEGIATAN =====
        $existing = Izin_Sertifikats::where('laporankegiatan_id', $laporankegiatans->id)->first();
        if ($existing) {
            return $existing; // JANGAN GENERATE ULANG
        }

        // Pastikan usulankegiatans ada
        $usulan = $laporankegiatans->usulankegiatans;
        if (!$usulan) {
            return response()->json(['error' => 'Usulankegiatan tidak ditemukan'], 400);
        }

        // ===== Generate Nomor Sertifikat Kegiatan =====
        $carapelatihan_id = str_pad($laporankegiatans->usulankegiatans->carapelatihan_id, 2, '0', STR_PAD_LEFT);
        $count = Izin_Sertifikats::count() + 1;
        $urutan = str_pad($count, 3, '0', STR_PAD_LEFT);
        $bulanRomawi = $this->convertToRomawi(now()->format('n'));
        $tahun = now()->year;

        $nomorsertifikatkegiatans = "{$carapelatihan_id}/BKPSDM/{$urutan}/{$bulanRomawi}/{$tahun}";

        // ===== Normalisasi fieldstemplatesertifikat_kegiatan =====
        $dataFields = $request->fieldstemplatesertifikat_kegiatan;

        if (is_string($dataFields)) {
            $dataFields = $dataFields === "" ? [] : json_decode($dataFields, true);
        }

        // Simpan ke tabel sertifikat kegiatan
        $sertifikats = Izin_Sertifikats::create([
            'laporankegiatan_id' => $laporankegiatans->id,
            'usulankegiatan_id' => $laporankegiatans->usulankegiatans->id,
            'nomorsertifikat_kegiatan' => $nomorsertifikatkegiatans,
            'tanggalkeluarsertifikat_kegiatan' => $tanggalsertifikat,
            'fieldstemplatesertifikat_kegiatan' => $dataFields,
        ]);

        // ===== HUBUNGKAN DENGAN BALASAN =====
        $balasan = Izin_Balasanlaporankegiatans::where('laporankegiatan_id', $laporankegiatans->id)->first();
        if ($balasan) {
            $balasan->update([
                'sertifikat_id' => $sertifikats->id,
            ]);
        }

        // ===== Generate Nomor Sertifikat Peserta =====
        $detail = $laporankegiatans->detaillaporankegiatans;

        if ($detail && $detail->pesertakegiatans) {
            foreach ($detail->pesertakegiatans as $index => $peserta) {
                if (!$peserta->nomorsertifikatpeserta_kegiatan) {
                    $nomorPeserta = $nomorsertifikatkegiatans . '/' . str_pad($index + 1, 3, '0', STR_PAD_LEFT);
                    $peserta->update(['nomorsertifikatpeserta_kegiatan' => $nomorPeserta]);
                }
            }
        }

            /*$pesertaList = Izin_Pesertakegiatans::where('detaillaporankegiatan_id', $detail->id)
                ->whereNull('nomorsertifikatpeserta_kegiatan')
                ->get();

            foreach ($pesertaList as $index => $peserta) {
                if (!$peserta instanceof \Illuminate\Database\Eloquent\Model) continue;

                $nomorsertifikatspeserta = $nomorsertifikatkegiatans . '/' . str_pad($index + 1, 3, '0', STR_PAD_LEFT);

                $peserta->update([
                    'nomorsertifikatpeserta_kegiatan' => $nomorsertifikatspeserta,
                ]);
            }
        }**/

        // ===== Generate Nomor Sertifikat Peserta =====
        /**foreach ($laporankegiatans->detaillaporankegiatans as $detail) {
            if ($detail && $detail->pesertakegiatans) {
                foreach ($detail->pesertakegiatans as $index => $peserta) {
                    if (!$peserta->nomorsertifikatpeserta_kegiatan) {
                        $nomorsertifikatspeserta = $nomorsertifikatkegiatans . '/' . str_pad($index + 1, 3, '0', STR_PAD_LEFT);

                        $peserta->update([
                            'nomorsertifikatpeserta_kegiatan' => $nomorsertifikatspeserta,
                        ]);
                    }
                }
            }
        }**/
        return $sertifikats;
    }

    public function download($sertifikat_id, $peserta_id)
    {
        $sertifikat = Izin_Sertifikats::with(['laporankegiatans.detaillaporankegiatans'])->findOrFail($sertifikat_id);
        $detail = $sertifikat->laporankegiatans->detaillaporankegiatans ?? null;

        if (!$detail) {
            return back()->withErrors('Detail template sertifikat tidak ditemukan.');
        }

        // ambil background (template) dari detail
        /*$templateFilename = $detail->templatesertifikat_kegiatan;
        if (!$templateFilename) {
            return back()->withErrors('Template sertifikat belum di-upload.');
        }

        //$templatePath = storage_path('app/public/' . ltrim($templateFilename, '/'));
        if (!str_contains($templateFilename, 'izin/template_sertifikat')) {
    $templateFilename = 'izin/template_sertifikat/' . $templateFilename;
}

$templatePath = storage_path('app/public/' . $templateFilename);*/

$templateFilename = $detail->templatesertifikat_kegiatan;
$templatePath = storage_path('app/public/' . ltrim($templateFilename, '/'));

if (!file_exists($templatePath)) {
    return back()->withErrors('File template tidak ditemukan: ' . $templatePath);
}

        // base64 untuk dompdf
        $backgroundBase64 = base64_encode(file_get_contents($templatePath));

        // ambil fields dari tabel sertifikats (bisa array atau json-string)
        $raw = $sertifikat->fieldstemplatesertifikat_kegiatan;
        $fieldstemplates = is_string($raw) ? json_decode($raw, true) : (is_array($raw) ? $raw : []);

        // peserta
        $peserta = Izin_Pesertakegiatans::findOrFail($peserta_id);

        // Kirim ke view
        $pdf = PDF::loadView('pages.generatepdf.sertifikat_kegiatan', [
            'sertifikat' => $sertifikat,
            'peserta' => $peserta,
            'fieldstemplatesertifikat_kegiatan' => $fieldstemplates,
            'backgroundBase64' => $backgroundBase64,
        ])->setPaper('A4', 'landscape');

        $filename = 'Sertifikat_' . preg_replace('/[^A-Za-z0-9 _-]/', '', $peserta->nama_peserta) . '.pdf';

        return $pdf->stream($filename);
    }

public function downloadZIP($laporankegiatan_id)
{
    // ambil sertifikat berdasarkan laporankegiatan
        $sertifikat = Izin_Sertifikats::with(['laporankegiatans.detaillaporankegiatans.pesertakegiatans'])
            ->where('laporankegiatan_id', $laporankegiatan_id)
            ->first();

        if (!$sertifikat) {
            return back()->withErrors('Tidak ada sertifikat untuk kegiatan ini.');
        }

        $detail = $sertifikat->laporankegiatans->detaillaporankegiatans ?? null;
        if (!$detail) {
            return back()->withErrors('Detail template sertifikat tidak ditemukan.');
        }

        // ambil semua peserta (flatten jika banyak)
        $pesertaList = $detail->pesertakegiatans ?? collect();
        if ($pesertaList->isEmpty()) {
            return back()->withErrors('Tidak ada peserta untuk dibuat sertifikat.');
        }

        // ambil template (file pada storage/app/public/...)
        /*$templateFilename = $detail->templatesertifikat_kegiatan;
        if (!$templateFilename) {
            return back()->withErrors('Template sertifikat belum di-upload.');
        }

        //$templatePath = storage_path('app/public/' . ltrim($templateFilename, '/'));
        if (!str_contains($templateFilename, 'izin/template_sertifikat')) {
    $templateFilename = 'izin/template_sertifikat/' . $templateFilename;
}

$templatePath = storage_path('app/public/' . $templateFilename);*/

$templateFilename = $detail->templatesertifikat_kegiatan;
$templatePath = storage_path('app/public/' . ltrim($templateFilename, '/'));

if (!file_exists($templatePath)) {
    return back()->withErrors('File template tidak ditemukan: ' . $templatePath);
}

//dd($templatePath, file_exists($templatePath));

        // background base64
        $backgroundBase64 = base64_encode(file_get_contents($templatePath));

        // decode field positions
        $raw = $sertifikat->fieldstemplatesertifikat_kegiatan;
        $fieldstemplates = is_string($raw) ? json_decode($raw, true) : (is_array($raw) ? $raw : []);

        // folder sementara di storage/app/public/izin/temp/
        $folder = storage_path('app/public/izin/temp/');
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        $zipFileName = "Sertifikat_Kegiatan_{$laporankegiatan_id}.zip";
        $zipPath = $folder . $zipFileName;

        $zip = new \ZipArchive();
        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== TRUE) {
            return back()->withErrors('Gagal membuat ZIP.');
        }

        foreach ($pesertaList as $peserta) {
            $cleanName = preg_replace('/[^A-Za-z0-9 _-]/', '', $peserta->nama_peserta);
            $pdfFileName = "{$cleanName}.pdf";

            $pdfContent = PDF::loadView('pages.generatepdf.sertifikat_kegiatan', [
                'sertifikat' => $sertifikat,
                'peserta' => $peserta,
                'fieldstemplatesertifikat_kegiatan' => $fieldstemplates,
                'backgroundBase64' => $backgroundBase64,
            ])->setPaper('A4', 'landscape')->output();

            $zip->addFromString($pdfFileName, $pdfContent);
        }

        $zip->close();

        // kembalikan file ZIP untuk di-download (browser)
        return response()->download($zipPath, $zipFileName, ['Content-Type' => 'application/zip'])->deleteFileAfterSend(true);
}

    /*public function downloadZIP($laporankegiatan_id)
{
    $sertifikats = Izin_Sertifikats::with(['pesertakegiatans', 'laporankegiatans'])
        ->where('laporankegiatan_id', $laporankegiatan_id)
        ->get();

    if ($sertifikats->isEmpty()) {
        return back()->withErrors('Tidak ada sertifikat yang dapat diunduh.');
    }

    $first = $sertifikats->first();

    // ===== FIX 1: Path template harus absolute =====
    $templatesertifikatUrl = storage_path('app/public/' . $first->templatesertifikat_kegiatan);

    // ===== FIX 2: Decode field =====
    $fieldstemplatesertifikat_kegiatan = is_string($first->fieldstemplatesertifikat_kegiatan)
        ? json_decode($first->fieldstemplatesertifikat_kegiatan, true)
        : $first->fieldstemplatesertifikat_kegiatan;

    // ===== FIX 3: Pastikan folder temp ada =====
    $folder = storage_path("app/public/izin/temp/");
    if (!file_exists($folder)) {
        mkdir($folder, 0777, true);
    }

    $zipFileName = "Sertifikat_Kegiatan_{$laporankegiatan_id}.zip";
    $zipPath = $folder . $zipFileName;

    $zip = new \ZipArchive();
    if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== TRUE) {
        return back()->withErrors('Gagal membuat ZIP.');
    }

    foreach ($sertifikats as $sertifikat) {

        // ===== FIX 4: Bersihkan nama file dari karakter ilegal =====
        $cleanName = preg_replace('/[^A-Za-z0-9 _-]/', '', $sertifikat->pesertakegiatans->nama_peserta);
        $pdfFileName = $cleanName . ".pdf";

        // ===== Generate PDF =====
        $pdfContent = PDF::loadView('pages.generatepdf.sertifikat_kegiatan', [
            'sertifikat' => $sertifikat,
            'fieldstemplatesertifikat_kegiatan' => $fieldstemplatesertifikat_kegiatan,
            'templatesertifikatUrl' => $templatesertifikatUrl
        ])->output();

        $zip->addFromString($pdfFileName, $pdfContent);
    }

    $zip->close();

    // ===== FIX 5: Tambahkan nama file agar browser langsung download =====
    return response()->download(
        $zipPath,
        $zipFileName,
        ['Content-Type' => 'application/zip']
    )->deleteFileAfterSend(true);
}*/

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
}
