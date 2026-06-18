<?php

namespace App\Izin\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Identitassurats;
use App\Izin\Models\Izin_Laporankegiatans;
use App\Izin\Models\Izin_Cetaklaporankegiatans;
use App\Izin\Models\Izin_Inputlaporankegiatans; // ✅ FIX MISSING IMPORT
use App\Izin\Models\Izin_Usulankegiatans;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CetakLaporanKegiatansController extends Controller
{
    /**
     * Simpan Data Cetak Laporan Hasil Kegiatan
     */
    public function store(Request $request, $id)
{
    $input = Izin_Inputlaporankegiatans::with('laporankegiatans')
        ->findOrFail($id);

    $laporan = $input->laporankegiatans;

    if (!$laporan) {
        abort(404, 'Laporan tidak ditemukan');
    }

    DB::transaction(function () use ($laporan, $input) {

        Izin_Cetaklaporankegiatans::firstOrCreate([
            'inputlaporankegiatan_id' => $input->id
        ]);

        // 🔥 FORCE UPDATE (PASTI KENA DB)
        Izin_Laporankegiatans::where('id', $laporan->id)
            ->update([
                'statuslaporan_kegiatan' => 'pending'
            ]);
    });

    return back()->with('success', 'Data cetak berhasil dibuat');
}

public function download(Request $request, $id)
{


    $usulan = Izin_Usulankegiatans::with([
        'inputlaporankegiatans.laporankegiatans.detaillaporankegiatans',
        'inputlaporankegiatans.cetaklaporankegiatans.identitassurats'
    ])->findOrFail($id);

    $input = $usulan->inputlaporankegiatans;

    if (!$input) {
        abort(404, 'Input laporan tidak ditemukan');
    }

    $laporan = $input->laporankegiatans;

    if (!$laporan) {
        abort(404, 'Laporan tidak ditemukan');
    }

    DB::transaction(function () use ($request, $input, $laporan) {

        // 🔥 VALIDASI NOMOR SURAT (WAJIB UNIK)
        $validated = $request->validate([
            'nomor_surat'   => 'required|unique:izin_identitassurats,nomor_surat',
            'tanggal_surat' => 'required',
            'lampiran_surat'=> 'required',
            'sifat_surat'   => 'required',
            'perihal_surat' => 'required',
        ]);

        // 🔥 CETAK (ANTI DUPLIKAT)
        $cetak = Izin_Cetaklaporankegiatans::with('identitassurats')
    ->firstOrCreate([
        'inputlaporankegiatan_id' => $input->id
    ]);

    
    $identitas = $cetak->identitassurats;

if ($identitas) {

    $identitas->update([
        'nomor_surat' => $request->nomor_surat,
        'tanggal_surat' => Carbon::createFromFormat('d-m-Y', $request->tanggal_surat)->format('Y-m-d'),
        'lampiran_surat' => $request->lampiran_surat,
        'sifat_surat' => $request->sifat_surat,
        'perihal_surat' => $request->perihal_surat,
    ]);

} else {

    $identitas = Izin_Identitassurats::create([
        'nomor_surat' => $request->nomor_surat,
        'tanggal_surat' => Carbon::createFromFormat('d-m-Y', $request->tanggal_surat)->format('Y-m-d'),
        'lampiran_surat' => $request->lampiran_surat,
        'sifat_surat' => $request->sifat_surat,
        'perihal_surat' => $request->perihal_surat,
    ]);

    $cetak->update([
        'identitassurat_id' => $identitas->id
    ]);
}

        // 🔥 UPDATE STATUS
        $laporan->update([
            'statuslaporan_kegiatan' => 'pending'
        ]);
    });

    // 🔥 REFRESH TOTAL (INI PENTING BIAR PDF NGGAK CACHE)
    $usulan->refresh()->load([
        'inputlaporankegiatans.laporankegiatans.detaillaporankegiatans',
        'inputlaporankegiatans.cetaklaporankegiatans.identitassurats'
    ]);

    $input = $usulan->inputlaporankegiatans;
    $laporankegiatans = $input->laporankegiatans;
    $identitas = $input->cetaklaporankegiatans?->identitassurats;

    // 🔥 GAMBAR
    $gambardokumentasi_laporan = [];

    if ($laporankegiatans?->detaillaporankegiatans?->gambardokumentasi_laporan) {
        foreach ($laporankegiatans->detaillaporankegiatans->gambardokumentasi_laporan as $file) {
            $path = storage_path('app/public/' . $file);
            if (file_exists($path)) {
                $gambardokumentasi_laporan[] = $path;
            }
        }
    }

    // 🔥 PDF GENERATE
    $pdf = Pdf::loadView(
        'pages.generatepdf.laporan_hasil_kegiatan',
        compact('usulan', 'laporankegiatans', 'identitas', 'gambardokumentasi_laporan')
    );

    return $pdf->download('Laporan Hasil Kegiatan ' . $laporankegiatans->inputlaporankegiatans->inputusulankegiatans->nama_kegiatan . '.pdf');
}

public function create($id)
{
    
    $usulan = Izin_Usulankegiatans::with([
        'inputlaporankegiatans.laporankegiatans.detaillaporankegiatans',
        'inputlaporankegiatans.cetaklaporankegiatans.identitassurats',
        'subunitkerjas'
    ])->findOrFail($id);

    $input = $usulan->inputlaporankegiatans;

    $cetak = $input?->cetaklaporankegiatans;
    $identitas = $cetak?->identitassurats;
    $laporankegiatans = Izin_Laporankegiatans::find($input->laporankegiatan_id);

    return view('pages.laporankegiatan.cetak_laporan_kegiatan', compact(
        'usulan',
        'input',
        'cetak',
        'identitas',
        'laporankegiatans'
    ));
}
}
