<?php

namespace App\Izin\Http\Controllers\Admin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Pelaksanaankegiatans;
use App\Izin\Models\Izin_Usulankegiatans;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PelaksanaanKegiatansController extends Controller
{
    /**
     * Form Upload
     */
    public function create($id)
    {
        $usulankegiatans = Izin_Usulankegiatans::findOrFail($id);

        return view('pages.pelaksanaankegiatan.upload_pelaksanaan_kegiatan', compact('usulankegiatans'));
    }

    /**
     * Simpan Multi Upload
     */
    public function store(Request $request)
    {
        // ✅ VALIDASI (FIXED)
        $request->validate([
            'buktipelaksanaan_kegiatan' => 'required|array|max:5',
            'buktipelaksanaan_kegiatan.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Ambil ID dari route
        $usulankegiatan = Izin_Usulankegiatans::with('inputusulankegiatans')
            ->findOrFail($request->route('id'));

        $inputusulankegiatan_id = $usulankegiatan->inputusulankegiatans->id;

        $path_buktipelaksanaan = [];

        // ✅ HANDLE MULTI FILE
        if ($request->hasFile('buktipelaksanaan_kegiatan')) {

            foreach ($request->file('buktipelaksanaan_kegiatan') as $file) {

                $namaFile = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();

                $path = $file->storeAs(
                    'izin/buktipelaksanaan_kegiatan',
                    $namaFile,
                    'public'
                );

                $path_buktipelaksanaan[] = $path;
            }

            // ✅ SIMPAN KE DB (JSON)
            Izin_Pelaksanaankegiatans::create([
                'inputusulankegiatan_id' => $inputusulankegiatan_id,
                'buktipelaksanaan_kegiatan' => json_encode($path_buktipelaksanaan),
            ]);

            return redirect()
                ->route('admin.usulankegiatan.index')
                ->with('success', 'Bukti Pelaksanaan Kegiatan berhasil diunggah!');
        }

        // ❗ fallback kalau tidak ada file
        return back()->with('error', 'Tidak ada file yang diupload.');
    }

    /**
     * Tampilkan Data
     */
    public function show(Request $request, $id)
    {
        $usulankegiatan = Izin_Usulankegiatans::with('inputusulankegiatans.pelaksanaankegiatans')
            ->findOrFail($id);

        $pelaksanaankegiatans = $usulankegiatan->inputusulankegiatans?->pelaksanaankegiatans;

        if (!$pelaksanaankegiatans) {
            return redirect()->back()->with('error', 'Data belum tersedia.');
        }

        // ✅ Decode JSON
        $files = json_decode($pelaksanaankegiatans->buktipelaksanaan_kegiatan, true) ?? [];

        // ✅ PAGINATION ARRAY
        $perPage = 8;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $collection = collect($files);

        $paginatedFiles = new LengthAwarePaginator(
            $collection->slice(($currentPage - 1) * $perPage, $perPage)->values(),
            $collection->count(),
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query()
            ]
        );

        return view('pages.pelaksanaankegiatan.view_pelaksanaan_kegiatan', [
            'usulankegiatans' => $usulankegiatan,
            'buktipelaksanaan_kegiatanFiles' => $paginatedFiles,
        ]);
    }
}