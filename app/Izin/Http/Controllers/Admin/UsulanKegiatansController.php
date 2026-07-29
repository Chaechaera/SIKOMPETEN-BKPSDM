<?php

namespace App\Izin\Http\Controllers\Admin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Detailusulankegiatans;
use App\Izin\Models\Izin_Inputusulankegiatans;
use App\Izin\Models\Izin_Kopunitkerjas;
use App\Izin\Models\Izin_RefCarapelatihans;
use App\Izin\Models\Izin_RefMetodepelatihans;
use App\Izin\Models\Izin_RefSubunitkerjas;
use App\Izin\Models\Izin_Sertifikats;
use App\Izin\Models\Izin_Stempelunitkerjas;
use App\Izin\Models\Izin_Ttdunitkerjas;
use App\Izin\Models\Izin_Usulankegiatans;
use App\Izin\Models\Izin_Verifikasiusulankegiatans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class UsulanKegiatansController extends Controller
{

    public function archive($id)
    {
        $usulan = Izin_Usulankegiatans::findOrFail($id);

        $usulan->update([
            'admin_archived_at' => now(),
        ]);

        return back()->with('success', 'Usulan berhasil diarsipkan.');
    }

    public function archivePage(Request $request)
    {
        $user = Auth::user();

        $usulankegiatans = Izin_Usulankegiatans::with([
            'inputusulankegiatans',
            'cetakusulankegiatans',
            'verifikasiusulankegiatanterakhir',
            'inputlaporankegiatans'
        ])
            ->whereNotNull('admin_archived_at');

        if ($user->role == 'admin') {
            $usulankegiatans->where('subunitkerja_id', $user->subunitkerja_id);
        }

        if ($request->filled('search')) {
            $usulankegiatans->whereHas('inputusulankegiatans', function ($q) use ($request) {
                $q->where('nama_kegiatan', 'like', '%' . $request->search . '%');
            });
        }

        $usulankegiatans = $usulankegiatans
            ->latest('admin_archived_at')
            ->paginate(20);

        return view(
            'pages.usulankegiatan.arsip_usulan_kegiatan',
            compact('usulankegiatans')
        );
    }

    public function restore($id)
    {
        $usulan = Izin_Usulankegiatans::findOrFail($id);

        $usulan->update([
            'admin_archived_at' => null,
        ]);

        return back()->with('success', 'Usulan berhasil dipulihkan.');
    }

    /**
     * Tampilkan Rekapitulasi Kegiatan Pengembangan Kompetensi ASN
     */
    public function rekap()
    {
        // Ambil Data OPD
        $opds = Izin_RefSubunitkerjas::orderBy('sub_unitkerja')->get();

        // Ambil parameter search dan tahun dari request
        $search = request('search');
        $tahun = request('tahun');
        $kategori = request('kategori');
        $opd = request('opd');

        // Eager Loading dan Mapping
        $rekap = Izin_RefSubunitkerjas::withCount([
            'usulankegiatans as jumlah_kegiatan_bangkom'
        ])
            ->with(['usulankegiatans.inputlaporankegiatans.laporankegiatans.sertifikats'])
            ->get()
            ->map(function ($subunit) use ($search, $tahun) {

                // Permisalan suatu data
                $total_jp = 0;
                $jp0_10 = 0;
                $jp11_19 = 0;
                $jp20 = 0;
                $jumlah_kegiatan_valid = 0;

                // Looping usulankegiatan per subunitkerja
                foreach ($subunit->usulankegiatans as $usulan) {
                    if (!$usulan->inputlaporankegiatans) {
                        continue;
                    }

                    // Ambil laporankegiatans
                    $input = $usulan->inputlaporankegiatans;
                    if (!$input->laporankegiatans) {
                        continue;
                    }

                    // Ambil balasan dari DB
                    $balasan = \App\Izin\Models\Izin_Balasanlaporankegiatans::where('inputlaporankegiatan_id', $input->id)->first();
                    if (!$balasan) {
                        continue;
                    }

                    // Filter tahun berdasarkan tahun sertifikat keluar
                    if ($tahun) {
                        $sertifikat = $input->laporankegiatans->sertifikats;
                        if (
                            !$sertifikat ||
                            !$sertifikat->tanggalkeluarsertifikat_kegiatan ||
                            \Carbon\Carbon::parse($sertifikat->tanggalkeluarsertifikat_kegiatan)->year != $tahun
                        ) {
                            continue;
                        }
                    }

                    // Ambil JP
                    $jp = $balasan->totalcapaianjp_kegiatan;

                    // Total JP
                    $total_jp += $jp;

                    // Jumlah kegiatan valid
                    $jumlah_kegiatan_valid++;

                    // Kategori JP
                    if ($jp <= 10) {
                        $jp0_10++;
                    } elseif ($jp <= 19) {
                        $jp11_19++;
                    } else {
                        $jp20++;
                    }
                }

                // ===============================
                // Hitung Persentase >20 JP
                // ===============================
                $persen20 = $jumlah_kegiatan_valid > 0
                    ? round(($jp20 / $jumlah_kegiatan_valid) * 100)
                    : 0;

                $persen_20 = $persen20 . '%';

                // ===============================
                // Kategori Kinerja PK ASN
                // ===============================

                if ($jumlah_kegiatan_valid >= 12 && $persen20 >= 70) {
                    $kategori = 'Sangat Baik';
                } elseif ($jumlah_kegiatan_valid >= 9 && $persen20 >= 50) {
                    $kategori = 'Baik';
                } elseif ($jumlah_kegiatan_valid >= 6 && $persen20 >= 30) {
                    $kategori = 'Cukup';
                } elseif ($jumlah_kegiatan_valid >= 4 && $persen20 >= 10) {
                    $kategori = 'Kurang';
                } else {
                    $kategori = 'Sangat Kurang';
                }

                // ===============================
                // Return Data
                // ===============================
                return [
                    'nama' => $subunit->sub_unitkerja,
                    'jumlah_kegiatan' => $jumlah_kegiatan_valid,
                    'jp0_10' => $jp0_10,
                    'jp11_19' => $jp11_19,
                    'jp20' => $jp20,
                    'total' => $total_jp,
                    'persen_20' => $persen_20,
                    'kategori_kinerja' => $kategori,
                ];
            })

            // filter search dan tahun
            ->filter(function ($row) use ($search, $kategori) {

                if (
                    $search &&
                    !str_contains(strtolower($row['nama']), strtolower($search))
                ) {
                    return false;
                }

                if (
                    $kategori &&
                    $row['kategori_kinerja'] !== $kategori
                ) {
                    return false;
                }

                return true;
            });

        // ===============================
        // Pagination Data Rekapitulasi
        // ===============================
        $rekap = $rekap->values();
        $page = request()->get('page', 1);
        $perPage = 20;

        $rekap = new LengthAwarePaginator(
            $rekap->forPage($page, $perPage),
            $rekap->count(),
            $perPage,
            $page,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );

        // ambil daftar tahun untuk filter
        $tahuns = Izin_Sertifikats::selectRaw('YEAR(tanggalkeluarsertifikat_kegiatan) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        // Permisalan Chart Data Grafik
        $chartData = [];

        if ($opd) {
            $subunit = Izin_RefSubunitkerjas::with([
                'usulankegiatans.inputlaporankegiatans.laporankegiatans.sertifikats'
            ])->find($opd);

            if ($subunit) {
                $group = [];
                foreach ($subunit->usulankegiatans as $usulan) {
                    if (!$usulan->inputlaporankegiatans)
                        continue;

                    $input = $usulan->inputlaporankegiatans;
                    if (!$input->laporankegiatans)
                        continue;

                    $sertifikat = $input->laporankegiatans->sertifikats;
                    if (!$sertifikat)
                        continue;

                    $thn = Carbon::parse(
                        $sertifikat->tanggalkeluarsertifikat_kegiatan
                    )->year;

                    if ($tahun && $thn != $tahun) {
                        continue;
                    }

                    $balasan = \App\Izin\Models\Izin_Balasanlaporankegiatans::where(
                        'inputlaporankegiatan_id',
                        $input->id
                    )->first();

                    if (!$balasan)
                        continue;

                    if (!isset($group[$thn])) {
                        $group[$thn] = [
                            'jumlah' => 0,
                            'jp' => 0,
                            'jp20' => 0
                        ];
                    }

                    $group[$thn]['jumlah']++;
                    $group[$thn]['jp'] += $balasan->totalcapaianjp_kegiatan;

                    if ($balasan->totalcapaianjp_kegiatan > 20) {
                        $group[$thn]['jp20']++;
                    }
                }
                ksort($group);

                foreach ($group as $tahun => $item) {
                    // Perhitungan Persentase 20JP
                    $persen = round(
                        ($item['jp20'] / $item['jumlah']) * 100
                    );

                    // Perhitungan Grafik PK ASN
                    if ($item['jumlah'] >= 12 && $persen >= 70) {
                        $score = 5;
                    } elseif ($item['jumlah'] >= 9 && $persen >= 50) {
                        $score = 4;
                    } elseif ($item['jumlah'] >= 6 && $persen >= 30) {
                        $score = 3;
                    } elseif ($item['jumlah'] >= 4 && $persen >= 10) {
                        $score = 2;
                    } else {
                        $score = 1;
                    }

                    // Tampilkan Datanya
                    $chartData[] = [
                        'tahun' => $tahun,
                        'jumlah' => $item['jumlah'],
                        'jp' => $item['jp'],
                        'kategori' => $score
                    ];
                }
            }
        }

        // Ambil user yang sedang aktif saat ini
        $activeRole = session('active_role', Auth::user()->role);

        // Mapping page untuk rekapitulasi
        if ($activeRole === 'superadmin') {
            return view('pages.rekapitulasi.admin_superadmin', compact('rekap', 'tahuns', 'opds', 'chartData'));
        }
        if ($activeRole === 'admin') {
            return view('pages.rekapitulasi.admin_superadmin', compact('rekap', 'tahuns', 'opds', 'chartData'));
        }

        // Return hasil halaman rekapitulasi
        return view('pages.rekapitulasi.user', compact('rekap', 'tahuns', 'opds', 'chartData'));
    }

    /**
     * Tampilkan Daftar Usulan Kegiatan yang Telah Diajukan
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Eager load relasi dari model
        $usulankegiatans = Izin_Usulankegiatans::with([
            'inputusulankegiatans',
            'inputusulankegiatans.pelaksanaankegiatans',
            'cetakusulankegiatans',
            'verifikasiusulankegiatanterakhir',
            'inputlaporankegiatans',
            'inputlaporankegiatans.laporankegiatans'
        ])->whereNull('admin_archived_at');

        // Filter berdasarkan role
        if ($user->role === 'admin') {
            $usulankegiatans->where('subunitkerja_id', $user->subunitkerja_id);
        }

        if ($user->role === 'user') {
            $usulankegiatans->where('dibuat_oleh', $user->id);
        }

        // Filter berdasarkan nama kegiatan (abjad)
        if ($request->filled('search')) {
            $usulankegiatans->whereHas('inputusulankegiatans', function ($query) use ($request) {
                $query->where('nama_kegiatan', 'like', '%' . $request->search . '%');
            });
        }

        // Filter berdasarkan tanggal pengajuan
        if ($request->filled('tanggal_pengajuan')) {
            $usulankegiatans->whereDate('created_at', $request->tanggal_pengajuan);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $usulankegiatans->where('statususulan_kegiatan', $request->status);
        }

        $notifikasiReview = \App\Izin\Models\Izin_Verifikasiusulankegiatans::with([
            'usulankegiatans.inputusulankegiatans'
        ])
            ->where('is_read', false)
            ->whereHas('usulankegiatans', function ($q) use ($user) {

                if ($user->role === 'admin') {
                    $q->where('subunitkerja_id', $user->subunitkerja_id);
                }

                if ($user->role === 'user') {
                    $q->where('dibuat_oleh', $user->id);
                }
            })
            ->latest('tanggalverifikasi_inputusulankegiatan')
            ->get();

        $usulankegiatans = $usulankegiatans->orderBy('updated_at', 'desc')->paginate(20)->appends($request->query());

        // Redirect ke halaman daftar pengajuan usulan kegiatan
        return view(
            'pages.usulankegiatan.list_usulan_kegiatan',
            compact(
                'usulankegiatans',
                'notifikasiReview'
            )
        );
    }

    /**
     * Tutup notifikasi review usulan kegiatan
     */
    public function closeNotification($id)
    {
        $notif = Izin_Verifikasiusulankegiatans::findOrFail($id);

        $notif->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Tampilkan Form Ajukan Nama Usulan Kegiatan Pengembangan Kompetensi ASN
     */
    public function create()
    {
        // Ambil user yang sedang login saat ini
        $user = Auth::user();

        // Redirect ke halaman ajukan pengajuan usulan kegiatan
        return view('pages.usulankegiatan.ajukan_usulan_kegiatan', [
            'unitkerjas' => $user->subunitkerjas?->unitkerjas?->unitkerja,
            'subunitkerjas' => $user->subunitkerjas->sub_unitkerja ?? null,
            'dibuat_oleh' => $user->nama,
            'carapelatihans' => Izin_RefCarapelatihans::select('id', 'cara_pelatihan')->get(),
            'metodepelatihans' => Izin_RefMetodepelatihans::select('id', 'metode_pelatihan')->get(),
        ]);
    }

    /**
     * Simpan Data Awal Pada Form Ajukan Nama Usulan Kegiatan Pengembangan Kompetensi ASN
     */
    public function storeAwal(Request $request)
    {
        // Validasi request
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255'
        ]);

        // Ambil user yang sedang login saat ini
        $user = Auth::user();

        // Simpan data awal usulankegiatan
        $usulan = Izin_Usulankegiatans::create([
            'nama_kegiatan' => $request->nama_kegiatan,
            'dibuat_oleh' => $user->id,
            'subunitkerja_id' => $user->subunitkerja_id,
            'unitkerja_id' => $user->subunitkerjas->unitkerja_id,
            'statususulan_kegiatan' => 'draft'
        ]);

        // Simpan data inputusulankegiatan
        Izin_Inputusulankegiatans::create([
            'usulankegiatan_id' => $usulan->id,
            'nama_kegiatan' => $request->nama_kegiatan,
            'pjunitkerja_id' => $user->id
        ]);

        // Redirect ke halaman edit usulan kegiatan
        return redirect()->route('admin.usulankegiatan.edit', $usulan->id)->with('success', 'Silakan lengkapi data usulan kegiatan.');
    }

    public function destroy($id)
    {
        $usulan = Izin_Usulankegiatans::findOrFail($id);

        // Hapus data terkait
        $usulan->verifikasiusulankegiatans()->delete();

        if ($usulan->cetakusulankegiatans) {
            $usulan->cetakusulankegiatans()->delete();
        }

        if ($usulan->detailusulankegiatans) {
            $usulan->detailusulankegiatans()->delete();
        }

        if ($usulan->inputusulankegiatans) {
            $usulan->inputusulankegiatans()->delete();
        }

        $usulan->delete();

        return redirect()
            ->route('admin.usulankegiatan.index')
            ->with('success', 'Usulan kegiatan berhasil dihapus.');
    }

    /**
     * Tampilkan Form Edit Ajukan Usulan Kegiatan Pengembangan Kompetensi ASN
     */
    public function edit($id)
    {
        // Eager load relasi dari model
        $usulan = Izin_Usulankegiatans::with([
            'inputusulankegiatans',
            'inputusulankegiatans.kopunitkerjas',
            'detailusulankegiatans'
        ])->findOrFail($id);

        // Ambil user yang sedang login saat ini
        $user = Auth::user();

        // Ambil kopunitkerja terakhir user yang sedang login saat ini
        $kopunitkerja_user = Izin_Kopunitkerjas::where('subunitkerja_id', $user->subunitkerja_id)->latest()->first();
        $kopunitkerja_id = $usulan->inputusulankegiatans?->kopunitkerja_id ?? $kopunitkerja_user?->id ?? null;

        // Verifikasi bahwa usulan dapat diedit
        if (!$usulan->canEdit()) {
            abort(403, 'Usulan sudah tidak dapat diubah.');
        }

        // Pastikan detailusulankegiatan selalu ada
        $detail = $usulan->detailusulankegiatans ?? new Izin_Detailusulankegiatans();

        // Redirect ke halaman lengkapi pengajuan usulan kegiatan
        return view('pages.usulankegiatan.lengkapi_usulan_kegiatan', [
            'usulan' => $usulan,
            'detail' => $detail,
            'subunitkerjas' => $usulan->subunitkerjas->sub_unitkerja,
            'unitkerjas' => $usulan->subunitkerjas->unitkerjas->unitkerja,
            'nama_kegiatan' => $usulan->inputusulankegiatans->nama_kegiatan,
            'carapelatihans' => Izin_RefCarapelatihans::all(),
            'metodepelatihans' => Izin_RefMetodepelatihans::all(),
            'kopunitkerja_id' => $kopunitkerja_id,
        ]);
    }

    /**
     * Update Data Pada Form Edit Ajukan Usulan Kegiatan Pengembangan Kompetensi ASN
     */
    public function update(Request $request, $id)
    {
        // Temukan usulankegiatan berdasarkan id
        $usulankegiatans = Izin_Usulankegiatans::findOrFail($id);

        // Verifikasi bahwa usulan dapat diedit
        if (!$usulankegiatans->canEdit()) {
            abort(403);
        }

        // Update data usulankegiatan
        $usulankegiatans->update([
            'lokasi_kegiatan' => $request->lokasi_kegiatan,
            'carapelatihan_id' => $request->carapelatihan_id,
            'tanggalmulai_kegiatan' => $request->tanggalmulai_kegiatan,
            'tanggalselesai_kegiatan' => $request->tanggalselesai_kegiatan,
            'waktumulai_kegiatan' => $request->waktumulai_kegiatan,
            'waktuselesai_kegiatan' => $request->waktuselesai_kegiatan,
            'statususulan_kegiatan' => 'draft', // Reset status ke draft untuk edit ulang
        ]);

        // Reset related records to make it like a new submission
        $usulankegiatans->cetakusulankegiatans()->delete();
        $usulankegiatans->verifikasiusulankegiatans()->delete();

        // Merge request berdasarkan id usulankegiatan
        $request->merge([
            'usulankegiatan_id' => $usulankegiatans->id
        ]);

        // Lanjutkan proses store ke controller detailusulankegiatan
        return app(DetailUsulanKegiatansController::class)->store($request);
    }

    /**
     * Download Surat dan KAK Pengajuan Usulan Kegiatan Pengembangan Kompetensi ASN
     */
    public function download($id)
    {
        $usulankegiatans = Izin_Usulankegiatans::with([
            'inputusulankegiatans.cetakusulankegiatans'
        ])->findOrFail($id);

        $cetak = $usulankegiatans
            ->inputusulankegiatans
            ->cetakusulankegiatans;

        if (
            !$cetak ||
            !$cetak->filepdfgenerate_path ||
            !Storage::disk('public')->exists($cetak->filepdfgenerate_path)
        ) {
            abort(404, 'Dokumen belum digenerate.');
        }

        return Storage::disk('public')->download(
            $cetak->filepdfgenerate_path,
            'KAK dan Surat Pengajuan Usulan Kegiatan ' .
                $usulankegiatans->inputusulankegiatans->nama_kegiatan .
                '.pdf'
        );
    }

    public function preview(Request $request, $id)
    {
        $user = Auth::user();

        $usulankegiatans = Izin_Usulankegiatans::with([
            'inputusulankegiatans',
            'inputusulankegiatans.kopunitkerjas',
            'detailusulankegiatans'
        ])->findOrFail($id);

        $kop = $usulankegiatans?->inputusulankegiatans?->kopunitkerjas;

        /*$ttd = Izin_Ttdunitkerjas::where(
            'unitkerja_id',
            $user->subunitkerjas->unitkerja_id
        )->first();

        $stempel = Izin_Stempelunitkerjas::where(
            'unitkerja_id',
            $user->subunitkerjas->unitkerja_id
        )->first();*/

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
                            $end = (int) $m[2];

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

        $identitas = (object) [
            'nomor_surat' => $request->nomor_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'sifat_surat' => $request->sifat_surat,
            'lampiran_surat' => $request->lampiran_surat,
            'perihal_surat' => $request->perihal_surat,
        ];

        // Ambil parameter untuk menampilkan ttd, stempel, NIP, dan jabatan
        $showTtd = $request->boolean('show_ttd');
        $showStempel = $request->boolean('show_stempel');
        $showNIP = $request->boolean('show_nip');
        $showJabatan = $request->boolean('show_jabatan');

        $pdf = PDF::loadView(
            'pages.generatepdf.surat_usulan_kegiatan',
            [
                'usulankegiatans' => $usulankegiatans,
                'jadwalpelaksanaan_kegiatan' => $jadwalpelaksanaan_kegiatan,
                'jadwalMerge' => $jadwalMerge,
                'kop_path' => $kop_path,
                'kop' => $kop,
                'ttd' => $ttd,
                'stempel' => $stempel,
                'user' => $user,
                'identitas' => $identitas,
                'showTtd' => $showTtd,
                'showStempel' => $showStempel,
                'showNIP' => $showNIP,
                'showJabatan' => $showJabatan,
            ]
        );

        return response(
            $pdf->output(),
            200
        )->header('Content-Type', 'application/pdf');
    }

    public function previewFile($id)
    {
        $usulan = Izin_Usulankegiatans::with(
            'inputusulankegiatans.cetakusulankegiatans'
        )->findOrFail($id);

        $path = optional(
            $usulan->inputusulankegiatans->cetakusulankegiatans
        )->filepdfgenerate_path;

        if (!$path || !Storage::disk('public')->exists($path)) {
            abort(404, 'Dokumen belum digenerate.');
        }

        return response()->file(
            storage_path('app/public/' . $path),
            [
                'Content-Type' => 'application/pdf',
            ]
        );
    }
}
