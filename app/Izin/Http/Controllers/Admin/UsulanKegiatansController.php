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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Barryvdh\DomPDF\Facade\PDF;
use PhpOffice\PhpSpreadsheet\IOFactory;

class UsulanKegiatansController extends Controller
{
    /**
     * Tampilkan Rekapitulasi Kegiatan Pengembangan Kompetensi ASN
     */
    public function rekap()
    {
        // Ambil parameter search dan tahun dari request
        $search = request('search');
        $tahun = request('tahun');

        // Eager Loading dan Mapping
        $rekap = Izin_RefSubunitkerjas::withCount([
            'usulankegiatans as jumlah_kegiatan_bangkom'
        ])
            ->with(['usulankegiatans.inputlaporankegiatans.laporankegiatans.sertifikats'])
            ->get()
            ->map(function ($subunit) use ($search, $tahun) {

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

                    $input = $usulan->inputlaporankegiatans;

                    if (!$input->laporankegiatans) {
                        continue;
                    }

                    // Ambil balasan dari DB
                    $balasan = \App\Izin\Models\Izin_Balasanlaporankegiatans::where(
                        'inputlaporankegiatan_id',
                        $input->id
                    )->first();

                    if (!$balasan) continue;

                    // filter tahun
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

                    // pengambilan jp
                    $jp = $balasan->totalcapaianjp_kegiatan;

                    // total JP
                    $total_jp += $jp;

                    // jumlah kegiatan valid
                    $jumlah_kegiatan_valid++;

                    // kategori JP
                    if ($jp <= 10) {
                        $jp0_10++;
                    } elseif ($jp <= 19) {
                        $jp11_19++;
                    } else {
                        $jp20++;
                    }
                }

                return [
                    'nama' => $subunit->sub_unitkerja,
                    'jumlah_kegiatan' => $jumlah_kegiatan_valid,
                    'jp0_10' => $jp0_10,
                    'jp11_19' => $jp11_19,
                    'jp20' => $jp20,
                    'total' => $total_jp,

                    // persen dari jumlah kegiatan
                    'persen_20' => $jumlah_kegiatan_valid > 0
                        ? round(($jp20 / ($jp0_10 + $jp11_19 + $jp20)) * 100) . '%'
                        : '0%',
                ];
            })

            // filter search dan tahun
            ->filter(function ($row) use ($search, $tahun) {

                $matchSearch = true;
                $matchTahun  = true;

                if ($search) {
                    $matchSearch = str_contains(strtolower($row['nama']), strtolower($search));
                }

                if ($tahun) {
                    // kalau kamu belum punya field tahun di array, skip dulu
                    $matchTahun = true; // nanti kita bisa upgrade
                }

                return $matchSearch && $matchTahun;
            });

        // pagination manual akibat proses mapping dan collection
        $rekap = $rekap->values(); // reset index

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

        // Ambil user yang sedang aktif saat ini
        $activeRole = session('active_role', Auth::user()->role);

        if ($activeRole === 'superadmin') {
            return view('pages.rekapitulasi.admin_superadmin', compact('rekap', 'tahuns'));
        }

        if ($activeRole === 'admin') {
            return view('pages.rekapitulasi.admin_superadmin', compact('rekap', 'tahuns'));
        }

