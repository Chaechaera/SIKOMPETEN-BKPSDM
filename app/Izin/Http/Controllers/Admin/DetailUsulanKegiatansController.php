<?php

namespace App\Izin\Http\Controllers\Admin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Detailusulankegiatans;
use App\Izin\Models\Izin_Inputusulankegiatans;
use App\Izin\Models\Izin_Narasumberkegiatans;
use App\Izin\Models\Izin_RefMetodepelatihans;
use App\Izin\Models\Izin_Usulankegiatans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DetailUsulanKegiatansController extends Controller
{
    /**
     * Tampilkan Form Lengkapi Pengajuan Usulan Kegiatan Pengembangan Kompetensi ASN
     */
    public function create($usulankegiatan_id)
    {
        // Temukan usulankegiatan berdasarkan id
        $usulankegiatans = Izin_Usulankegiatans::findOrFail($usulankegiatan_id);

        // Redirect ke halaman ajukan pengajuan usulan kegiatan
        return view('pages.usulankegiatan.ajukan_usulan_kegiatan', [
            'usulankegiatans' => $usulankegiatans,
            'metodepelatihans' => Izin_RefMetodepelatihans::select('id', 'metode_pelatihan')->get(),
        ]);
    }

    /**
     * Simpan Data Tambahan Pada Form Lengkapi Pengajuan Usulan Kegiatan Pengembangan Kompetensi ASN
     */
    public function store(Request $request)
    {
        // Ambil detailusulankegiatan lama berdasarkan id usulankegiatan
        $detail = Izin_Detailusulankegiatans::where('usulankegiatan_id', $request->usulankegiatan_id)->first();

        // Validasi request
        $request->validate([
            'usulankegiatan_id' => 'required|exists:izin_usulankegiatans,id',
            'jeniskop_usulankegiatan' => 'required|in:kop_text,kop_gambar',
            'kopunitkerja_id' => 'nullable|exists:izin_kopunitkerjas,id',
            'jadwalpelaksanaan_kegiatan' => 'nullable|file|mimes:xls,xlsx|max:5120'
        ]);

        // Update data pada inputusulankegiatan
        Izin_Inputusulankegiatans::updateOrCreate(
            [
                'usulankegiatan_id' => $request->usulankegiatan_id
            ],
            [
                'kopunitkerja_id' => $request->kopunitkerja_id
            ]
        );

        // Request data detailusulankegiatan
        $detailusulankegiatans = $request->only([
            'usulankegiatan_id',
            'jeniskop_usulankegiatan',
            'latarbelakang_kegiatan',
            'dasarhukum_kegiatan',
            'uraian_kegiatan',
            'maksud_kegiatan',
            'tujuan_kegiatan',
            'hasillangsung_kegiatan',
            'hasilmenengah_kegiatan',
            'hasilpanjang_kegiatan',
            'narasumber_kegiatan',
            'sasaranpeserta_kegiatan',
            'alokasianggaran_kegiatan',
            'detailhasil_kegiatan',
            'penyelenggara_kegiatan',
            'penutup_kegiatan',
            'metodepelatihan_id'
        ]);

        // Upload file jadwal pelaksanaan kegiatan
        if ($request->hasFile('jadwalpelaksanaan_kegiatan')) {
            if ($detail && $detail->jadwalpelaksanaan_kegiatan && Storage::disk('public')->exists($detail->jadwalpelaksanaan_kegiatan)) {
                Storage::disk('public')->delete($detail->jadwalpelaksanaan_kegiatan);
            }
            $detailusulankegiatans['jadwalpelaksanaan_kegiatan'] = $request->file('jadwalpelaksanaan_kegiatan')
                ->storeAs(
                    'izin/jadwalpelaksanaan_kegiatan',
                    time() . '_' . $request->file('jadwalpelaksanaan_kegiatan')->getClientOriginalName(),
                    'public'
                );
        }

        // Simpan dan update data detailusulankegiatan
        Izin_Detailusulankegiatans::updateOrCreate(
            ['usulankegiatan_id' => $request->usulankegiatan_id],
            $detailusulankegiatans
        );

        // Simpan data narasumber kegiatan secara terpisah
        $this->simpanNarasumber($request->usulankegiatan_id, $request->narasumber_kegiatan);

        // Redirect ke halaman dashboard admin
        return redirect()->route('admin.dashboard')
            ->with('success', 'Usulan Kegiatan Berhasil Disimpan Secara Lengkap!');
    }

    /**
     * Helper Untuk Simpan Data Narasumber Kegiatan Secara Terpisah
     */
    private function simpanNarasumber($usulankegiatan_id, $text_narasumber)
    {
        // Validasi jika tidak ada data narasumber
        if (!$text_narasumber) return;

        // Hapus data lama
        Izin_Narasumberkegiatans::where('inputusulankegiatan_id', $usulankegiatan_id)->delete();

        // Pecah per baris
        $lines = preg_split('/\r\n|\r|\n/', $text_narasumber);
        foreach ($lines as $line) {

            // Bersihkan nomor list
            $line = preg_replace('/^\d+\.\s*/', '', trim($line));
            if (!$line) continue;
            $nama_narasumber = '';
            $jabatan_narasumber = '';

            // Format: Nama jabatan Jabatan
            if (preg_match('/(.+?)\s+jabatan\s+(.+)/i', $line, $match)) {

                $nama_narasumber = trim($match[1]);
                $jabatan_narasumber = trim($match[2]);
            }

            // Format: Nama - Jabatan
            elseif (strpos($line, '-') !== false) {

                [$nama_narasumber, $jabatan_narasumber] = explode('-', $line, 2);
                $nama_narasumber = trim($nama_narasumber);
                $jabatan_narasumber = trim($jabatan_narasumber);
            }

            // Format: Nama : Jabatan
            elseif (strpos($line, ':') !== false) {

                [$nama_narasumber, $jabatan_narasumber] = explode(':', $line, 2);
                $nama_narasumber = trim($nama_narasumber);
                $jabatan_narasumber = trim($jabatan_narasumber);
            }

            // Format: Nama (Jabatan)
            elseif (preg_match('/(.+?)\((.+)\)/', $line, $match)) {

                $nama_narasumber = trim($match[1]);
                $jabatan_narasumber = trim($match[2]);
            }

            // Fallback
            else {

                $nama_narasumber = trim($line);
                $jabatan_narasumber = null;
            }

            // Simpan data narasumber kegiatan
            if ($nama_narasumber) {
                Izin_Narasumberkegiatans::create([
                    'inputusulankegiatan_id' => $usulankegiatan_id,
                    'nama_narasumber' => $nama_narasumber,
                    'jabatan_narasumber' => $jabatan_narasumber,
                ]);
            }
        }
    }
}
