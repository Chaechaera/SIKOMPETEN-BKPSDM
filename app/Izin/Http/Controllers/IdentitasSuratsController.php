<?php

namespace App\Izin\Http\Controllers;

use App\Izin\Http\Controllers\Controller;
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
        // Validasi request
        $validated = $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'perihal_surat' => 'required|string|max:255',
            'sifat_surat' => 'required|string|in:Penting,Rahasia',
        ]);

        // Return ke service identitassurat
        return $identitassuratservice->create($validated);
    }
}