        return view('pages.rekapitulasi.user', compact('rekap', 'tahuns'));
    }

    /**
     * Tampilkan Daftar Usulan Kegiatan yang Telah Diajukan
     */
    public function index()
    {
        $user = Auth::user();

        // Eager load relasi dari model
        $usulankegiatans = Izin_Usulankegiatans::with([
            'inputusulankegiatans',
            'inputusulankegiatans.pelaksanaankegiatans',
            'cetakusulankegiatans',
            'verifikasiusulankegiatanterakhir'
        ])->when($user && $user->subunitkerja_id, function ($u) use ($user) {
            $u->whereHas('inputusulankegiatans.usulankegiatans.subunitkerjas', function ($u) use ($user) {
                $u->where('id', $user->subunitkerja_id);
            });
        })
            ->when($user->role === 'user', function ($u) use ($user) {
                $u->where('dibuat_oleh', $user->id);
            })
            ->get();

        // 🔥 PAGINATION
        $usulankegiatans = $usulankegiatans->values(); // reset index

        $page = request()->get('page', 1);
        $perPage = 20;

        $usulankegiatans = new LengthAwarePaginator(
            $usulankegiatans->forPage($page, $perPage),
            $usulankegiatans->count(),
            $perPage,
            $page,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );

        // Redirect ke halaman daftar pengajuan usulan kegiatan
        return view('pages.usulankegiatan.list_usulan_kegiatan', compact('usulankegiatans'));
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

        // Verifikasi bahwa status usulankegiatan tidak sama dengan draft
        if ($usulan->statususulan_kegiatan !== 'draft') {
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

        // Verifikasi bahwa status usulankegiatan tidak sama dengan draft
        if ($usulankegiatans->statususulan_kegiatan !== 'draft') {
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
        ]);

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
        // Ambil user yang sedang login saat ini
        //$user = Auth::user();

        // Eager load relasi dari model dan temukan usulankegiatan berdasarkan id
        $usulankegiatans = Izin_Usulankegiatans::with([
            'inputusulankegiatans',
            'inputusulankegiatans.kopunitkerjas',
            'detailusulankegiatans'
        ])->findOrFail($id);

        //$kirimusulankegiatans = $usulankegiatans->kirimusulankegiatans;

        //$pengirim = $kirimusulankegiatans?->nipadmin_inputusulankegiatan; // relasi ke user pengirim

        //$unitkerjaId = $pengirim?->subunitkerjas->unitkerja_id;

        // Ambil kop,ttd, dan stempel dari inputusulankegiatan pertama (1 unitkerja dianggap telah mengupload sekali)
        //$unitkerjaId = $user->subunitkerjas->unitkerja_id;
        //$kop = Izin_Kopunitkerjas::where('unitkerja_id', $unitkerjaId)->latest()->first();
        $kop = $usulankegiatans->inputusulankegiatans?->kopunitkerjas;
        $ttd = Izin_Ttdunitkerjas::where('subunitkerja_id', $kop?->subunitkerja_id)->first();
        //$ttd = $usulankegiatans->inputusulankegiatans?->kopunitkerjas?->ttdunitkerjas;
        $stempel = Izin_Stempelunitkerjas::where('subunitkerja_id', $kop?->subunitkerja_id)->first();
        //$stempel = $usulankegiatans->inputusulankegiatans?->kopunitkerjas?->stempelunitkerjas;

        // Ambil gambar logo surakarta sebagai kop surat dari asset
        $kop_path = public_path('build/assets/kop_surat.png'); // contoh nama file
        if (!file_exists($kop_path)) {
            $kop_path = null; // fallback kalau tidak ada file kop
        }

        // Baca file excel jadwal kegiatan kalau ada
        $jadwalpelaksanaan_kegiatan = [];
        if ($usulankegiatans->detailusulankegiatans?->jadwalpelaksanaan_kegiatan) {
            $path = storage_path('app/public/' . $usulankegiatans->detailusulankegiatans->jadwalpelaksanaan_kegiatan);
            if (file_exists($path)) {
                try {
                    $spreadsheet = IOFactory::load($path);
                    $sheet = $spreadsheet->getActiveSheet();
                    // Ambil semua baris, termasuk yang kosong
                    $jadwalpelaksanaan_kegiatan = [];
                    foreach ($sheet->toArray(null, true, true, true) as $row) {
                        $values = array_values($row);
                        $jadwalpelaksanaan_kegiatan[] = $values;
                    }
                    /*foreach ($sheet->toArray(null, true, true, true) as $row) {

                        $values = [];

                        foreach (array_values($row) as $cell) {
                            $values[] = $this->rapikanText($cell);
                        }

                        $jadwalpelaksanaan_kegiatan[] = $values;
                    }*/
                } catch (\Exception $e) {
                    $jadwalpelaksanaan_kegiatan = [];
                }
            }
        }

        // Load view PDF
        $pdf = PDF::loadView('pages.generatepdf.surat_usulan_kegiatan', [
            'usulankegiatans' => $usulankegiatans,
            'jadwalpelaksanaan_kegiatan' => $jadwalpelaksanaan_kegiatan,
            'kop_path' => $kop_path,
            'kop' => $kop,
            'ttd' => $ttd,
            'stempel' => $stempel,
            //'pengirim' => $pengirim,
            //user' => $user,
        ])->setPaper('A4', 'portrait');

        // Redirect dan simpan file PDF
        return $pdf->stream('KAK dan Surat Pengajuan Usulan Kegiatan ' . $usulankegiatans->inputusulankegiatans->nama_kegiatan . '.pdf');
    }

    public function destroy($id)
{
    $usulan = Izin_Usulankegiatans::with([
        'inputusulankegiatans.inputlaporankegiatans.laporankegiatans'
    ])->findOrFail($id);

    if ($usulan->inputusulankegiatans) {

        $inputUsulan = $usulan->inputusulankegiatans;

        // 🔥 Hapus laporan dulu (child paling bawah)
        if ($inputUsulan->inputlaporankegiatans) {

            $inputLaporan = $inputUsulan->inputlaporankegiatans;

            if ($inputLaporan->laporankegiatans) {
                $inputLaporan->laporankegiatans->detaillaporankegiatans()?->delete();
                $inputLaporan->laporankegiatans->delete();
            }

            $inputLaporan->delete();
        }

        // hapus cetak
        if ($inputUsulan->cetakusulankegiatans) {
            $inputUsulan->cetakusulankegiatans()->delete();
        }

        // hapus input usulan
        $inputUsulan->delete();
    }

    // terakhir hapus usulan
    $usulan->delete();

    return redirect()->route('admin.usulankegiatan.index')
        ->with('success', 'Usulan kegiatan berhasil dihapus');
}
}
