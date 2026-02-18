<?php

namespace App\Izin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin_Kirimusulankegiatans extends Model
{
    use HasFactory;

    protected $table = 'izin_kirimusulankegiatans';

    protected $fillable = [
        'inputusulankegiatan_id',
        'identitassurat_id',
        'filekirim_inputusulankegiatan',
        'tanggalkirim_inputusulankegiatan',
        'nipadmin_inputusulankegiatan',
        'statususulan_kegiatan'
    ];

    /* ========== RELATIONS ========== */
    
    public function identitassurats()
    {
        return $this->belongsTo(Izin_Identitassurats::class, 'identitassurat_id');
    }

    public function inputusulankegiatans()
    {
        return $this->belongsTo(Izin_Inputusulankegiatans::class, 'inputusulankegiatan_id');
    }
}
