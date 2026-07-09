<?php

namespace App\Izin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin_Laporanpesertakegiatans extends Model
{
    use HasFactory;

    protected $table = 'izin_laporanpesertakegiatans';

    protected $fillable = [
        'pesertakegiatan_id',
        'sertifikat_id',
        'statuslaporan_pesertakegiatan',
        'catatanlaporan_pesertakegiatan',
        'uraianpeserta_kegiatan',
        'tujuanpeserta_kegiatan',
        'rangkumanpeserta_kegiatan',
        'kesimpulanpeserta_kegiatan',
        'hambatanpeserta_kegiatan',
        'solusipeserta_kegiatan',
        'dokumentasipeserta_kegiatan',
        'filepdfgenerate_path',
        'uploaded_at',
    ];

    protected $casts = [
        'dokumentasipeserta_kegiatan' => 'array',
    ];

    /* ========== RELATIONS ========== */

    public function pesertakegiatans()
    {
        return $this->belongsTo(Izin_Pesertakegiatans::class, 'pesertakegiatan_id');
    }

    public function sertifikats()
    {
        return $this->belongsTo(Izin_Sertifikats::class, 'sertifikat_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

        public function isNotifikasi(): bool
    {
        return $this->statuslaporan_pesertakegiatan === 'approved' || $this->statuslaporan_pesertakegiatan === 'rejected';
    }
}
