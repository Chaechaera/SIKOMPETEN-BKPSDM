<?php

namespace App\Izin\Http\Controllers\Admin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Pelaksanaankegiatans;
use App\Izin\Models\Izin_Usulankegiatans;
use Illuminate\Http\Request;

class PelaksanaanKegiatansController extends Controller
{
    /**
     * Tampilkan Form Pelaksanaan Kegiatan 
     */
    public function create($id)
    {
        $usulankegiatans = Izin_Usulankegiatans::findOrFail($id);
        return view('pages.pelaksanaankegiatan.upload_pelaksanaan_kegiatan', compact('usulankegiatans'));
    }

    /**
     * Simpan Data Pelaksanaan Kegiatan
     */
    public function store(Request $request)
    {
        // Validasi file terlebih dahulu
        $request->validate([
            'buktipelaksanaan_kegiatan.*' => 'required|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Ambil id usulan dari route
        $usulankegiatan_id = $request->route('id');

        // Simpan semua file ke array
        $path_buktipelaksanaan = [];

        // Cek apakah ada file diunggah
        if ($request->hasFile('buktipelaksanaan_kegiatan')) {
            foreach ($request->file('buktipelaksanaan_kegiatan') as $file_buktipelaksanaan_kegiatan) {

                // Simpan setiap file ke folder public storage
                //$path_buktipelaksanaan[] = $file_buktipelaksanaan_kegiatan->store('izin/buktipelaksanaan_kegiatan', 'public');
                $path_buktipelaksanaan[] = $file_buktipelaksanaan_kegiatan->storeAs(
                    'izin/buktipelaksanaan_kegiatan',
                    time() . '_' . uniqid() . '_' . $file_buktipelaksanaan_kegiatan->getClientOriginalName(),
                    'public'
                );
            }

            // Simpan ke tabel
            Izin_Pelaksanaankegiatans::create([
                'usulankegiatan_id' => $usulankegiatan_id,
                'buktipelaksanaan_kegiatan' => json_encode($path_buktipelaksanaan),
            ]);

            // Update Status Usulan Kegiatan ke Database
            /*Izin_Usulankegiatans::where('id', $usulankegiatan_id)
                ->update(['statususulan_kegiatan' => 'in_progress']);*/

            return redirect()
                ->route('admin.usulankegiatan.index')
                ->with('success', 'Bukti Pelaksanaan Kegiatan Berhasil Diunggah!');
        }
    }

    /**
     * Tampilkan Bukti Pelaksanaan Kegiatan
     */
    public function show($id)
    {
        $pelaksanaankegiatans = Izin_Pelaksanaankegiatans::where('usulankegiatan_id', $id)->first();

        if (!$pelaksanaankegiatans) {
            return redirect()->back()->with('error', 'Data pelaksanaan kegiatan belum tersedia.');
        }

        // Decode JSON dari kolom buktipelaksanaan_kegiatan
        $buktipelaksanaan_kegiatanFiles = json_decode($pelaksanaankegiatans->buktipelaksanaan_kegiatan, true) ?? [];

        $usulankegiatans = Izin_Usulankegiatans::find($id);

        return view('pages.pelaksanaankegiatan.view_pelaksanaan_kegiatan', [
            'usulankegiatans' => $usulankegiatans,
            'buktipelaksanaan_kegiatanFiles' => $buktipelaksanaan_kegiatanFiles,
        ]);

        //return view('pages.pelaksanaankegiatan.view_pelaksanaan_kegiatan', compact('pelaksanaankegiatans', 'usulankegiatans', 'buktipelaksanaan_kegiatanFiles'));
    }
}
