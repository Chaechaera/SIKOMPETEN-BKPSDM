<?php

namespace App\Izin\Http\Controllers\Admin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Detaillaporankegiatans;
use App\Izin\Models\Izin_Inputlaporankegiatans;
use App\Izin\Models\Izin_Kopunitkerjas;
use App\Izin\Models\Izin_Laporankegiatans;
use App\Izin\Models\Izin_RefCarapelatihans;
use App\Izin\Models\Izin_RefMetodepelatihans;
use App\Izin\Models\Izin_Stempelunitkerjas;
use App\Izin\Models\Izin_Ttdunitkerjas;
use App\Izin\Models\Izin_Usulankegiatans;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Facades\Storage;

class LaporanKegiatansController extends Controller
{
    /**
     * Tampilkan Daftar Usulan Kegiatan yang Telah Diajukan
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $activeRole = session('active_role', $user->role);

        $query = Izin_Usulankegiatans::with([
            'inputusulankegiatans',
            'inputusulankegiatans.pelaksanaankegiatans',
            'inputlaporankegiatans.laporankegiatans',
            'inputlaporankegiatans.laporankegiatans.verifikasilaporankegiatanterakhir',
            'inputlaporankegiatans.laporankegiatans.sertifikats',
            'inputlaporankegiatans.laporankegiatans.balasanlaporankegiatans',
        ])
            ->whereHas('inputusulankegiatans.pelaksanaankegiatans')
            ->whereHas('inputlaporankegiatans.laporankegiatans')

            // JOIN untuk sorting
            ->leftJoin('izin_inputlaporankegiatans', 'izin_inputlaporankegiatans.inputusulankegiatan_id', '=', 'izin_usulankegiatans.id')
            ->leftJoin('izin_laporankegiatans', 'izin_laporankegiatans.id', '=', 'izin_inputlaporankegiatans.laporankegiatan_id')

            ->select('izin_usulankegiatans.*');

        // 🔥 SORTING (default terbaru)
        $sort = $request->get('sort', 'desc');

        $query->orderByRaw("
        izin_laporankegiatans.tanggalmulai_kegiatan IS NULL,
        izin_laporankegiatans.tanggalmulai_kegiatan {$sort}
    ");

        // 🔍 SEARCH
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {

                // Nama kegiatan
                $q->whereHas('inputusulankegiatans', function ($q1) use ($search) {
                    $q1->where('nama_kegiatan', 'like', "%{$search}%");
                })

                    // Tanggal kegiatan
                    ->orWhereHas('inputlaporankegiatans.laporankegiatans', function ($q2) use ($search) {
                        $q2->where('tanggalmulai_kegiatan', 'like', "%{$search}%")
                            ->orWhere('tanggalselesai_kegiatan', 'like', "%{$search}%");
                    });
            });
        }

        // 🔐 FILTER ROLE
        /*if ($user->role == 'admin') {
            $query->where('izin_usulankegiatans.subunitkerja_id', $user->subunitkerja_id);
        }

        if ($user->role == 'user') {
            $query->where('izin_usulankegiatans.dibuat_oleh', $user->id);
        }*/

        // FILTER ROLE
        if ($activeRole == 'admin') {
            $query->where('izin_usulankegiatans.subunitkerja_id', $user->subunitkerja_id);
        }

        if ($activeRole == 'user') {
            $query->where('izin_usulankegiatans.dibuat_oleh', $user->id);
        }

        // 🔥 FILTER TAHUN
        if ($request->filled('tahun')) {
            $query->whereHas('inputlaporankegiatans.laporankegiatans', function ($q) use ($request) {
                $q->whereYear('tanggalmulai_kegiatan', $request->tahun);
            });
        }

        //ARCHIVE
        $query->whereHas('inputlaporankegiatans.laporankegiatans', function ($q) {
            $q->where('is_archived', 0);
        });

        // 🔥 AMBIL DATA
        $data = $query->get();

        // 🔥 FILTER STATUS (collection)
        if ($request->filled('status')) {
            $status = $request->status;

            $data = $data->filter(function ($item) use ($status) {
                return optional($item->inputlaporankegiatans?->laporankegiatans)->status_laporan_ui === $status;
            });
        }

