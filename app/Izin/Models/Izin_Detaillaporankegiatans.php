<?php

namespace App\Izin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin_Detaillaporankegiatans extends Model
{
    use HasFactory;

    protected $table = 'izin_detaillaporankegiatans';

    protected $fillable = [
        'laporankegiatan_id',
        'rincian_laporan',
        'rundown_laporan',
        'peserta_laporan',
        'undangan_laporan',
        'materi_laporan',
        'daftarhadir_laporan',
        'dokumentasi_laporan',
        'gambardokumentasi_laporan',
        'outputkegiatan_laporan',
        'templatesertifikat_kegiatan',
    ];

    protected $casts = [
        'gambardokumentasi_laporan' => 'array',
    ];

    protected $with = [
        'pesertakegiatans'
    ];

    // RELATIONS
    public function laporankegiatans()
    {
        return $this->belongsTo(Izin_Laporankegiatans::class, 'laporankegiatan_id', 'id');
    }

    public function pesertakegiatans()
    {
        return $this->hasMany(Izin_Pesertakegiatans::class, 'detaillaporankegiatan_id');
    }
}
