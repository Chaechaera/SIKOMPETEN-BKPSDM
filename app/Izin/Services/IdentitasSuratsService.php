<?php

namespace App\Izin\Services;

use App\Izin\Models\Izin_Identitassurats;
use Illuminate\Validation\ValidationException;

class IdentitasSuratsService
{
    /**
     * Buat dan Simpan Data Identitas Surat
     */
    public function create(array $data): Izin_Identitassurats
    {
        // CEK DUPLIKAT
    $exists = Izin_Identitassurats::where('nomor_surat', $data['nomor_surat'])->exists();

    if ($exists) {
        throw ValidationException::withMessages([
            'nomor_surat' => 'Nomor surat sudah digunakan.'
        ]);
    }
        return Izin_Identitassurats::create([
            'nomor_surat'    => $data['nomor_surat'],
            'tanggal_surat'  => $data['tanggal_surat'],
            'perihal_surat'  => $data['perihal_surat'],
            'sifat_surat'    => $data['sifat_surat'],
            'lampiran_surat' => $data['lampiran_surat'] ?? '1 bendel',
        ]);
    }
}