        // 🔥 PAGINATION MANUAL
        $perPage = 20;
        $currentPage = request()->get('page', 1);

        $usulankegiatans = new \Illuminate\Pagination\LengthAwarePaginator(
            $data->forPage($currentPage, $perPage),
            $data->count(),
            $perPage,
            $currentPage,
            [
                'path' => request()->url(),
                'query' => request()->query()
            ]
        );

        $all = Izin_Laporankegiatans::with([
            'verifikasilaporankegiatanterakhir',
            'sertifikats',
            'balasanlaporankegiatans'
        ])->get();

        /* ================= CARD FIX ================= */

        $activeRole = session('active_role', $user->role);

        $all = Izin_Laporankegiatans::with([
            'verifikasilaporankegiatanterakhir',
            'sertifikats',
            'balasanlaporankegiatans'
        ]);

        // Filter sesuai role aktif
        if ($activeRole == 'admin') {
            $all->whereHas(
                'inputlaporankegiatans.inputusulankegiatans.usulankegiatans',
                function ($q) use ($user) {
                    $q->where('subunitkerja_id', $user->subunitkerja_id);
                }
            );
        }

        if ($activeRole == 'user') {
            $all->whereHas(
                'inputlaporankegiatans.inputusulankegiatans.usulankegiatans',
                function ($q) use ($user) {
                    $q->where('dibuat_oleh', $user->id);
                }
            );
        }

        $all = $all->get();

        $total = $all->count();

        $disetujui = $all->filter(
            fn($item) =>
            $item->status_laporan_ui === 'accepted' ||
                $item->status_laporan_ui === 'finish'
        )->count();

        $menunggu = $all->filter(
            fn($item) =>
            in_array($item->status_laporan_ui, ['need_review'])
        )->count();

        $counts = [
            'pending'     => $all->where('status_laporan_ui', 'pending')->count(),
            'draft'       => $all->where('status_laporan_ui', 'draft')->count(),
            'need_review' => $all->where('status_laporan_ui', 'need_review')->count(),
            'accepted'    => $all->where('status_laporan_ui', 'accepted')->count(),
            'rejected'    => $all->where('status_laporan_ui', 'rejected')->count(),
            'finish'      => $all->where('status_laporan_ui', 'finish')->count(),
        ];
        $colors = [
            'pending'     => 'bg-[#FFE6EB]',
            'draft'   => 'bg-[#E3EEFF]',
            'need_review' => 'bg-[#F2E9FF]',
            'accepted'    => 'bg-[#E6FFF0]',
            'rejected'    => 'bg-[#FFE6E6]',
            'finish'      => 'bg-[#FFF7E6]',
        ];

