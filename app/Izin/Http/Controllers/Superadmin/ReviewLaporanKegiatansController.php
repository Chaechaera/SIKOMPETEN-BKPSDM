<?php

namespace App\Izin\Http\Controllers\Superadmin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Http\Controllers\User\SertifikatsController;
use App\Izin\Models\Izin_Laporankegiatans;
use App\Izin\Models\Izin_Sertifikats;
use App\Izin\Models\Izin_Usulankegiatans;
use App\Izin\Models\Izin_Verifikasilaporankegiatans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewLaporanKegiatansController extends Controller
{
    /**
     * Tampilkan Daftar Usulan Kegiatan yang Perlu Direview
     */
    public function pendingList(Request $request)
{
    $query = Izin_Usulankegiatans::with([
        'inputusulankegiatans',
        'inputlaporankegiatans',
        'inputlaporankegiatans.laporankegiatans.verifikasilaporankegiatanterakhir',
        'inputlaporankegiatans.laporankegiatans.cetaklaporankegiatans',
        'subunitkerjas'
    ])
    ->whereHas(
    'inputlaporankegiatans.laporankegiatans',
    function ($q) {
        $q->where('is_archived', 0);
    }
)

    ->leftJoin('izin_inputlaporankegiatans', 'izin_inputlaporankegiatans.inputusulankegiatan_id', '=', 'izin_usulankegiatans.id')
    ->leftJoin('izin_laporankegiatans', 'izin_laporankegiatans.id', '=', 'izin_inputlaporankegiatans.laporankegiatan_id')

    ->select('izin_usulankegiatans.*');

    // 🔥 SORTING (default terbaru)
    $sort = $request->get('sort', 'desc');

    $query->orderByRaw("
        izin_laporankegiatans.tanggalmulai_kegiatan IS NULL,
        izin_laporankegiatans.tanggalmulai_kegiatan {$sort}
    ");

    // 🔥 FILTER SEARCH (PINDAH KE ATAS)
    if ($request->filled('search')) {
    $search = $request->search;

    $query->where(function ($q) use ($search) {

        // 🔍 Nama kegiatan (BENAR)
        $q->whereHas('inputusulankegiatans', function ($q1) use ($search) {
            $q1->where('nama_kegiatan', 'like', "%{$search}%");
        })

        // 🔍 OPD
        ->orWhereHas('subunitkerjas', function ($q2) use ($search) {
            $q2->where('sub_unitkerja', 'like', "%{$search}%")
               ->orWhere('singkatan', 'like', "%{$search}%");
        })

        // 🔍 Nomor surat (PINDAH KE RELASI YANG BENAR)
        ->orWhereHas('inputlaporankegiatans.kirimlaporankegiatans.identitassurats', function ($q3) use ($search) {
            $q3->where('nomor_surat', 'like', "%{$search}%");
        })

        //  🔍 TANGGAL PELAKSANAAN 
        ->orWhereHas('inputlaporankegiatans.laporankegiatans', function ($q4) use ($search) {
            $q4->where('tanggalmulai_kegiatan', 'like', "%{$search}%")
               ->orWhere('tanggalselesai_kegiatan', 'like', "%{$search}%");
        });

    });
}

    // 🔥 FILTER TAHUN
    if ($request->filled('tahun')) {
        $query->whereHas('inputlaporankegiatans.laporankegiatans', function ($q) use ($request) {
            $q->whereYear('tanggalmulai_kegiatan', $request->tahun);
        });
    }

    // 🔥 BARU AMBIL DATA
    $data = $query->get();

    // 🔥 FILTER STATUS (UI ACCESSOR)
    if ($request->filled('status')) {
        $status = $request->status;

        $data = $data->filter(function ($item) use ($status) {
            return optional($item->inputlaporankegiatans?->laporankegiatans)->status_laporan_ui === $status;
        });
    }

    // 🔥 PAGINATION
    $perPage = 20;
    $currentPage = request()->get('page', 1);

    $usulankegiatans = new \Illuminate\Pagination\LengthAwarePaginator(
        $data->forPage($currentPage, $perPage),
        $data->count(),
        $perPage,
        $currentPage,
        ['path' => request()->url(), 'query' => request()->query()]
    );

    return view('pages.laporankegiatan.pending_list_laporan_kegiatan', compact('usulankegiatans'));
}

/**
     * ARCHIVE
     */

public function archive($id)
{
    $laporan = Izin_Laporankegiatans::findOrFail($id);

    $laporan->update([
        'is_archived' => 1
    ]);

    return back()->with(
        'success',
        'Laporan berhasil diarsipkan'
    );
}
public function unarchive($id)
{
    $laporan = Izin_Laporankegiatans::findOrFail($id);

    $laporan->update([
        'is_archived' => 0
    ]);

    return back()->with(
        'success',
        'Laporan berhasil dipulihkan'
    );
}
public function archivePage(Request $request)
{
    $query = Izin_Usulankegiatans::with([
        'inputusulankegiatans',
        'inputlaporankegiatans',
        'inputlaporankegiatans.laporankegiatans',
        'subunitkerjas'
    ])
    ->whereHas('inputlaporankegiatans.laporankegiatans', function ($q) {
        $q->where('is_archived', 1);
    });

    // SEARCH
    if ($request->filled('search')) {

        $search = $request->search;

        $query->where(function ($q) use ($search) {

            $q->whereHas('inputusulankegiatans', function ($q2) use ($search) {
                $q2->where('nama_kegiatan', 'like', "%{$search}%");
            })

            ->orWhereHas('subunitkerjas', function ($q2) use ($search) {
                $q2->where('singkatan', 'like', "%{$search}%");
            })

             // Nomor Sertifikat & Tanggal Keluar Sertifikat
        ->orWhereHas(
            'inputlaporankegiatans.laporankegiatans.sertifikats',
            function ($q2) use ($search) {

                $q2->where('nomorsertifikat_kegiatan', 'like', "%{$search}%")
                   ->orWhere('tanggalkeluarsertifikat_kegiatan', 'like', "%{$search}%");
            }
        );
        });
    }

    // FILTER TAHUN BERDASARKAN TANGGAL KELUAR SERTIFIKAT
if ($request->filled('tahun')) {

    $query->whereHas(
        'inputlaporankegiatans.laporankegiatans.sertifikats',
        function ($q) use ($request) {

            $q->whereYear(
                'tanggalkeluarsertifikat_kegiatan',
                $request->tahun
            );
        }
    );
}

// SORT BERDASARKAN TANGGAL KELUAR SERTIFIKAT
$sort = $request->get('sort', 'desc');

$query->leftJoin(
    'izin_inputlaporankegiatans',
    'izin_inputlaporankegiatans.inputusulankegiatan_id',
    '=',
    'izin_usulankegiatans.id'
)
->leftJoin(
    'izin_laporankegiatans',
    'izin_laporankegiatans.id',
    '=',
    'izin_inputlaporankegiatans.laporankegiatan_id'
)
->leftJoin(
    'izin_sertifikats',
    'izin_sertifikats.laporankegiatan_id',
    '=',
    'izin_laporankegiatans.id'
)
->select('izin_usulankegiatans.*')
->orderBy(
    'izin_sertifikats.tanggalkeluarsertifikat_kegiatan',
    $sort
);
    $usulankegiatans = $query->paginate(20)
        ->withQueryString();

    return view(
        'pages.balasanlaporankegiatan.arsip_balasan_laporan',
        compact('usulankegiatans')
    );
}

    /**
     * Tampilkan Form Review Laporan Hasil Kegiatan
     */
    public function reviewForm($id)
    {
        // Eager load relasi dari model dan temukan laporan kegiatan berdasarkan id
        $laporankegiatans = Izin_Laporankegiatans::with([
            'detaillaporankegiatans',
            'inputlaporankegiatans',
            'inputlaporankegiatans.inputusulankegiatans',
            'inputlaporankegiatans.inputusulankegiatans.usulankegiatans',
        ])->findOrFail($id);

        // Redirect ke halaman review laporan kegiatan
        return view('pages.laporankegiatan.review_laporan_kegiatan', compact('laporankegiatans'));
    }

    /**
     * Simpan Hasil Review Laporan Hasil Kegiatan
     */
    public function reviewUpload(Request $request, $id)
    {
        // Ambil data laporan kegiatan
        $laporankegiatans = Izin_Laporankegiatans::findOrFail($id);

        // Validasi request
        $request->validate([
            'actionlaporan_kegiatan' => 'required|in:accepted,rejected',
            'catatan_verifikasilaporankegiatan' => 'nullable|string|max:2000',
        ]);

        // Transaksi DB berlangsung
        DB::transaction(function () use ($request, $id) {

            // Ambil data laporan kegiatan berdasarkan id
            $laporankegiatans = Izin_Laporankegiatans::findOrFail($id);

            // Update status laporan kegiatan jika itu "Rejected"
            if ($request->actionlaporan_kegiatan === 'rejected') {
                $laporankegiatans->update([
                    'statuslaporan_kegiatan' => 'revisi',
                ]);
            }

            // Simpan data verifikasi laporan hasil kegiatan
            Izin_Verifikasilaporankegiatans::create([
                'laporankegiatan_id' => $laporankegiatans->id,
                'tanggalverifikasi_inputlaporankegiatan' => now(),
                'nipadmin_verifikasilaporankegiatan' => Auth::user()->nip,
                'status_verifikasilaporankegiatan' => $request->actionlaporan_kegiatan,
                'catatan_verifikasilaporankegiatan' => $request->catatan_verifikasilaporankegiatan,
                'is_read' => false,
            ]);
        });

        // Generate sertifikat otomatis jika itu "Accepted"
        if ($request->actionlaporan_kegiatan === 'accepted') {
            $sertifikatController = new SertifikatsController();
            $sertifikats = $sertifikatController->create(new Request([
                'laporankegiatan_id' => $laporankegiatans->id,
            ]));

            // Ambil sertifikat berdasarkan id laporan kegiatan
            $sertifikat = Izin_Sertifikats::where('laporankegiatan_id', $id)->first();

            // Redirect ke halaman buat balasan laporan hasil kegiatan
            return redirect()
                ->route('superadmin.balasanlaporankegiatan.create', ['id' => $id])
                ->with([
                    'success' => "Usulan kegiatan telah berhasil di{$request->actionlaporan_kegiatan} dan catatan telah dikirim ke admin.",
                    'sertifikat_id' => optional($sertifikat)->id
                ]);
        }

        // Redirect ke halaman daftar usulan kegiatan yang perlu di review jika itu "Rejected"
        return redirect()
            ->route('superadmin.usulankegiatan.pending')
            ->with('success', "Usulan kegiatan telah berhasil di{$request->actionlaporan_kegiatan}.");
    }

}
