<?php

namespace App\Izin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin_Cetakusulankegiatans extends Model
{
    use HasFactory;

    protected $table = 'izin_cetakusulankegiatans';

    protected $fillable = [
        'inputusulankegiatan_id',
        'nipadmin_cetakusulankegiatan',
        'pjunitkerja_id',
        'ttdunitkerja_id',
        'stempelunitkerja_id',
        'statususulan_kegiatan'
    ];

    /* ========== RELATIONS ========== */
    
    public function inputusulankegiatans()
    {
        return $this->belongsTo(Izin_Inputusulankegiatans::class, 'inputusulankegiatan_id');
    }
}