        /* ================= VIEW ================= */
        return view('pages.laporankegiatan.list_laporan_kegiatan', compact(
            'usulankegiatans',
            'counts',
            'colors'
        ));
    }

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
            'detailusulankegiatans',
            'inputlaporankegiatans',
            'inputlaporankegiatans.laporankegiatans',
        ])->findOrFail($id);

        // Ambil laporan kegiatan
        $laporankegiatans = $usulankegiatans->inputlaporankegiatans?->laporankegiatans;

        // Redirect ke halaman ajukan laporan kegiatan
        return view('pages.laporankegiatan.ajukan_laporan_kegiatan', [
            'unitkerjas' => $user->subunitkerjas?->unitkerjas?->unitkerja,
            'subunitkerjas' => $user->subunitkerjas->sub_unitkerja ?? null,
            'dibuat_oleh' => $user->nama,
            'usulankegiatans' => $usulankegiatans,
            'laporankegiatans' => $laporankegiatans,
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
            'statuslaporan_kegiatan' => 'draft'
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

        // Verifikasi bahwa status laporankegiatan tidak sama dengan draft
        if (!in_array($laporankegiatans->status_laporan_ui, ['draft', 'rejected'])) {
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

        // Verifikasi bahwa status laporankegiatan tidak sama dengan draft
        if (!in_array($laporankegiatans->status_laporan_ui, ['draft', 'rejected'])) {
            abort(403, 'Laporan tidak bisa diedit.');
        }

        // Update data laporankegiatan
        $laporankegiatans->update([
            'lokasi_kegiatan' => $request->lokasi_kegiatan,
            'carapelatihan_id' => $request->carapelatihan_id,
            'tanggalmulai_kegiatan' => $request->tanggalmulai_kegiatan,
            'tanggalselesai_kegiatan' => $request->tanggalselesai_kegiatan,
            'waktumulai_kegiatan' => $request->waktumulai_kegiatan,
            'waktuselesai_kegiatan' => $request->waktuselesai_kegiatan,
            'statuslaporan_kegiatan' => 'draft'
        ]);
        $laporankegiatans->verifikasilaporankegiatans()->delete();

        // Lanjutkan proses store ke controller detaillaporankegiatan
        return app(DetailLaporanKegiatansController::class)->store($request);
    }

    /**
     * Download Laporan Hasil Kegiatan Pengembangan Kompetensi ASN
     */
    public function download($id, Request $request)
    {
        // Eager load relasi dari model dan temukan laporankegiatan berdasarkan id
        $usulan = Izin_Usulankegiatans::with([
        'inputlaporankegiatans.cetaklaporankegiatans',
        'inputlaporankegiatans.inputusulankegiatans',
    ])->findOrFail($id);

    $input = $usulan->inputlaporankegiatans;

    if (!$input) {
        abort(404, 'Input laporan tidak ditemukan.');
    }

    $cetak = $input->cetaklaporankegiatans;

    if (
        !$cetak ||
        !$cetak->filepdfgenerate_path ||
        !Storage::disk('public')->exists($cetak->filepdfgenerate_path)
    ) {
        abort(404, 'PDF belum digenerate.');
    }

    if ($request->boolean('preview')) {
        return response()->file(
            Storage::disk('public')->path($cetak->filepdfgenerate_path)
        );
    }

    return Storage::disk('public')->download(
        $cetak->filepdfgenerate_path,
        'Laporan dan Surat Hasil Pelaksanaan Kegiatan ' .
        $input->inputusulankegiatans->nama_kegiatan .
        '.pdf'
    );    }

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

    public function archivePage(Request $request)
    {
        $user = Auth::user();
        $activeRole = session('active_role', $user->role);

        $query = Izin_Usulankegiatans::with([
            'inputusulankegiatans',
            'inputlaporankegiatans.laporankegiatans.verifikasilaporankegiatanterakhir'
        ])
            ->whereHas('inputlaporankegiatans.laporankegiatans', function ($q) {
                $q->where('is_archived', 1);
            });

        // FILTER ROLE
        if ($activeRole == 'admin') {

            $query->where(
                'izin_usulankegiatans.subunitkerja_id',
                $user->subunitkerja_id
            );
        }

        if ($activeRole == 'user') {

            $query->where(
                'izin_usulankegiatans.dibuat_oleh',
                $user->id
            );
        }

        // 🔎 SEARCH
        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('inputusulankegiatans', function ($q) use ($search) {
                $q->where('nama_kegiatan', 'like', "%$search%");
            });
        }

        // 📅 TAHUN
        if ($request->filled('tahun')) {
            $query->whereHas('inputlaporankegiatans.laporankegiatans', function ($q) use ($request) {
                $q->whereYear('tanggalmulai_kegiatan', $request->tahun);
            });
        }

        // 🔃 SORT (INI YANG KAMU LUPA)
        $sort = $request->get('sort', 'desc');

        $query->join('izin_inputlaporankegiatans', 'izin_inputlaporankegiatans.inputusulankegiatan_id', '=', 'izin_usulankegiatans.id')
            ->join('izin_laporankegiatans', 'izin_laporankegiatans.id', '=', 'izin_inputlaporankegiatans.laporankegiatan_id')
            ->select('izin_usulankegiatans.*')
            ->orderBy('izin_laporankegiatans.tanggalmulai_kegiatan', $sort);

        // 📦 PAGINATION
        $usulankegiatans = $query->paginate(20)->withQueryString();

        return view('pages.laporankegiatan.arsip_laporan_kegiatan', compact('usulankegiatans'));
    }

    public function preview(Request $request, $id)
    {
        $usulan = Izin_Usulankegiatans::with([
            'inputlaporankegiatans.laporankegiatans.detaillaporankegiatans',
            'inputlaporankegiatans.inputusulankegiatans.kopunitkerjas',
            'inputlaporankegiatans.laporankegiatans.detaillaporankegiatans.pesertakegiatans',
        ])->findOrFail($id);

        $laporankegiatans = $usulan->inputlaporankegiatans?->laporankegiatans;

        $kop = $laporankegiatans
            ?->inputlaporankegiatans
            ?->inputusulankegiatans
            ?->kopunitkerjas;

        $ttd = Izin_Ttdunitkerjas::where(
            'subunitkerja_id',
            $kop?->subunitkerja_id
        )->first();

        $stempel = Izin_Stempelunitkerjas::where(
            'subunitkerja_id',
            $kop?->subunitkerja_id
        )->first();

        $kop_path = public_path('build/assets/kop_surat.png');
        if (!file_exists($kop_path)) {
            $kop_path = null;
        }

        $rundown_laporan = [];
        $rundownMerge = [];

        if ($laporankegiatans->detaillaporankegiatans?->rundown_laporan) {

            $path = storage_path(
                'app/public/' .
                    $laporankegiatans->detaillaporankegiatans->rundown_laporan
            );

            if (file_exists($path)) {

                try {

                    $spreadsheet = IOFactory::load($path);
                    $sheet = $spreadsheet->getActiveSheet();

                    $mergeInfo = [];
                    $headerMerge = [];
                    foreach ($sheet->getMergeCells() as $merge) {

                        if (preg_match('/A(\d+):A(\d+)/', $merge, $m)) {

                            $start = (int) $m[1];
                            $end   = (int) $m[2];

                            $mergeInfo[$start] = $end - $start + 1;
                        }

                        // Merge horizontal (header)
                        if (preg_match('/^A(\d+):([A-Z]+)\1$/', $merge, $m)) {

                            $headerMerge[(int)$m[1]] = true;
                        }
                    }

                    $rundownMerge = $mergeInfo;

                    $rowNumber = 1;

                    foreach ($sheet->toArray(null, true, true, true) as $row) {

                        $row = array_values(array_slice($row, 0, 3));

                        // simpan nomor baris excel
                        $row['_row'] = $rowNumber;
                        $row['_rowspan'] = $mergeInfo[$rowNumber] ?? 0;

                        // default
                        $row['_isGroupHeader'] = false;
                        $row['_isColumnHeader'] = false;

                        // Header grup (merge A:C)
                        if (isset($headerMerge[$rowNumber])) {
                            $row['_isGroupHeader'] = true;
                        }

                        // Header kolom
                        elseif (
                            strtolower(trim($row[0] ?? '')) == 'waktu' &&
                            strtolower(trim($row[1] ?? '')) == 'kegiatan'
                        ) {
                            $row['_isColumnHeader'] = true;
                        }

                        $rundown_laporan[] = $row;

                        $rowNumber++;
                    }
                } catch (\Exception $e) {

                    $rundown_laporan = [];
                    $rundownMerge = [];
                }
            }
        }

        $peserta_laporan = [];
        $pesertaMerge = [];
        if ($laporankegiatans->detaillaporankegiatans?->peserta_laporan) {
            $path = storage_path('app/public/' . $laporankegiatans->detaillaporankegiatans->peserta_laporan);
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

                    $pesertaMerge = $mergeInfo;

                    $rowNumber = 1;

                    foreach ($sheet->toArray(null, true, true, true) as $row) {

                        $row = array_values(array_slice($row, 0, 4));

                        // simpan nomor baris excel
                        $row['_row'] = $rowNumber;

                        // simpan rowspan
                        $row['_rowspan'] = $pesertaMerge[$rowNumber] ?? 0;

                        $peserta_laporan[] = $row;

                        $rowNumber++;
                    }
                } catch (\Exception $e) {

                    $peserta_laporan = [];
                    $pesertaMerge = [];
                }
            }
        }

        $anggaran =
            $laporankegiatans
            ->inputlaporankegiatans
            ->inputusulankegiatans
            ->usulankegiatans
            ->detailusulankegiatans
            ->alokasianggaran_kegiatan ?? 0;

        $anggaranFormat = $this->rupiahTerbilang($anggaran);

        $atribut_khusus =
            $laporankegiatans
            ->detaillaporankegiatans
            ->atribut_khusus ?? [];

        $identitas = (object)[
            'nomor_surat'   => $request->nomor_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'sifat_surat'   => $request->sifat_surat,
            'lampiran_surat' => '1 Bendel',
            'perihal_surat' => $request->perihal_surat,
        ];

        $gambardokumentasi_laporan = [];

        if ($laporankegiatans?->detaillaporankegiatans?->gambardokumentasi_laporan) {

            foreach ($laporankegiatans->detaillaporankegiatans->gambardokumentasi_laporan as $file) {

                $path = storage_path('app/public/' . $file);

                if (file_exists($path)) {
                    $gambardokumentasi_laporan[] = $path;
                }
            }
        }

        $pdf = PDF::loadView(
            'pages.generatepdf.laporan_hasil_kegiatan',
            [
                'laporankegiatans' => $laporankegiatans,
                'rundown_laporan' => $rundown_laporan,
                'rundownMerge' => $rundownMerge,
                'peserta_laporan' => $peserta_laporan,
                'pesertaMerge' => $pesertaMerge,
                'gambardokumentasi_laporan' => $gambardokumentasi_laporan,
                'format_anggaran' => $anggaranFormat,
                'atribut_khusus' => $atribut_khusus,
                'kop_path' => $kop_path,
                'kop' => $kop,
                'ttd' => $ttd,
                'stempel' => $stempel,
                'identitas' => $identitas,
            ]
        );

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf');
    }

    public function checkNomorSurat(Request $request)
    {
        $exists = \DB::table('izin_identitassurats')
            ->where('nomor_surat', $request->nomor_surat)
            ->exists();

        return response()->json([
            'exists' => $exists
        ]);
    }

    public function archive($id)
    {
        $input = Izin_Inputlaporankegiatans::with('laporankegiatans')
            ->findOrFail($id);

        $laporan = $input->laporankegiatans;

        if ($laporan) {
            $laporan->update([
                'is_archived' => 1
            ]);
        }

        return redirect()->back()->with('success', 'Laporan berhasil diarsipkan');
    }

    public function unarchive($id)
    {
        $input = Izin_Inputlaporankegiatans::with('laporankegiatans')
            ->findOrFail($id);

        $laporan = $input->laporankegiatans;

        if ($laporan) {
            $laporan->update([
                'is_archived' => 0
            ]);
        }



        return redirect()->back()->with('success', 'Laporan berhasil dikembalikan');
    }

    public function destroy($id)
    {
        $input = Izin_Inputlaporankegiatans::with([
            'laporankegiatans.detaillaporankegiatans.pesertakegiatans',
            'laporankegiatans.verifikasilaporankegiatans',
            'laporankegiatans.sertifikats',
            'laporankegiatans.balasanlaporankegiatans',
            'cetaklaporankegiatans'
        ])->findOrFail($id);

        $laporan = $input->laporankegiatans;

        if ($laporan) {

            // 1. hapus peserta
            $detail = $laporan->detaillaporankegiatans;
            if ($detail) {
                $detail->pesertakegiatans()->delete();
                $detail->delete();
            }

            // 2. hapus verifikasi
            $laporan->verifikasilaporankegiatans()->delete();

            // 3. hapus sertifikat
            if ($laporan->sertifikats) {
                $laporan->sertifikats->delete();
            }

            // 4. hapus balasan
            if ($laporan->balasanlaporankegiatans) {
                $laporan->balasanlaporankegiatans->delete();
            }

            // 5. hapus cetak
            if ($input->cetaklaporankegiatans) {
                $input->cetaklaporankegiatans->delete();
            }
        }

        // 6. HAPUS INPUT
        $input->delete();

        // 7. HAPUS LAPORAN
        if ($laporan) {
            $laporan->delete();
        }

        return redirect()->route('admin.laporankegiatan.index')
            ->with('success', 'Laporan berhasil dihapus');
    }
}
