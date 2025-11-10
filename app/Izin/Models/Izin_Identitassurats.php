<?php

namespace App\Izin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin_Identitassurats extends Model
{
    use HasFactory;

    protected $table = 'izin_identitassurats';

    protected $fillable = [
        'nomor_surat',
        'tanggal_surat',
        'perihal_surat',
        'lampiran_surat',
    ];

    // RELATIONS
    public function usulankegiatans()
    {
        return $this->hasOne(Izin_Usulankegiatans::class, 'identitassurat_id');
    }
}
