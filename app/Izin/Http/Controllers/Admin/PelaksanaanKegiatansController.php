<?php

namespace App\Izin\Http\Controllers\Admin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Pelaksanaankegiatans;
use App\Izin\Models\Izin_Usulankegiatans;
use Illuminate\Http\Request;

class PelaksanaanKegiatansController extends Controller
{
    /**
     * Tampilkan Form Upload Bukti Pelaksanaan Kegiatan Pengembangan Kompetensi ASN
     */
    public function create($id)
    {
        // Temukan usulankegiatan berdasarkan id
        $usulankegiatans = Izin_Usulankegiatans::findOrFail($id);

        // Redirect ke halaman upload pelaksanaan kegiatan
        return view('pages.pelaksanaankegiatan.upload_pelaksanaan_kegiatan', compact('usulankegiatans'));
    }

    /**
     * Simpan Data Upload Bukti Pelaksanaan Kegiatan Pengembangan Kompetensi ASN
     */
    public function store(Request $request)
    {
        // Validasi request
        $request->validate([
            'buktipelaksanaan_kegiatan.*' => 'required|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Ambil usulankegiatan dari id route
        $usulankegiatan = Izin_Usulankegiatans::with('inputusulankegiatans')->findOrFail($request->route('id'));
        $inputusulankegiatan_id = $usulankegiatan->inputusulankegiatans->id;

        // Simpan semua file ke array
        $path_buktipelaksanaan = [];

        // Cek apakah terdapat file bukti yang diunggah
        if ($request->hasFile('buktipelaksanaan_kegiatan')) {
            foreach ($request->file('buktipelaksanaan_kegiatan') as $file_buktipelaksanaan_kegiatan) {
                $path_buktipelaksanaan[] = $file_buktipelaksanaan_kegiatan->storeAs(
                    'izin/buktipelaksanaan_kegiatan',
                    time() . '_' . uniqid() . '_' . $file_buktipelaksanaan_kegiatan->getClientOriginalName(),
                    'public'
                );
            }

            // Simpan data pelaksanaankegiatan
            Izin_Pelaksanaankegiatans::create([
                'inputusulankegiatan_id' => $inputusulankegiatan_id,
                'buktipelaksanaan_kegiatan' => json_encode($path_buktipelaksanaan),
            ]);

            // Redirect ke halaman daftar usulankegiatan yang diajukan
            return redirect()->route('admin.usulankegiatan.index')->with('success', 'Bukti Pelaksanaan Kegiatan Berhasil Diunggah!');
        }
    }

    /**
     * Tampilkan Bukti Pelaksanaan Kegiatan Pengembangan Kompetensi ASN
     */
    public function show($id)
    {
        // Temukan usulankegiatan berdasarkan id
        $usulankegiatan = Izin_Usulankegiatans::with('inputusulankegiatans.pelaksanaankegiatans')->findOrFail($id);

        // Ambil data pelaksanaankegiatan pada database
        $pelaksanaankegiatans = $usulankegiatan->inputusulankegiatans?->pelaksanaankegiatans;
        if (!$pelaksanaankegiatans) {
            return redirect()->back()->with('error', 'Data pelaksanaan kegiatan belum tersedia.');
        }

        // Decode JSON dari kolom buktipelaksanaan_kegiatan
        $buktipelaksanaan_kegiatanFiles = json_decode($pelaksanaankegiatans->buktipelaksanaan_kegiatan, true) ?? [];

        // Redirect ke halaman lihat preview gambar bukti pelaksanaan kegiatan
        return view('pages.pelaksanaankegiatan.view_pelaksanaan_kegiatan', ['usulankegiatans' => $usulankegiatan, 'buktipelaksanaan_kegiatanFiles' => $buktipelaksanaan_kegiatanFiles,]);
    }
}
