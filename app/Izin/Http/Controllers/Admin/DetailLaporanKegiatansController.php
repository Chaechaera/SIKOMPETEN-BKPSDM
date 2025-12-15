<?php

namespace App\Izin\Http\Controllers\Admin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Detaillaporankegiatans;
use App\Izin\Models\Izin_Laporankegiatans;
use App\Izin\Models\Izin_Pesertakegiatans;
use App\Izin\Models\Izin_RefSubunitkerjas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DetailLaporanKegiatansController extends Controller
{
    /**
     * Tampilkan Form Bagian Detail Usulan Kegiatan Pada Form Ajukan Usulan Kegiatan
     */
    public function create($laporankegiatan_id)
    {
        $laporankegiatans = Izin_Laporankegiatans::findOrFail($laporankegiatan_id);

        return view('pages.laporankegiatan.ajukan_laporan_kegiatan', [
            'laporankegiatans' => $laporankegiatans,
            //'metodepelatihans' => Izin_RefMetodepelatihans::select('id', 'metode_pelatihan')->get(),
        ]);
    }

    /**
     * Simpan Data Detail Usulan Kegiatan
     */
    public function store(Request $request)
    {
        /*$request->validate([
            'gambardokumentasi_laporan.*' => 'required|mimes:jpg,jpeg,png|max:2048'
        ]);*/

        // Data dasar
        $detaillaporankegiatans = $request->only([
            'laporankegiatan_id',
            'rincian_laporan',
            'undangan_laporan',
            'materi_laporan',
            'daftarhadir_laporan',
            'dokumentasi_laporan',
            'gambardokumentasi_laporan',
            'outputkegiatan_laporan',
            'templatesertifikat_kegiatan',
        ]);

        // -----------------------------
        // UPLOAD RUNDOWN FILE
        // -----------------------------

        if ($request->hasFile('rundown_laporan')) {
            $detaillaporankegiatans['rundown_laporan'] = $request->file('rundown_laporan')->store('izin/rundown_laporan', 'public');
        }

        // -----------------------------
        // UPLOAD TEMPLATE SERTIFIKAT
        // -----------------------------

        if ($request->hasFile('templatesertifikat_kegiatan')) {
            $detaillaporankegiatans['templatesertifikat_kegiatan'] = $request->file('templatesertifikat_kegiatan')->store('izin/template_sertifikat', 'public');
        }

        // -----------------------------
        // UPLOAD PESERTA EXCEL
        // -----------------------------
        $path_peserta_laporan = [];
        if ($request->hasFile('peserta_laporan')) {
            $detaillaporankegiatans['peserta_laporan'] = $request->file('peserta_laporan')->store('izin/peserta_laporan', 'public');

            $spreadsheet = IOFactory::load(Storage::disk('public')->path($detaillaporankegiatans['peserta_laporan']));
            $sheet = $spreadsheet->getActiveSheet();

            foreach ($sheet->toArray(null, true, true, true) as $row) {
                $path_peserta_laporan[] = array_values($row);
            }
        }

        // -----------------------------
        // GAMBAR DOKUMENTASI (MULTIPLE)
        // -----------------------------
        $path_gambardokumentasi = [];

        if ($request->hasFile('gambardokumentasi_laporan')) {
            foreach ($request->file('gambardokumentasi_laporan') as $file) {
                $path_gambardokumentasi[] = $file->store('izin/gambar_laporan', 'public');
            }
        }

        // -----------------------------
        // INSERT DETAIL LAPORAN
        // -----------------------------

        $detaillaporan = Izin_Detaillaporankegiatans::create(array_merge(
            $detaillaporankegiatans,
            [
                'gambardokumentasi_laporan' => json_encode($path_gambardokumentasi),
            ]
        ));

        // ==============================================
        // AMBIL DATA SUBUNIT KERJA UNTUK MAPPING
        // ==============================================
        $subunitkerja = Izin_RefSubunitkerjas::pluck('id', 'sub_unitkerja')->toArray();
        $subunitkerja_singkatan = Izin_RefSubunitkerjas::pluck('id', 'singkatan')->toArray();

        // -----------------------------
        // INSERT PESERTA KE TABEL
        // -----------------------------
        if (!empty($path_peserta_laporan)) {

            foreach (array_slice($path_peserta_laporan, 1) as $row) {

                $namaSubunitkerja = trim($row[3] ?? "");

                // CARI ID DARI NAMA
                $subunitkerja_id = $subunitkerja[$namaSubunitkerja] ?? null;

                // CARI ID DARI SINGKATAN
                if (!$subunitkerja_id) {
                    $subunitkerja_id = $subunitkerja_singkatan[$namaSubunitkerja] ?? null;
                }

                // JIKA MASIH NULL → FUZZY MATCHING
                if (!$subunitkerja_id) {

                    $subunitkerja_id = $this->fuzzyMatch(
                        $namaSubunitkerja,
                        array_keys($subunitkerja)
                    );

                    // kalau masih null, coba fuzzy ke singkatan
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
                    'nip_peserta' => $row[1] ?? null,
                    'jabatan_peserta' => $row[2] ?? null,
                    'subunitkerja_id_peserta' => $subunitkerja_id,
                ]);
            }
        }

        return redirect()->route('admin.dashboard')
            ->with('success', 'Usulan Kegiatan Berhasil Disimpan Secara Lengkap!');
    }

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
