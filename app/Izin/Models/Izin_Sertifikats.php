<?php

namespace App\Izin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin_Sertifikats extends Model
{
    use HasFactory;

    protected $table = 'izin_sertifikats';

    protected $fillable = [
        'laporankegiatan_id',
        'inputusulankegiatan_id',
        'templatesertifikat_kegiatan',
        'fieldstemplatesertifikat_kegiatan',
        'nomorsertifikat_kegiatan',
        'tanggalkeluarsertifikat_kegiatan',
    ];

    protected $casts = [
        'fieldstemplatesertifikat_kegiatan' => 'array',
    ];

    /* ========== RELATIONS ========== */
    
    public function balasanlaporankegiatans()
    {
        return $this->hasOne(Izin_Balasanlaporankegiatans::class, 'sertifikat_id');
    }

    public function inputusulankegiatans()
    {
        return $this->belongsTo(Izin_Usulankegiatans::class, 'inputusulankegiatan_id');
    }

    public function laporankegiatans()
    {
        return $this->belongsTo(Izin_Laporankegiatans::class, 'laporankegiatan_id');
    }

    public function pesertakegiatans()
    {
        return $this->hasMany(Izin_Pesertakegiatans::class, 'sertifikat_id');
    }
}
