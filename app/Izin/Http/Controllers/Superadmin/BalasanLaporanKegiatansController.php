<?php

namespace App\Izin\Http\Controllers\Superadmin;
use App\Izin\Models\Izin_Identitassurats;
use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Balasanlaporankegiatans;
use App\Izin\Models\Izin_Inputlaporankegiatans;
use App\Izin\Models\Izin_Kirimbalasanlaporankegiatans;
use App\Izin\Models\Izin_Kopunitkerjas;
use App\Izin\Models\Izin_Laporankegiatans;
use App\Izin\Models\Izin_Sertifikats;
use App\Izin\Models\Izin_Stempelunitkerjas;
use App\Izin\Models\Izin_Ttdunitkerjas;
use App\Izin\Services\IdentitasSuratsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\DB;

class BalasanLaporanKegiatansController extends Controller
{
    /**
     * Tampilkan Form Balasan Laporan Hasil Kegiatan Final
     */
    public function create($id)
    {
        // Eager load relasi dari model dan temukan laporankegiatan berdasarkan id
        $laporankegiatans = Izin_Laporankegiatans::with([
            'sertifikats',
            'inputlaporankegiatans',
            'inputlaporankegiatans.inputusulankegiatans',
            'inputlaporankegiatans.inputusulankegiatans.usulankegiatans',
            'inputlaporankegiatans.inputusulankegiatans.usulankegiatans.carapelatihans',
            'inputlaporankegiatans.inputusulankegiatans.usulankegiatans.subunitkerjas',
        ])->findOrFail($id);

        // Ambil data subunitkerja
        $subunitkerjas = $laporankegiatans->inputlaporankegiatans->inputusulankegiatans->usulankegiatans->subunitkerjas->sub_unitkerja ?? '-';
        $subunitkerja_id = $laporankegiatans->inputlaporankegiatans->inputusulankegiatans->usulankegiatans->subunitkerja_id ?? null;

        // Ambil data sertifikat
        $sertifikats = $laporankegiatans->sertifikats;

        // Redirect ke halaman ajukan balasan laporan kegiatan
        return view('pages.balasanlaporankegiatan.ajukan_balasan_laporan_kegiatan', compact('laporankegiatans', 'subunitkerjas', 'subunitkerja_id', 'sertifikats'));
    }

    /**
     * Simpan Data Balasan Laporan Hasil Kegiatan Final
     */
    public function store(Request $request, $id)
    {
        // Eager load relasi dari model dan temukan laporankegiatan berdasarkan id
        $laporankegiatans = Izin_Laporankegiatans::with([
            'inputlaporankegiatans',
            'inputlaporankegiatans.inputusulankegiatans',
            'inputlaporankegiatans.inputusulankegiatans.usulankegiatans',
            'inputlaporankegiatans.inputusulankegiatans.usulankegiatans.carapelatihans',
            'detaillaporankegiatans',
            'sertifikats',
        ])->findOrFail($id);

        // Ambil request data fields elemen sertifikat
        $dataFields = $request->fieldstemplatesertifikat_kegiatan;

        // Simpan dalam JSON
        if (is_string($dataFields)) {
            $dataFields = $dataFields === "" ? [] : json_decode($dataFields, true);
        }

        // Update sertifikat
        $sertifikats = Izin_Sertifikats::findOrFail($request->sertifikat_id);
        $sertifikats->update([
            'tanggalkeluarsertifikat_kegiatan' => $request->tanggalkeluarsertifikat_kegiatan,
            'fieldstemplatesertifikat_kegiatan' => $dataFields,
        ]);

        // Simpan balasan laporan kegiatan
        Izin_Balasanlaporankegiatans::create([
            'inputlaporankegiatan_id' => $laporankegiatans->inputlaporankegiatans->id,
            'inputusulankegiatan_id' => $laporankegiatans->inputlaporankegiatans->inputusulankegiatans->id,
            'sertifikat_id' => $request->sertifikat_id,
            'totalcapaianjp_kegiatan' => $request->totalcapaianjp_kegiatan,
        ]);

        // Redirect ke halaman list laporan kegiatan yang perlu direview
        return redirect()->route('superadmin.laporankegiatan.pending')->with('success', 'Laporan Kegiatan Berhasil Disimpan Secara Lengkap!');
    }

