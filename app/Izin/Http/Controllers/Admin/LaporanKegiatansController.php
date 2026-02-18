<?php

namespace App\Izin\Http\Controllers\Admin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Detaillaporankegiatans;
use App\Izin\Models\Izin_Inputlaporankegiatans;
use App\Izin\Models\Izin_Laporankegiatans;
use App\Izin\Models\Izin_RefCarapelatihans;
use App\Izin\Models\Izin_RefMetodepelatihans;
use App\Izin\Models\Izin_Stempelunitkerjas;
use App\Izin\Models\Izin_Ttdunitkerjas;
use App\Izin\Models\Izin_Usulankegiatans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\PDF;

class LaporanKegiatansController extends Controller
{
    /**
     * Tampilkan Form Ajukan Laporan Hasil Kegiatan Pengembangan Kompetensi ASN
     */
    public function create($id)
    {
        // Ambil user yang sedang login saat ini
        $user = Auth::user();

        // Eager load relasi dari model dan temukan usulankegiatan dari id
        $usulankegiatans = Izin_Usulankegiatans::with([
            'inputusulankegiatans',
            'detailusulankegiatans'
        ])->findOrFail($id);

        // Redirect ke halaman ajukan laporan kegiatan
        return view('pages.laporankegiatan.ajukan_laporan_kegiatan', [
            'unitkerjas' => $user->subunitkerjas?->unitkerjas?->unitkerja,
            'subunitkerjas' => $user->subunitkerjas->sub_unitkerja ?? null,
            'dibuat_oleh' => $user->nama,
            'usulankegiatans' => $usulankegiatans,
            'carapelatihans' => Izin_RefCarapelatihans::select('id', 'cara_pelatihan')->get(),
            'metodepelatihans' => Izin_RefMetodepelatihans::select('id', 'metode_pelatihan')->get(),
        ]);
    }

    /**
     * Simpan Data Pada Form Ajukan Laporan Hasil Kegiatan Pengembangan Kompetensi ASN
     */
    public function store(Request $request, $id)
    {
        // Ambil user yang sedang login saat ini
        $user = Auth::user();

        // Temukan usulankegiatan dari id
        $usulankegiatans = Izin_Usulankegiatans::findOrFail($id);

        // Simpan data awal laporankegiatan
        $laporankegiatans = Izin_Laporankegiatans::create([
            'lokasi_kegiatan' => $request->lokasi_kegiatan,
            'tanggalmulai_kegiatan' => $request->tanggalmulai_kegiatan,
            'tanggalselesai_kegiatan' => $request->tanggalselesai_kegiatan,
            'waktumulai_kegiatan' => $request->waktumulai_kegiatan,
            'waktuselesai_kegiatan' => $request->waktuselesai_kegiatan,
            'statuslaporan_kegiatan' => 'completed'
        ]);

        // Simpan data inputlaporankegiatan
        Izin_Inputlaporankegiatans::create([
            'laporankegiatan_id' => $laporankegiatans->id,
            'inputusulankegiatan_id' => $usulankegiatans->inputusulankegiatans->id,
            'pjunitkerja_id' => $user->id
        ]);

        // Redirect ke halaman edit laporan kegiatan
        return redirect()->route('admin.laporankegiatan.edit', $usulankegiatans->id)->with('success', 'Silakan lengkapi data usulan kegiatan.');
    }

    /**
     * Tampilkan Form Edit Ajukan Laporan Hasil Kegiatan Pengembangan Kompetensi ASN
     */
    public function edit($id)
    {
        // Eager load relasi dari model
        $usulankegiatans = Izin_Usulankegiatans::with([
            'inputusulankegiatans',
            'detailusulankegiatans'
        ])->findOrFail($id);

        // Ambil laporan kegiatan
        $inputlaporankegiatans = $usulankegiatans->inputlaporankegiatans;
        $laporankegiatans = $inputlaporankegiatans->laporankegiatans;

        // Verifikasi bahwa status laporankegiatan tidak sama dengan completed
        if ($laporankegiatans->statuslaporan_kegiatan !== 'completed') {
            abort(403, 'Usulan sudah tidak dapat diubah.');
        }

        // Pastikan detaillaporankegiatan selalu ada
        $detaillaporankegiatans = $laporankegiatans->detaillaporankegiatans ?? new Izin_Detaillaporankegiatans();

        // Redirect ke halaman lengkapi laporan hasil kegiatan
        return view('pages.laporankegiatan.lengkapi_laporan_kegiatan', [
            'usulankegiatans' => $usulankegiatans,
            'laporankegiatans' => $laporankegiatans,
            'detaillaporankegiatans' => $detaillaporankegiatans,
            'subunitkerjas' => $usulankegiatans->subunitkerjas->sub_unitkerja,
            'unitkerjas' => $usulankegiatans->subunitkerjas->unitkerjas->unitkerja,
            'carapelatihans' => Izin_RefCarapelatihans::all(),
            'metodepelatihans' => Izin_RefMetodepelatihans::all(),
        ]);
    }

