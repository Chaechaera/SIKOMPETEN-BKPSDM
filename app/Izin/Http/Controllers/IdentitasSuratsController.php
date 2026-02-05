<?php

namespace App\Izin\Http\Controllers;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Identitassurats;
use App\Izin\Services\IdentitasSuratsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IdentitasSuratsController extends Controller
{
    /**
     * Simpan Data Identitas Surat
     */

    public function store(Request $request, IdentitasSuratsService $identitassuratservice)
    {
        //return DB::transaction(function () use ($identitassuratservice, $request, $id) {

            // 1. Validasi request
            $validated = $request->validate([
                'nomor_surat' => 'required|string|max:255',
                'tanggal_surat' => 'required|date',
                'perihal_surat' => 'required|string|max:255',
                'sifat_surat' => 'required|string|in:Penting,Rahasia',
            ]);

            return $identitassuratservice->create($validated);

            //$identitassurats = $identitassuratservice->create($validated);

            /*return response()->json([
                'identitassurat_id' => $identitassurats->id
            ]);*/

            /*$validated['lampiran_surat'] = '1 bendel';

            // 2. Simpan data Identitas Surat
            $identitassurats = Izin_Identitassurats::create($validated);

            if (!$identitassurats->id) {
                throw new \Exception('Gagal menyimpan identitas surat');
            }

            // 3. Merge id ke request
            $request->merge([
                'identitassurat_id' => $identitassurats->id,
                //'usulankegiatan_id' => $id
            ]);

            // 4. Panggil controller Usulan Kegiatan
            /*return app(\App\Izin\Http\Controllers\Admin\KirimUsulanKegiatansController::class)->store($request);*/

            // 4. Response terakhir ke browser
    /*return redirect()
        ->route($request->next_route) // 🔥 dinamis
        ->with([
            'identitassurat_id' => $identitassurats->id,
            'usulankegiatan_id' => $request->usulankegiatan_id,
        ]);*/
    }
}
