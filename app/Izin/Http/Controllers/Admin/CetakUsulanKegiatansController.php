<?php

namespace App\Izin\Http\Controllers\Admin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Cetakusulankegiatans;
use App\Izin\Models\Izin_Usulankegiatans;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CetakUsulanKegiatansController extends Controller
{
    public function store($id)
    {
        $usulan = Izin_Usulankegiatans::findOrFail($id);

        if ($usulan->statususulan_kegiatan !== 'draft') {
            abort(403, 'Sudah Dicetak');
        }

        DB::transaction(function () use ($usulan) {

            $user = Auth::user();

            Izin_Cetakusulankegiatans::create([
                'inputusulankegiatan_id' => $usulan->inputusulankegiatans->id,
                'nipadmin_cetakusulankegiatan' => $user->nip,
                'pjunitkerja_id' => $user->id,
                'statususulan_kegiatan' => 'pending',
            ]);

            $usulan->update([
                'statususulan_kegiatan' => 'pending'
            ]);
        });

        return redirect()
            ->route('admin.usulankegiatan.download', $usulan->id)
            ->with('success', 'Usulan berhasil dicetak.');
    }
}
