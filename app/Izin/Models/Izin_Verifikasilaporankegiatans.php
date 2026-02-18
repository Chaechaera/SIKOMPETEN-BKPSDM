<?php

namespace App\Izin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin_Verifikasilaporankegiatans extends Model
{
    use HasFactory;

    protected $table = 'izin_verifikasilaporankegiatans';

    protected $fillable = [
        'laporankegiatan_id',
        'tanggalverifikasi_inputlaporankegiatan',
        'nipadmin_verifikasilaporankegiatan',
        'catatan_verifikasilaporankegiatan',
        'status_verifikasilaporankegiatan',
        'is_read',
        'read_at'
    ];

    /* ========== RELATIONS ========== */
    
    public function laporankegiatans()
    {
        return $this->belongsTo(Izin_Laporankegiatans::class, 'laporankegiatan_id');
    }
}
