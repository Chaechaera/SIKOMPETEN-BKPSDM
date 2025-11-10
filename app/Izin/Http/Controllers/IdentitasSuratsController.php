<?php

namespace App\Izin\Http\Controllers;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Identitassurats;
use App\Izin\Models\Izin_Usulankegiatans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IdentitasSuratsController extends Controller
{
    /**
     * Tampilkan Form Bagian Identitas Surat Pada Form Ajukan Usulan Kegiatan
     */
    public function create()
    {
        return view('pages.usulankegitan.ajukan_usulan_kegiatan');
    }

    /**
     * Simpan Data Identitas Surat
     */

    public function store(Request $request)
{
    DB::transaction(function() use ($request) {

        // 1. Validasi request
        $validated = $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'perihal_surat' => 'required|string|max:255',
        ]);

        $validated['lampiran_surat'] = '1 bendel';

        // 2. Simpan data Identitas Surat
        $identitassurats = Izin_Identitassurats::create($validated);

        if (!$identitassurats->id) {
            throw new \Exception('Gagal menyimpan identitas surat');
        }

        // 3. Merge id ke request
        $request->merge(['identitassurat_id' => $identitassurats->id]);

        // 4. Panggil controller Usulan Kegiatan
        app(\App\Izin\Http\Controllers\Admin\UsulanKegiatansController::class)->store($request);

    });
}
}