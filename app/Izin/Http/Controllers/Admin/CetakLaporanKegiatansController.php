<?php

namespace App\Izin\Http\Controllers\Admin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Cetaklaporankegiatans;
use App\Izin\Models\Izin_Usulankegiatans;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CetakLaporanKegiatansController extends Controller
{
    public function store($id)
    {
        $usulan = Izin_Usulankegiatans::with([
            'inputlaporankegiatans.laporankegiatans'
            //'laporankegiatans.detaillaporankegiatans'
        ])->findOrFail($id);

        $input = $usulan->inputlaporankegiatans;

        $laporan = $input->laporankegiatans;

        if ($laporan->statuslaporan_kegiatan !== 'completed') {
            abort(403, 'Laporan Kegiatan Sudah Dicetak');
        }

        /*$usulan = Izin_Usulankegiatans::findOrFail($id);

        if ($usulan->statususulan_kegiatan !== 'completed') {
            abort(403, 'Sudah Dicetak');
        }*/

        DB::transaction(function () use ($laporan, $input, $usulan) {

            $user = Auth::user();

            Izin_Cetaklaporankegiatans::create([
                'inputlaporankegiatan_id' => $input->id,
                'nipadmin_cetaklaporankegiatan' => $user->nip,
                'pjunitkerja_id' => $user->id,
                'statuslaporan_kegiatan' => 'pending',
            ]);

            $laporan->update([
                'statuslaporan_kegiatan' => 'pending'
            ]);
        });

        return redirect()
            ->route('admin.laporankegiatan.download', $usulan->id)
            ->with('success', 'Usulan berhasil dicetak.');
    }
}
