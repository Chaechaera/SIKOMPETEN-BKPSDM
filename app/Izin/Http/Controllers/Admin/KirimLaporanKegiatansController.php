<?php

namespace App\Izin\Http\Controllers\Admin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Kirimlaporankegiatans;
use App\Izin\Models\Izin_Laporankegiatans;
use App\Izin\Models\Izin_Usulankegiatans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KirimLaporanKegiatansController extends Controller
{
    public function create($id)
    {
        $usulan = Izin_Usulankegiatans::with([
            'inputlaporankegiatans.laporankegiatans'
        ])->findOrFail($id);

        $laporankegiatans = $usulan->inputlaporankegiatans?->laporankegiatans;

        if (!$laporankegiatans) {
            abort(404, 'Laporan tidak ditemukan');
        }

        return view('pages.laporankegiatan.kirim_laporan_kegiatan', [
            'usulan' => $usulan,
            'laporankegiatans' => $laporankegiatans
        ]);
    }

    public function store(Request $request, $id)
{
    $request->validate([
        'filekirim_inputlaporankegiatan' => 'required|file|mimes:pdf,doc,docx|max:10240',
    ]);

    $usulan = Izin_Usulankegiatans::with([
        'inputlaporankegiatans.laporankegiatans',
        'inputlaporankegiatans.cetaklaporankegiatans.identitassurats'
    ])->findOrFail($id);

    $input = $usulan->inputlaporankegiatans; // atau tanpa first kalau bukan collection

    if (!$input) {
        abort(404, 'Input laporan tidak ditemukan');
    }

    $laporan = $input->laporankegiatans;

    if (!$laporan) {
        abort(404, 'Laporan tidak ditemukan');
    }

    $cetak = $input->cetaklaporankegiatans?->first();
    $identitas = $cetak?->identitassurats;

    if (!$identitas) {
        abort(404, 'Silakan cetak dulu sebelum kirim');
    }

    $filePath = $request->file('filekirim_inputlaporankegiatan')
        ->store('izin/kirim', 'public');

    DB::transaction(function () use ($input, $laporan, $identitas, $filePath) {

        Izin_Kirimlaporankegiatans::create([
            'inputlaporankegiatan_id' => $input->id,
            'identitassurat_id' => $identitas->id,
            'filekirim_inputlaporankegiatan' => $filePath,
            'tanggalkirim_inputlaporankegiatan' => now(),
            'nipadmin_inputlaporankegiatan' => Auth::user()->nip,
            'statuslaporan_kegiatan' => 'need_review',
        ]);

        $laporan->update([
            'statuslaporan_kegiatan' => 'need_review',
        ]);
    });

    return redirect()->route('admin.laporankegiatan.index')
        ->with('success', 'Laporan berhasil dikirim');
}
}