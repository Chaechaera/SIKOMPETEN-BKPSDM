<?php

namespace App\Izin\Http\Controllers\Superadmin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Laporanpesertakegiatans;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class ValidasiLaporanPesertaKegiatansController extends Controller
{
    /**
     * Tampilkan List Laporan Peserta
     */
    public function index()
    {
        // Ambil request search dan status
        $search = request('search');
        $status = request('statuslaporan_pesertakegiatan');

        // Eager Load relasi dan filter berdasarkan search dan status
        $laporans = Izin_Laporanpesertakegiatans::with([
            'users',
            'sertifikats',
            'pesertakegiatans'
        ])->orderBy('created_at', 'desc')
            ->get()
            ->filter(function ($row) use ($search, $status) {

                $matchSearch = true;
                $matchStatus  = true;

                if ($search) {
                    $matchSearch =
                        str_contains(strtolower($row->pesertakegiatans->nama_peserta ?? ''), strtolower($search)) ||
                        str_contains(strtolower($row->sertifikats->laporankegiatans->inputlaporankegiatans->inputusulankegiatans->nama_kegiatan ?? ''), strtolower($search));
                }

                if ($status) {
                    $matchStatus = $row->statuslaporan_pesertakegiatan === $status;
                }

                return $matchSearch && $matchStatus;
            });

        // pagination manual karena sudah pakai collection
        $laporans = $laporans->values();

        $page = request()->get('page', 1);
        $perPage = 20;

        $laporans = new LengthAwarePaginator(
            $laporans->forPage($page, $perPage),
            $laporans->count(),
            $perPage,
            $page,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );

        return view('pages.laporanpesertakegiatan.validasi_laporan_peserta', compact('laporans', 'search', 'status'));
    }

    /**
     * Approve Laporan Peserta Kegiatan
     */
    public function approve(Request $request, $id)
    {
        $laporan = Izin_Laporanpesertakegiatans::findOrFail($id);

        $laporan->update([
            'statuslaporan_pesertakegiatan' => 'approved',
            'catatanlaporan_pesertakegiatan' => $request->catatanlaporan_pesertakegiatan

        ]);

        return back()->with('success', 'Laporan berhasil disetujui.');
    }

    /**
     * Reject Laporan Peserta Kegiatan
     */
    public function reject(Request $request, $id)
    {
        $laporan = Izin_Laporanpesertakegiatans::findOrFail($id);

        $laporan->update([
            'statuslaporan_pesertakegiatan' => 'rejected',
            'catatanlaporan_pesertakegiatan' => $request->catatanlaporan_pesertakegiatan
        ]);

        return back()->with('success', 'Laporan berhasil ditolak.');
    }
}
