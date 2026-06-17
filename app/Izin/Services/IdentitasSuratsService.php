<?php

namespace App\Izin\Services;

use App\Izin\Models\Izin_Identitassurats;

class IdentitasSuratsService
{
    /**
     * Buat dan Simpan Data Identitas Surat
     */
    public function create(array $data): Izin_Identitassurats
    {
        return Izin_Identitassurats::create([
            'nomor_surat'    => $data['nomor_surat'],
            'tanggal_surat'  => $data['tanggal_surat'],
            'perihal_surat'  => $data['perihal_surat'],
            'sifat_surat'    => $data['sifat_surat'],
            'lampiran_surat' => $data['lampiran_surat'] ?? '1 bendel',
        ]);
    }
}