    /**
     * Download Surat Balasan Laporan Hasil Kegiatan Final
     */
    public function download($id)
    {
        // Ambil user yang sedang login saat ini
        $user = Auth::user();

        // Eager load relasi dari model dan temukan balasanlaporankegiatan berdasarkan id
        $balasanlaporankegiatans = Izin_Balasanlaporankegiatans::with([
            'laporankegiatans',
            'laporankegiatans.inputlaporankegiatans',
            'laporankegiatans.inputlaporankegiatans.kirimlaporankegiatans.identitassurats',
            'sertifikats',
        ])->findOrFail($id);

        // Ambil kop, ttd, dan stempel dari inputusulankegiatan pertama (1 unitkerja dianggap telah mengupload sekali)
        $kop = $balasanlaporankegiatans->laporankegiatans->inputlaporankegiatans->inputusulankegiatans->first()?->kopunitkerjas ?? null;
        $ttd = Izin_Ttdunitkerjas::where('unitkerja_id', $user->subunitkerjas->unitkerja_id)->first();
        $stempel = Izin_Stempelunitkerjas::where('unitkerja_id', $user->subunitkerjas->unitkerja_id)->first();

        // Ambil gambar logo surakarta sebagai kop surat dari asset
        $kop_path = public_path('build/assets/kop_surat.png'); // contoh nama file
        if (!file_exists($kop_path)) {
            $kop_path = null; // fallback kalau tidak ada file kop
        }

        // Load view PDF
        $pdf = PDF::loadView('pages.generatepdf.balasan_laporan_kegiatan', [
            'balasanlaporankegiatans' => $balasanlaporankegiatans,
            'kop_path' => $kop_path,
            'kop' => $kop,
            'ttd' => $ttd,
            'stempel' => $stempel,
            'user'   => $user,
        ])->setPaper('A4', 'portrait');

    // 7. Nama file aman dari null
    $namaKegiatan = optional(
        $laporan->inputlaporankegiatans
            ->inputusulankegiatans
            ->first()
            ?->usulankegiatans
    )->nama_kegiatan ?? 'tanpa-nama';

    return $pdf->stream('Balasan Laporan Kegiatan ' . $namaKegiatan . '.pdf');
}

    /**
     * Tampilkan Form Kirim Balasan Laporan Hasil Kegiatan Final
     */
    public function kirim($id)
{
    $laporankegiatans = Izin_Laporankegiatans::with([
        'sertifikats',
        'inputlaporankegiatans',
        'inputlaporankegiatans.inputusulankegiatans.usulankegiatans.carapelatihans',
    ])->findOrFail($id);

    // 🔹 URUTAN
    $urutan = optional($laporankegiatans->inputlaporankegiatans)->id ?? 0;
    $urutan = str_pad($urutan, 3, '0', STR_PAD_LEFT);

    // 🔹 BULAN (sementara pakai sekarang)
    $bulan = date('n');
    $bulanRomawi = $this->bulanRomawi($bulan);

    // 🔹 CARA PELATIHAN

$cara = optional(
    $laporankegiatans->inputlaporankegiatans
        ?->inputusulankegiatans
        ?->usulankegiatans
)->carapelatihan_id ?? 0;
// 🔹 TAHUN
    $tahun = date('Y');

// 🔹 FINAL
$nomorSurat = "{$urutan}/BKPSDM/{$bulanRomawi}/{$cara}/{$tahun}";

    // 🔹 SERTIFIKAT (biar tetap ada di view)
    $sertifikats = $laporankegiatans->sertifikats;

    return view('pages.balasanlaporankegiatan.kirim_balasan_laporan_kegiatan', 
        compact('laporankegiatans', 'nomorSurat', 'sertifikats')
    );
}

public function cetakStore(Request $request, $id)
{
    $user = Auth::user();

    $laporan = Izin_Laporankegiatans::with([
        'inputlaporankegiatans'
    ])->findOrFail($id);

    DB::transaction(function () use ($request, $laporan, $user) {

        // 1. SIMPAN IDENTITAS SURAT BALASAN
        $identitas = Izin_Identitassurats::create([
            'nomor_surat' => $request->nomor_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'perihal_surat' => $request->perihal_surat,
            'sifat_surat' => $request->sifat_surat,
        ]);

        // 2. SIMPAN / UPDATE BALASAN
        $balasan = Izin_Balasanlaporankegiatans::updateOrCreate([
            'inputlaporankegiatan_id' => $laporan->inputlaporankegiatans->id,
        ], [
            'identitassurat_id' => $identitas->id,
        ]);
    });

    // 3. GENERATE PDF
    $balasan = Izin_Balasanlaporankegiatans::with([
        'laporankegiatans.inputlaporankegiatans.kirimlaporankegiatans.identitassurats'
    ])->where('inputlaporankegiatan_id', $laporan->inputlaporankegiatans->id)
      ->first();

    $pdf = PDF::loadView('pages.generatepdf.balasan_laporan_kegiatan', [
        'balasanlaporankegiatans' => $balasan,
    ])->setPaper('A4');

    return $pdf->stream('surat-balasan.pdf');
}

public function storeIdentitas(Request $request, $id)
{
    $laporan = Izin_Laporankegiatans::with('inputlaporankegiatans')->findOrFail($id);

    $identitas = Izin_Identitassurats::create([
    'nomor_surat' => $request->nomor_surat,
    'tanggal_surat' => $request->tanggal_surat,
    'perihal_surat' => $request->perihal_surat,
    'sifat_surat' => $request->sifat_surat,
    'lampiran_surat' => $request->lampiran_surat,
]);

Izin_Balasanlaporankegiatans::updateOrCreate(
    [
        'inputlaporankegiatan_id' => $laporan->inputlaporankegiatans->id,
    ],
    [
        'identitassurat_id' => $identitas->id,
    ]
);

$user = Auth::user();

Izin_Kirimbalasanlaporankegiatans::updateOrCreate(
    [
        'inputlaporankegiatan_id' => $laporan->inputlaporankegiatans->id,
    ],
    [
        'identitassurat_id' => $identitas->id,
        'nipadmin_cetakbalasanlaporankegiatan' => $user->nip,
        'tanggalcetak_balasanlaporankegiatan' => now(),
    ]
);


    $laporan->update([
    'statuslaporan_kegiatan' => 'pending'
]);

    $laporan->refresh();

    $laporankegiatans = Izin_Laporankegiatans::with([
    'inputlaporankegiatans.kirimbalasanlaporankegiatans.identitassurats'
    ])->findOrFail($request->laporankegiatan_id);

    $balasanlaporankegiatans = Izin_Balasanlaporankegiatans::with([
        'laporankegiatans.inputlaporankegiatans.kirimbalasanlaporankegiatans.identitassurats'
    ])->where('inputlaporankegiatan_id', $request->laporankegiatan_id)->first();

    $kop_path = public_path('build/assets/kop_surat.png');

if (!file_exists($kop_path)) {
    $kop_path = null;
}

    $pdf = Pdf::loadView(
    'pages.generatepdf.balasan_laporan_kegiatan',
    [
        'laporan' => $laporankegiatans,
        'balasanlaporankegiatans' => $balasanlaporankegiatans,
        'identitas' => $identitas,
        'kop_path' => $kop_path,
    ]
);

    return $pdf->download('Balasan Laporan Kegiatan' . $balasanlaporankegiatans->laporankegiatans->inputlaporankegiatans->inputusulankegiatans->nama_kegiatan . '.pdf');
    }

