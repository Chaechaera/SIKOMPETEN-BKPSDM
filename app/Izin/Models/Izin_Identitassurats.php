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
        'sifat_surat',
    ];

    /* ========== RELATIONS ========== */
    
    public function kirimusulankegiatans()
    {
        return $this->hasOne(Izin_Kirimusulankegiatans::class, 'identitassurat_id');
    }

    public function kirimlaporankegiatans()
    {
        return $this->hasOne(Izin_Kirimlaporankegiatans::class, 'identitassurat_id');
    }
}