    /**
     * Update Data Pada Form Edit Ajukan Laporan Hasil Kegiatan Pengembangan Kompetensi ASN
     */
    public function update(Request $request, $id)
    {
        // Temukan usulankegiatan berdasarkan id
        $usulankegiatans = Izin_Usulankegiatans::with(
            'inputlaporankegiatans.laporankegiatans.detaillaporankegiatans'
        )->findOrFail($id);

        // Ambil laporan kegiatan
        $inputlaporan = $usulankegiatans->inputlaporankegiatans;
        $laporankegiatans = $inputlaporan->laporankegiatans;

        // Verifikasi bahwa status laporankegiatan tidak sama dengan completed
        if ($laporankegiatans->statuslaporan_kegiatan !== 'completed') {
            abort(403);
        }

        // Update data laporankegiatan
        $laporankegiatans->update([
            'lokasi_kegiatan' => $request->lokasi_kegiatan,
            'carapelatihan_id' => $request->carapelatihan_id,
            'tanggalmulai_kegiatan' => $request->tanggalmulai_kegiatan,
            'tanggalselesai_kegiatan' => $request->tanggalselesai_kegiatan,
            'waktumulai_kegiatan' => $request->waktumulai_kegiatan,
            'waktuselesai_kegiatan' => $request->waktuselesai_kegiatan,
            'statuslaporan_kegiatan' => $request->statuslaporan_kegiatan,
        ]);

        // Lanjutkan proses store ke controller detaillaporankegiatan
        return app(DetailLaporanKegiatansController::class)->store($request);
    }

    /**
     * Download Laporan Hasil Kegiatan Pengembangan Kompetensi ASN
     */
    public function download($id)
    {
        // Ambil user yang sedang login saat ini
        $user = Auth::user();

        // Eager load relasi dari model dan temukan laporankegiatan berdasarkan id
        $laporankegiatans = Izin_Laporankegiatans::with([
            'detaillaporankegiatans',
            'inputlaporankegiatans',
            'inputlaporankegiatans.inputusulankegiatans',
            'inputlaporankegiatans.inputusulankegiatans.kopunitkerjas',
            'detaillaporankegiatans.pesertakegiatans',
            'inputlaporankegiatans.inputusulankegiatans.usulankegiatans',
        ])->findOrFail($id);

        // Ambil kop,ttd, dan stempel dari inputusulankegiatan pertama (1 unitkerja dianggap telah mengupload sekali)
        $kop = $laporankegiatans->inputlaporankegiatans->inputusulankegiatans->first()?->kopunitkerjas ?? null;
        $ttd = Izin_Ttdunitkerjas::where('unitkerja_id', $user->subunitkerjas->unitkerja_id)->first();
        $stempel = Izin_Stempelunitkerjas::where('unitkerja_id', $user->subunitkerjas->unitkerja_id)->first();

        // Ambil gambar logo surakarta sebagai kop surat dari asset
        $kop_path = public_path('build/assets/kop_surat.png'); // contoh nama file
        if (!file_exists($kop_path)) {
            $kop_path = null; // fallback kalau tidak ada file kop
        }

        // Baca file excel rundown laporan kegiatan kalau ada
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

        // Baca file excel peserta kegiatan kalau ada
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

        // Baca file gambar dokumentasi laporan kegiatan kalau ada
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

        // Load view PDF
        $pdf = PDF::loadView('pages.generatepdf.laporan_hasil_kegiatan', [
            'laporankegiatans' => $laporankegiatans,
            'rundown_laporan' => $rundown_laporan,
            'peserta_laporan' => $peserta_laporan,
            'gambardokumentasi_laporan' => $gambardokumentasi_laporan,
            'format_anggaran' => $anggaranFormat,
            'atribut_khusus' => $atribut_khusus,
            'kop_path' => $kop_path,
            'kop' => $kop,
            'ttd' => $ttd,
            'stempel' => $stempel,
            'user'   => $user,
        ])->setPaper('A4', 'portrait');

        // Redirect dan simpan file PDF
        return $pdf->stream('Laporan Hasil Kegiatan ' . $laporankegiatans->inputlaporankegiatans->inputusulankegiatans->nama_kegiatan . '.pdf');
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
