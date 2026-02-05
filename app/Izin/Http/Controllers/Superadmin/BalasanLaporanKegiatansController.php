<?php

namespace App\Izin\Http\Controllers\Superadmin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Balasanlaporankegiatans;
use App\Izin\Models\Izin_Identitassurats;
use App\Izin\Models\Izin_Laporankegiatans;
use App\Izin\Models\Izin_Sertifikats;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\PDF;

class BalasanLaporanKegiatansController extends Controller
{
    /**
     * Tampilkan Form Bagian Usulan Kegiatan Pada Form Ajukan Usulan Kegiatan
     */
    public function create($id)
    {
        $laporankegiatans = Izin_Laporankegiatans::with('inputlaporankegiatans',
    'inputlaporankegiatans.inputusulankegiatans',
    'inputlaporankegiatans.inputusulankegiatans.usulankegiatans', 'inputlaporankegiatans.inputusulankegiatans.usulankegiatans.carapelatihans', 'inputlaporankegiatans.inputusulankegiatans.usulankegiatans.subunitkerjas')->findOrFail($id);
        $subunitkerjas = $laporankegiatans->usulankegiatans->subunitkerjas->sub_unitkerja ?? '-';
        $subunitkerja_id = $laporankegiatans->usulankegiatans->subunitkerja_id ?? null;
        $sertifikat_id = session('sertifikat_id');
        $sertifikats = null;

        if ($sertifikat_id) {
            $sertifikats = \App\Izin\Models\Izin_Sertifikats::find($sertifikat_id);
        }

        return view('pages.balasanlaporankegiatan.ajukan_balasan_laporan_kegiatan', compact('laporankegiatans', 'subunitkerjas', 'subunitkerja_id', 'sertifikats'));
    }

    /**
     * Simpan Data Usulan Kegiatan
     */
    public function store(Request $request, $id)
    {
        $user = Auth::user();

        $laporankegiatans = Izin_Laporankegiatans::with('usulankegiatans.carapelatihans', 'identitassurats', 'detaillaporankegiatans')->findOrFail($id);

        // ================================
    // 1. PROSES TEMPLATE SERTIFIKAT
    // ================================
    $dataFields = $request->fieldstemplatesertifikat_kegiatan;

    if (is_string($dataFields)) {
        $dataFields = $dataFields === "" ? [] : json_decode($dataFields, true);
    }

    $sertifikats = Izin_Sertifikats::findOrFail($request->sertifikat_id);

$sertifikats->update([
    'tanggalkeluarsertifikat_kegiatan' => $request->tanggalkeluarsertifikat_kegiatan,
    'fieldstemplatesertifikat_kegiatan' => $dataFields,
]);

        // ===========================================================
        // SIMPAN IDENTITAS SURAT
        // ===========================================================
        $identitassurats = Izin_Identitassurats::create([
            'nomor_surat' => $request->nomor_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'perihal_surat' => $request->perihal_surat,
            'lampiran_surat' => $request->lampiran_surat,
            'subunitkerja_id' => $user->subunitkerja_id,
            'dibuat_oleh' => $user->id,
        ]);

        Izin_Balasanlaporankegiatans::create([
            'identitassurat_id' => $identitassurats->id,
            'laporankegiatan_id' => $laporankegiatans->id,
            'usulankegiatan_id' => $laporankegiatans->usulankegiatans->id,
            'sertifikat_id' => $request->sertifikat_id,
            'totalcapaianjp_kegiatan' => $request->totalcapaianjp_kegiatan,
        ]);

        return redirect()->route('superadmin.usulankegiatan.pending')
            ->with('success', 'Usulan Kegiatan Berhasil Disimpan Secara Lengkap!');
    }

    /**
     * Download Surat dan KAK Pengajuan Usulan Kegiatan
     */
    public function download($id)
    {
        // Ambil data lengkap dengan relasi
        $balasanlaporankegiatans = Izin_Balasanlaporankegiatans::with([
            'identitassurats',
            'usulankegiatans',
            'laporankegiatans',
            'sertifikats',
        ])->findOrFail($id);

        // Ambil gambar logo surakarta sebagai kop surat dari asset
        $kop_path = public_path('build/assets/kop_surat.png'); // contoh nama file
        if (!file_exists($kop_path)) {
            $kop_path = null; // fallback kalau tidak ada file kop
        }

        $ttd_path = null;
        if (!empty($balasanlaporankegiatans->tandatangan_pjkegiatan)) {
            $tandatangan_path = storage_path('app/public/' . $balasanlaporankegiatans->tandatangan_pjkegiatan);
            if (file_exists($tandatangan_path)) {
                $ttd_path = $tandatangan_path;
            }
        } elseif (session()->has('tandatangan_pjkegiatan')) {
            // fallback kalau diambil dari upload session
            $tandatangan_path = storage_path('app/public/' . session('tandatangan_pjkegiatan'));
            if (file_exists($tandatangan_path)) {
                $ttd_path = $tandatangan_path;
            }
        }

        $pdf = PDF::loadView('pages.generatepdf.balasan_laporan_kegiatan', [
            'balasanlaporankegiatans' => $balasanlaporankegiatans,
            'kop_path' => $kop_path,
            'ttd_path' => $ttd_path,
        ])->setPaper('A4', 'portrait');

        return $pdf->stream('Balasan_Laporan_Kegiatan' . $balasanlaporankegiatans->laporankegiatans->usulankegiatans->nama_kegiatan . '.pdf');
    }
}
