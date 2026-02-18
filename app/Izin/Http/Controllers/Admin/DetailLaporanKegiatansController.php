<?php

namespace App\Izin\Http\Controllers\Admin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Detaillaporankegiatans;
use App\Izin\Models\Izin_Laporankegiatans;
use App\Izin\Models\Izin_Pesertakegiatans;
use App\Izin\Models\Izin_RefSubunitkerjas;
use App\Izin\Models\Izin_Sertifikats;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DetailLaporanKegiatansController extends Controller
{
    /**
     * Tampilkan Form Lengkapi Laporan Hasil Kegiatan Pengembangan Kompetensi ASN
     */
    public function create($laporankegiatan_id)
    {
        // Temukan laporankegiatan berdasarkan id
        $laporankegiatans = Izin_Laporankegiatans::findOrFail($laporankegiatan_id);

        // Redirect ke halaman ajukan laporan hasil kegiatan
        return view('pages.laporankegiatan.ajukan_laporan_kegiatan', [
            'laporankegiatans' => $laporankegiatans,
        ]);
    }

    /**
     * Simpan Data Tambahan Pada Form Lengkapi Laporan Hasil Kegiatan Pengembangan Kompetensi ASN
     */
    public function store(Request $request)
    {
        // Validasi request
        $request->validate([
            'laporankegiatan_id' => 'required|exists:izin_laporankegiatans,id',
            'jeniskop_laporankegiatan' => 'required|in:kop_text,kop_gambar',
        ]);

        // Ambil data atribut khusus pada file khusus
        $config = config('atribut_khusus');
        $atributInput = [];

        if (isset($config[$request->carapelatihan_id]['fields'])) {
            foreach ($config[$request->carapelatihan_id]['fields'] as $key => $field) {
                $atributInput[$key] = $request->input($key);
            }
        }

        // Request data detaillaporankegiatan
        $detaillaporankegiatans = $request->only([
            'laporankegiatan_id',
            'jeniskop_laporankegiatan',
            'rincian_laporan',
            'penutup_laporan',
            'linkundangan_laporan',
            'linkmateri_laporan',
            'linkdaftarhadir_laporan',
            'linkdokumentasi_laporan',
        ]);

        // Upload file rundown laporan kegiatan
        if ($request->hasFile('rundown_laporan')) {
            $detaillaporankegiatans['rundown_laporan'] = $request->file('rundown_laporan')->store('izin/rundown_laporan', 'public');
        }

        // Upload template sertifikat kegiatan
        $sertifikats = [
            'laporankegiatan_id' => $request->laporankegiatan_id
        ];

        if ($request->hasFile('templatesertifikat_kegiatan')) {
            $sertifikats['templatesertifikat_kegiatan'] = $request->file('templatesertifikat_kegiatan')->store('izin/template_sertifikat', 'public');
        }

        // Simpan dan update sertifikat
        Izin_Sertifikats::updateOrCreate(
            ['laporankegiatan_id' => $request->laporankegiatan_id],
            $sertifikats
        );

        // Upload file peserta kegiatan
        $path_peserta_laporan = [];
        if ($request->hasFile('peserta_laporan')) {
            $detaillaporankegiatans['peserta_laporan'] = $request->file('peserta_laporan')->store('izin/peserta_laporan', 'public');

            $spreadsheet = IOFactory::load(Storage::disk('public')->path($detaillaporankegiatans['peserta_laporan']));
            $sheet = $spreadsheet->getActiveSheet();

            foreach ($sheet->toArray(null, true, true, true) as $row) {
                $path_peserta_laporan[] = array_values($row);
            }
        }

        // Upload gambar dokumentasi laporan kegiatan
        $path_gambardokumentasi = [];

        if ($request->hasFile('gambardokumentasi_laporan')) {
            foreach ($request->file('gambardokumentasi_laporan') as $file) {
                $path_gambardokumentasi[] = $file->store('izin/gambar_laporan', 'public');
            }
        }

        // Simpan dan update data detaillaporankegiatan
        $detaillaporan = Izin_Detaillaporankegiatans::updateOrCreate(
            ['laporankegiatan_id' => $request->laporankegiatan_id], // key unik
            array_merge(
                $detaillaporankegiatans,
                [
                    'gambardokumentasi_laporan' => $path_gambardokumentasi,
                    'atribut_khusus' => $atributInput,
                ]
            )
        );

        // Ambil data subunitkerja untuk mapping peserta kegiatan
        $subunitkerja = Izin_RefSubunitkerjas::pluck('id', 'sub_unitkerja')->toArray();
        $subunitkerja_singkatan = Izin_RefSubunitkerjas::pluck('id', 'singkatan')->toArray();

        // Simpan data peserta kegiatan
        if (!empty($path_peserta_laporan)) {

            foreach (array_slice($path_peserta_laporan, 1) as $row) {

                $namaSubunitkerja = trim($row[3] ?? "");

                // Cari id dari nama
                $subunitkerja_id = $subunitkerja[$namaSubunitkerja] ?? null;

                // Cari id dari singkatan
                if (!$subunitkerja_id) {
                    $subunitkerja_id = $subunitkerja_singkatan[$namaSubunitkerja] ?? null;
                }

                // Jika null maka lakukan fuzzy matching untuk menemukan kesamaan
                if (!$subunitkerja_id) {

                    // Fuzzy match ke nama
                    $subunitkerja_id = $this->fuzzyMatch(
                        $namaSubunitkerja,
                        array_keys($subunitkerja)
                    );

                    // Fuzzy match ke singkatan jika masih null
                    if (!$subunitkerja_id) {
                        $subunitkerja_id = $this->fuzzyMatch(
                            $namaSubunitkerja,
                            array_keys($subunitkerja_singkatan)
                        );
                    }
                }

                // Jika fuzzy menghasilkan "string", ubah jadi ID
                if ($subunitkerja_id && is_string($subunitkerja_id)) {

                    if (isset($subunit_nama[$subunitkerja_id])) {
                        $subunitkerja_id = $subunitkerja[$subunitkerja_id];
                    } elseif (isset($subunit_singkatan[$subunitkerja_id])) {
                        $subunitkerja_id = $subunitkerja_singkatan[$subunitkerja_id];
                    }
                }

                Izin_Pesertakegiatans::create([
                    'detaillaporankegiatan_id' => $detaillaporan->id,
                    'nama_peserta' => $row[0] ?? '-',
                    'nip_nik_peserta' => $row[1] ?? null,
                    'jabatan_peserta' => $row[2] ?? null,
                    'subunitkerja_id_peserta' => $subunitkerja_id,
                ]);
            }
        }

        // Redirect ke halaman dashboard admin
        return redirect()->route('admin.dashboard')->with('success', 'Usulan Kegiatan Berhasil Disimpan Secara Lengkap!');
    }

    /**
     * Helper Untuk Mencocokan Kesamaan Subunitkerja Peserta Kegiatan
     */
    private function fuzzyMatch($input, $list)
    {
        $input = strtolower(trim($input));
        $best = null;
        $bestScore = 0;

        foreach ($list as $item) {
            similar_text($input, strtolower($item), $percent);

            if ($percent > $bestScore) {
                $bestScore = $percent;
                $best = $item;
            }
        }

        return $bestScore >= 70 ? $best : null; // ambang batas 70%
    }
}
