<?php

namespace App\Izin\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Identitassurats;
use App\Izin\Models\Izin_Laporankegiatans;
use App\Izin\Models\Izin_Cetaklaporankegiatans;
use App\Izin\Models\Izin_Inputlaporankegiatans; // ✅ FIX MISSING IMPORT
use App\Izin\Models\Izin_Stempelunitkerjas;
use App\Izin\Models\Izin_Ttdunitkerjas;
use App\Izin\Models\Izin_Usulankegiatans;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CetakLaporanKegiatansController extends Controller
{
    /**
     * Simpan Data Cetak Laporan Hasil Kegiatan
     */
    public function store(Request $request, $id)
{
    $input = Izin_Inputlaporankegiatans::with('laporankegiatans')
        ->findOrFail($id);

    $laporan = $input->laporankegiatans;

    if (!$laporan) {
        abort(404, 'Laporan tidak ditemukan');
    }

    DB::transaction(function () use ($laporan, $input) {

        Izin_Cetaklaporankegiatans::firstOrCreate([
            'inputlaporankegiatan_id' => $input->id
        ]);

        // 🔥 FORCE UPDATE (PASTI KENA DB)
        Izin_Laporankegiatans::where('id', $laporan->id)
            ->update([
                'statuslaporan_kegiatan' => 'pending'
            ]);
    });

    return back()->with('success', 'Data cetak berhasil dibuat');
}

public function download(Request $request, $id)
{
    $usulan = Izin_Usulankegiatans::with([
        'inputlaporankegiatans.laporankegiatans.detaillaporankegiatans',
        'inputlaporankegiatans.cetaklaporankegiatans.identitassurats'
    ])->findOrFail($id);

    $input = $usulan->inputlaporankegiatans;

    if (!$input) {
        abort(404, 'Input laporan tidak ditemukan');
    }

    $laporan = $input->laporankegiatans;

    if (!$laporan) {
        abort(404, 'Laporan tidak ditemukan');
    }

    DB::transaction(function () use ($request, $input, $laporan) {

    // Ambil user yang sedang login saat ini
            $user = Auth::user();

        // 🔥 VALIDASI NOMOR SURAT (WAJIB UNIK)
        $validated = $request->validate([
            'nomor_surat'   => 'required|unique:izin_identitassurats,nomor_surat',
            'tanggal_surat' => 'required',
            'lampiran_surat'=> 'required',
            'sifat_surat'   => 'required',
            'perihal_surat' => 'required',
        ]);

        // 🔥 CETAK (ANTI DUPLIKAT)
        $cetak = Izin_Cetaklaporankegiatans::with('identitassurats')
    ->firstOrCreate([
        'inputlaporankegiatan_id' => $input->id
    ]);

    
    $identitas = $cetak->identitassurats;

if ($identitas) {

    $identitas->update([
        'nomor_surat' => $request->nomor_surat,
        'tanggal_surat' => Carbon::createFromFormat('d-m-Y', $request->tanggal_surat)->format('Y-m-d'),
        'lampiran_surat' => $request->lampiran_surat,
        'sifat_surat' => $request->sifat_surat,
        'perihal_surat' => $request->perihal_surat,
    ]);

} else {

    $identitas = Izin_Identitassurats::create([
        'nomor_surat' => $request->nomor_surat,
        'tanggal_surat' => Carbon::createFromFormat('d-m-Y', $request->tanggal_surat)->format('Y-m-d'),
        'lampiran_surat' => $request->lampiran_surat,
        'sifat_surat' => $request->sifat_surat,
        'perihal_surat' => $request->perihal_surat,
    ]);

                // Ambil ttdunitkerja terakhir user yang sedang login saat ini
            $ttdunitkerja_user = Izin_Ttdunitkerjas::where('subunitkerja_id', $user->subunitkerja_id)->latest()->first();
            $ttdunitkerja_id = $usulan->inputusulankegiatans?->ttdunitkerja_id ?? $ttdunitkerja_user?->id ?? null;

            // Ambil stempelunitkerja terakhir user yang sedang login saat ini
            $stempelunitkerja_user = Izin_Stempelunitkerjas::where('subunitkerja_id', $user->subunitkerja_id)->latest()->first();
            $stempelunitkerja_id = $usulan->inputusulankegiatans?->stempelunitkerja_id ?? $stempelunitkerja_user?->id ?? null;


    $cetak->update([
        'identitassurat_id' => $identitas->id,
        'nipadmin_cetaklaporankegiatan' => $user->nip,
                'pjunitkerja_id' => $user->id,
                'statuslaporan_kegiatan' => 'pending',
                'ttdunitkerja_id' => $ttdunitkerja_id,
                'stempelunitkerja_id' => $stempelunitkerja_id
    ]);
}

        // 🔥 UPDATE STATUS
        $laporan->update([
            'statuslaporan_kegiatan' => 'pending'
        ]);
    });

    // 🔥 REFRESH TOTAL (INI PENTING BIAR PDF NGGAK CACHE)
    $usulan->refresh()->load([
        'inputlaporankegiatans.laporankegiatans.detaillaporankegiatans',
        'inputlaporankegiatans.cetaklaporankegiatans.identitassurats'
    ]);

    $laporankegiatans = $laporan->load([
    'detaillaporankegiatans',
    'inputlaporankegiatans',
    'inputlaporankegiatans.cetaklaporankegiatans.identitassurats',
    'inputlaporankegiatans.inputusulankegiatans',
    'inputlaporankegiatans.inputusulankegiatans.kopunitkerjas',
    'detaillaporankegiatans.pesertakegiatans',
    'inputlaporankegiatans.inputusulankegiatans.usulankegiatans',
]);
        // Ambil data cetak laporan kegiatan
        $cetak = $laporankegiatans->inputlaporankegiatans->cetaklaporankegiatans;

        /*
        |--------------------------------------------------------------------------
        | Kalau PDF sudah pernah dibuat, langsung download file lama
        |--------------------------------------------------------------------------
        */

        if (
            $cetak &&
            $cetak->filepdfgenerate_path &&
            Storage::disk('public')->exists($cetak->filepdfgenerate_path)
        ) {
            return Storage::disk('public')->download(
                $cetak->filepdfgenerate_path,
                'Laporan dan Surat Hasil Pelaksanaan Kegiatan ' .
                    $laporankegiatans->inputlaporankegiatans->inputusulankegiatans->nama_kegiatan .
                    '.pdf'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Belum pernah generate -> buat PDF
        |--------------------------------------------------------------------------
        */

        // Ambil kop,ttd, dan stempel dari inputusulankegiatan pertama (1 unitkerja dianggap telah mengupload sekali)
        $kop = $laporankegiatans->inputlaporankegiatans?->inputusulankegiatans?->kopunitkerjas;
        $ttd = Izin_Ttdunitkerjas::where('subunitkerja_id', $kop?->subunitkerja_id)->first();
        $stempel = Izin_Stempelunitkerjas::where('subunitkerja_id', $kop?->subunitkerja_id)->first();

        // Ambil gambar logo surakarta sebagai kop surat dari asset
        $kop_path = public_path('build/assets/kop_surat.png');

        if (!file_exists($kop_path)) {
            $kop_path = null;
        }

        // Baca file excel rundown laporan kegiatan kalau ada
        $rundown_laporan = [];
        $rundownMerge = [];

        if ($laporankegiatans->detaillaporankegiatans?->rundown_laporan) {

            $path = storage_path(
                'app/public/' .
                    $laporankegiatans->detaillaporankegiatans->rundown_laporan
            );

            if (file_exists($path)) {

                try {

                    $spreadsheet = IOFactory::load($path);
                    $sheet = $spreadsheet->getActiveSheet();

                    $mergeInfo = [];
                    $headerMerge = [];
                    foreach ($sheet->getMergeCells() as $merge) {

                        if (preg_match('/A(\d+):A(\d+)/', $merge, $m)) {

                            $start = (int) $m[1];
                            $end   = (int) $m[2];

                            $mergeInfo[$start] = $end - $start + 1;
                        }

                        // Merge horizontal (header)
                        if (preg_match('/^A(\d+):([A-Z]+)\1$/', $merge, $m)) {

                            $headerMerge[(int)$m[1]] = true;
                        }
                    }

                    $rundownMerge = $mergeInfo;

                    $rowNumber = 1;

                    foreach ($sheet->toArray(null, true, true, true) as $row) {

                        $row = array_values(array_slice($row, 0, 3));

                        // simpan nomor baris excel
                        $row['_row'] = $rowNumber;
                        $row['_rowspan'] = $mergeInfo[$rowNumber] ?? 0;

                        // default
                        $row['_isGroupHeader'] = false;
                        $row['_isColumnHeader'] = false;

                        // Header grup (merge A:C)
                        if (isset($headerMerge[$rowNumber])) {
                            $row['_isGroupHeader'] = true;
                        }

                        // Header kolom
                        elseif (
                            strtolower(trim($row[0] ?? '')) == 'waktu' &&
                            strtolower(trim($row[1] ?? '')) == 'kegiatan'
                        ) {
                            $row['_isColumnHeader'] = true;
                        }

                        $rundown_laporan[] = $row;

                        $rowNumber++;
                    }
                } catch (\Exception $e) {

                    $rundown_laporan = [];
                    $rundownMerge = [];
                }
            }
        }

        $peserta_laporan = [];
        $pesertaMerge = [];
        if ($laporankegiatans->detaillaporankegiatans?->peserta_laporan) {
            $path = storage_path('app/public/' . $laporankegiatans->detaillaporankegiatans->peserta_laporan);
            if (file_exists($path)) {
                try {

                    $spreadsheet = IOFactory::load($path);
                    $sheet = $spreadsheet->getActiveSheet();

                    $mergeInfo = [];
                    foreach ($sheet->getMergeCells() as $merge) {

                        if (preg_match('/A(\d+):A(\d+)/', $merge, $m)) {

                            $start = (int) $m[1];
                            $end   = (int) $m[2];

                            $mergeInfo[$start] = $end - $start + 1;
                        }
                    }

                    $pesertaMerge = $mergeInfo;

                    $rowNumber = 1;

                    foreach ($sheet->toArray(null, true, true, true) as $row) {

                        $row = array_values(array_slice($row, 0, 4));

                        // simpan nomor baris excel
                        $row['_row'] = $rowNumber;

                        // simpan rowspan
                        $row['_rowspan'] = $pesertaMerge[$rowNumber] ?? 0;

                        $peserta_laporan[] = $row;

                        $rowNumber++;
                    }
                } catch (\Exception $e) {

                    $peserta_laporan = [];
                    $pesertaMerge = [];
                }
            }
        }

        //Baca file gambar dokumentasi kegiatan kalau ada
        $gambardokumentasi_laporan = [];
        if ($laporankegiatans->detaillaporankegiatans?->gambardokumentasi_laporan) {
            $files_gambardokumentasi = $laporankegiatans->detaillaporankegiatans->gambardokumentasi_laporan ?? [];
            foreach ($files_gambardokumentasi as $file) {
                $path = storage_path("app/public/" . $file);
                if (file_exists($path)) {
                    $gambardokumentasi_laporan[] = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($path));
                } else {
                    $gambardokumentasi_laporan[] = null;
                }
            }
        }

        // Ambil terbilang angka untuk laporan kegiatan
        $anggaran = $laporankegiatans->inputlaporankegiatans->inputusulankegiatans->usulankegiatans->detailusulankegiatans->alokasianggaran_kegiatan ?? 0;
        $anggaranFormat = $this->rupiahTerbilang($anggaran);

        // Ambil atribut khusus untuk laporan kegiatan
        $atribut_khusus = $laporankegiatans->detaillaporankegiatans->atribut_khusus ?? [];

        // Ambil identitas surat
        $identitas = optional(
            optional(
                $laporankegiatans
                    ->inputlaporankegiatans
                    ->cetaklaporankegiatans
            )->identitassurats
        );

        // Load view PDF
        $pdf = PDF::loadView('pages.generatepdf.laporan_hasil_kegiatan', [
            'laporankegiatans' => $laporankegiatans,
            'rundown_laporan' => $rundown_laporan,
            'rundownMerge' => $rundownMerge,
            'peserta_laporan' => $peserta_laporan,
            'pesertaMerge' => $pesertaMerge,
            'gambardokumentasi_laporan' => $gambardokumentasi_laporan,
            'format_anggaran' => $anggaranFormat,
            'atribut_khusus' => $atribut_khusus,
            'kop_path' => $kop_path,
            'kop' => $kop,
            'ttd' => $ttd,
            'stempel' => $stempel,
            'identitas' => $identitas,
        ])->setPaper('A4', 'portrait');

        /*
        |--------------------------------------------------------------------------
        | Simpan PDF permanen
        |--------------------------------------------------------------------------
        */

        // Buat folder penyimpanan dokumen generate
        $folder = 'generated/laporan';
        Storage::disk('public')->makeDirectory($folder);

        // Penamaan dan menyimpan dokumen hasil generate
        $fileName = $id . '.pdf';
        $path = $folder . '/' . $fileName;
        Storage::disk('public')->put(
            $path,
            $pdf->output()
        );

        // Simpan lokasi file ke database
        if ($cetak) {
            $cetak->update([
                'filepdfgenerate_path' => $path,
            ]);
        } else {
            $cetak = $laporankegiatans
                ->inputlaporankegiatans
                ->cetaklaporankegiatans()
                ->create([
                    'filepdfgenerate_path' => $path,
                ]);
        }

        // Download file dokumen hasil generate langsung
        return Storage::disk('public')->download(
            $path,
            'Laporan dan Surat Hasil Pelaksanaan Kegiatan ' .
                $laporankegiatans->inputlaporankegiatans->inputusulankegiatans->nama_kegiatan .
                '.pdf'
        );}

public function create($id)
{
    
    $usulan = Izin_Usulankegiatans::with([
        'inputlaporankegiatans.laporankegiatans.detaillaporankegiatans',
        'inputlaporankegiatans.cetaklaporankegiatans.identitassurats',
        'subunitkerjas'
    ])->findOrFail($id);

    $input = $usulan->inputlaporankegiatans;

    $cetak = $input?->cetaklaporankegiatans;
    $identitas = $cetak?->identitassurats;
    $laporankegiatans = Izin_Laporankegiatans::find($input->laporankegiatan_id);

    return view('pages.laporankegiatan.cetak_laporan_kegiatan', compact(
        'usulan',
        'input',
        'cetak',
        'identitas',
        'laporankegiatans'
    ));
}

/**
     * Helper Konversi Nilai Angka Rupiah Menjadi Terbilang Nominal
     */
    private function rupiahTerbilang($angka, $case = 'capital')
    {
        if (!is_numeric($angka)) return '-';

        $angka = (int) $angka;

        $formatRupiah = 'Rp ' . number_format($angka, 0, ',', '.') . ',00';

        $huruf = [
            "",
            "satu",
            "dua",
            "tiga",
            "empat",
            "lima",
            "enam",
            "tujuh",
            "delapan",
            "sembilan",
            "sepuluh",
            "sebelas"
        ];

        $terbilang = function ($x) use (&$terbilang, $huruf) {

            // Konversikan terbilang nominal berdasarkan tingkatan
            if ($x < 12)
                return " " . $huruf[$x];
            elseif ($x < 20)
                return $terbilang($x - 10) . " belas";
            elseif ($x < 100)
                return $terbilang($x / 10) . " puluh" . $terbilang($x % 10);
            elseif ($x < 200)
                return " seratus" . $terbilang($x - 100);
            elseif ($x < 1000)
                return $terbilang($x / 100) . " ratus" . $terbilang($x % 100);
            elseif ($x < 2000)
                return " seribu" . $terbilang($x - 1000);
            elseif ($x < 1000000)
                return $terbilang($x / 1000) . " ribu" . $terbilang($x % 1000);
            elseif ($x < 1000000000)
                return $terbilang($x / 1000000) . " juta" . $terbilang($x % 1000000);
            elseif ($x < 1000000000000)
                return $terbilang($x / 1000000000) . " miliar" . $terbilang($x % 1000000000);
            elseif ($x < 1000000000000000)
                return $terbilang($x / 1000000000000) . " triliun" . $terbilang($x % 1000000000000);
            return "";
        };

        $hasil = trim($terbilang($angka)) . " rupiah";

        if ($case == 'upper') $hasil = strtoupper($hasil);
        elseif ($case == 'lower') $hasil = strtolower($hasil);
        else $hasil = ucwords($hasil);

        return $formatRupiah . ' (' . $hasil . ')';
    }
}