    /**
     * Simpan File Balasan Laporan Hasil Kegiatan Final
     */

        public function storeFinal(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'filekirim_balasanlaporankegiatan' =>
            'required|file|mimes:pdf,doc,docx|max:10240',
        'laporankegiatan_id' => 'required',
    ]);

    DB::transaction(function () use ($request, $user) {

        $laporan = Izin_Laporankegiatans::with([
            'inputlaporankegiatans'
        ])->findOrFail($request->laporankegiatan_id);

        $filePath = $request
            ->file('filekirim_balasanlaporankegiatan')
            ->storeAs(
                'izin/filekirim_balasanlaporankegiatan',
                time().'_'.$request
                    ->file('filekirim_balasanlaporankegiatan')
                    ->getClientOriginalName(),
                'public'
            );

        $kirim = Izin_Kirimbalasanlaporankegiatans::updateOrCreate(
            [
                'inputlaporankegiatan_id' =>
                    $laporan->inputlaporankegiatans->id
            ],
            [
                'identitassurat_id' =>
                    optional(
                        $laporan->inputlaporankegiatans
                            ->kirimbalasanlaporankegiatans
                    )->identitassurat_id,

                'filekirim_balasanlaporankegiatan' => $filePath,

                'tanggalkirim_balasanlaporankegiatan' => now(),

                'nipadmin_kirimbalasanlaporankegiatan' => $user->nip,
            ]
        );

        $laporan->inputlaporankegiatans->update([
            'kirimbalasanlaporankegiatan_id' => $kirim->id
        ]);

        $laporan->update([
        'statuslaporan_kegiatan' => 'finish'
        ]);
    });

    return redirect()
        ->route('superadmin.laporankegiatan.pending')
        ->with('success', 'Balasan laporan berhasil dikirim.');
}
    private function bulanRomawi($bulan)
{
    $romawi = [
        1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV',
        5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII',
        9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
    ];

    return $romawi[(int)$bulan] ?? '-';
}

public function preview(Request $request, $id)
{
    $user = Auth::user();

    $laporan = Izin_Laporankegiatans::with([
        'inputlaporankegiatans.kirimlaporankegiatans.identitassurats',
        'inputlaporankegiatans.inputusulankegiatans.usulankegiatans',
        'sertifikats'
    ])->findOrFail($id);

    $identitas = (object) [
        'nomor_surat'    => $request->nomor_surat,
        'tanggal_surat'  => $request->tanggal_surat,
        'lampiran_surat' => $request->lampiran_surat,
        'sifat_surat'    => $request->sifat_surat,
        'perihal_surat'  => $request->perihal_surat,
    ];

    // object dummy agar view tidak error
    $balasanlaporankegiatans = (object) [
        'laporankegiatans' => $laporan,
        'totalcapaianjp_kegiatan' => '-'
    ];

    $kop_path = public_path('build/assets/kop_surat.png');

    if (!file_exists($kop_path)) {
        $kop_path = null;
    }

    $pdf = Pdf::loadView(
        'pages.generatepdf.balasan_laporan_kegiatan',
        [
            'laporan' => $laporan,
            'identitas' => $identitas,
            'balasanlaporankegiatans' => $balasanlaporankegiatans,
            'kop_path' => $kop_path,
            'user' => $user,
            'ttd' => null,
            'stempel' => null,
            'usulankegiatans' => null,
        ]
    );

    return $pdf->stream('preview.pdf');
}

}
