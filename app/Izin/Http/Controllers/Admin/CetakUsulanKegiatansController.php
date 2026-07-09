<?php

namespace App\Izin\Http\Controllers\Admin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Cetakusulankegiatans;
use App\Izin\Models\Izin_Stempelunitkerjas;
use App\Izin\Models\Izin_Ttdunitkerjas;
use App\Izin\Models\Izin_Usulankegiatans;
use App\Izin\Services\IdentitasSuratsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class CetakUsulanKegiatansController extends Controller
{
    /**
     * Simpan Data Cetak Pengajuan Usulan Kegiatan
     */
    public function store(Request $request, IdentitasSuratsService $identitassuratservice, $id)
    {
        // Temukan usulankegiatan berdasarkan id
        $usulan = Izin_Usulankegiatans::findOrFail($id);

        // Verifikasi bahwa status usulankegiatan tidak sama dengan draft
        if ($usulan->statususulan_kegiatan !== 'draft') {
            abort(403, 'Sudah Dicetak');
        }

        // Kalau GET → tampilkan modal
        if ($request->isMethod('get')) {
            return view('pages.usulankegiatan.cetak_usulan_kegiatan', compact('usulan'));
        }

        // Validasi request untuk surat fields
        $request->validate([
            'nomor_surat' => 'required|string|max:30|unique:izin_identitassurats,nomor_surat',
            'tanggal_surat' => 'required|date',
            'lampiran_surat' => 'nullable|string',
            'sifat_surat' => 'required|string',
            'perihal_surat' => 'required|string',
        ], [
            'nomor_surat.unique' => 'Nomor surat sudah digunakan pada usulan kegiatan lain.',
        ]);

        // Transaksi DB berlangsung
        DB::transaction(function () use ($request, $usulan, $identitassuratservice) {

            // Ambil user yang sedang login saat ini
            $user = Auth::user();

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

            // Ambil ttdunitkerja terakhir user yang sedang login saat ini
            $ttdunitkerja_user = Izin_Ttdunitkerjas::where('subunitkerja_id', $user->subunitkerja_id)->latest()->first();
            $ttdunitkerja_id = $usulan->inputusulankegiatans?->ttdunitkerja_id ?? $ttdunitkerja_user?->id ?? null;

            // Ambil stempelunitkerja terakhir user yang sedang login saat ini
            $stempelunitkerja_user = Izin_Stempelunitkerjas::where('subunitkerja_id', $user->subunitkerja_id)->latest()->first();
            $stempelunitkerja_id = $usulan->inputusulankegiatans?->stempelunitkerja_id ?? $stempelunitkerja_user?->id ?? null;

            // Simpan data cetak pengajuan usulan kegiatan
            Izin_Cetakusulankegiatans::create([
                'inputusulankegiatan_id' => $usulan->inputusulankegiatans->id,
                'identitassurat_id' => $identitassurats->id,
                'nipadmin_cetakusulankegiatan' => $user->nip,
                'pjunitkerja_id' => $user->id,
                'statususulan_kegiatan' => 'pending',
                'ttdunitkerja_id' => $ttdunitkerja_id,
                'stempelunitkerja_id' => $stempelunitkerja_id
            ]);

            // Update status usulan kegiatan menjadi "pending"
            $usulan->update([
                'statususulan_kegiatan' => 'pending'
            ]);
        });

        $usulankegiatans = Izin_Usulankegiatans::with([
            'inputusulankegiatans',
            'inputusulankegiatans.kopunitkerjas',
            'inputusulankegiatans.cetakusulankegiatans.identitassurats',
            'detailusulankegiatans'
        ])->findOrFail($id);

        $cetak = $usulankegiatans
            ->inputusulankegiatans
            ->cetakusulankegiatans;

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
                'KAK dan Surat Pengajuan Usulan Kegiatan ' .
                    $usulankegiatans->inputusulankegiatans->nama_kegiatan .
                    '.pdf'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Belum pernah generate -> buat PDF
        |--------------------------------------------------------------------------
        */

        // Ambil kop, ttd dan stempel
        $kop = $usulankegiatans->inputusulankegiatans?->kopunitkerjas;
        $ttd = Izin_Ttdunitkerjas::where('subunitkerja_id', $kop?->subunitkerja_id)->first();
        $stempel = Izin_Stempelunitkerjas::where('subunitkerja_id', $kop?->subunitkerja_id)->first();

        // Ambil gambar logo surakarta sebagai kop surat dari asset
        $kop_path = public_path('build/assets/kop_surat.png'); // contoh nama file
        if (!file_exists($kop_path)) {
            $kop_path = null; // fallback kalau tidak ada file kop
        }

        // Baca file excel jadwal kegiatan kalau ada
        $jadwalpelaksanaan_kegiatan = [];
        $jadwalMerge = [];

        if ($usulankegiatans->detailusulankegiatans?->jadwalpelaksanaan_kegiatan) {

            $path = storage_path(
                'app/public/' .
                    $usulankegiatans->detailusulankegiatans->jadwalpelaksanaan_kegiatan
            );

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

                    $jadwalMerge = $mergeInfo;

                    $rowNumber = 1;

                    foreach ($sheet->toArray(null, true, true, true) as $row) {

                        $row = array_values(array_slice($row, 0, 3));

                        // simpan nomor baris excel
                        $row['_row'] = $rowNumber;

                        // simpan rowspan
                        $row['_rowspan'] = $mergeInfo[$rowNumber] ?? 0;

                        $jadwalpelaksanaan_kegiatan[] = $row;

                        $rowNumber++;
                    }
                } catch (\Exception $e) {

                    $jadwalpelaksanaan_kegiatan = [];
                    $jadwalMerge = [];
                }
            }
        }

        // Ambil identitas surat
        $identitas = optional(
            optional($cetak)->identitassurats
        );

        // Generate PDF
        $pdf = Pdf::loadView('pages.generatepdf.surat_usulan_kegiatan', [
            'usulankegiatans' => $usulankegiatans,
            'jadwalpelaksanaan_kegiatan' => $jadwalpelaksanaan_kegiatan,
            'jadwalMerge' => $jadwalMerge,
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
        $folder = 'generated/usulan';
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
            $cetak = $usulankegiatans
                ->inputusulankegiatans
                ->cetakusulankegiatans()
                ->create([
                    'filepdfgenerate_path' => $path,
                ]);
        }

        return redirect()
            ->route('admin.usulankegiatan.index')
            ->with('success', 'Usulan berhasil dicetak.');
    }
}
