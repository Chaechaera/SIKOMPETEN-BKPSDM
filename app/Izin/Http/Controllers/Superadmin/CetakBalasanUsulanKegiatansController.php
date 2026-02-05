<?php

namespace App\Izin\Http\Controllers\Superadmin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Kirimbalasanusulankegiatans;
use App\Izin\Models\Izin_Usulankegiatans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CetakBalasanUsulanKegiatansController extends Controller
{
    public function store($id)
{
    $usulan = Izin_Usulankegiatans::with([
        'verifikasiusulankegiatanterakhir',
        'cetakusulankegiatans',
        'inputusulankegiatans'
    ])->findOrFail($id);

    /*if (
        !$usulan->verifikasiusulankegiatanterakhir ||
        $usulan->verifikasiusulankegiatanterakhir->status_verifikasiusulankegiatan !== 'accepted'
    ) {
        abort(403, 'Usulan belum disetujui');
    }

    if ($usulan->cetakusulankegiatans) {
        abort(403, 'Balasan sudah pernah dicetak');
    }*/

    DB::transaction(function () use ($usulan) {
        $user = Auth::user();

        Izin_Kirimbalasanusulankegiatans::updateOrCreate([
            'inputusulankegiatan_id' => $usulan->inputusulankegiatans->id,], [
            'nipadmin_cetakbalasanusulankegiatan' => $user->nip,
            'tanggalcetak_balasanusulankegiatan' => now(),
        ]);
    });

    return redirect()
        ->route('superadmin.usulankegiatan.downloadBalasan', $usulan->id)
        ->with('success', 'Usulan berhasil dicetak.');
}

}
