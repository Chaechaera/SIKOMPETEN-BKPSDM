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
        'atribut_khusus',
        'rincian_laporan',
        'rundown_laporan',
        'penutup_laporan',
        'peserta_laporan',
        'linkundangan_laporan',
        'linkmateri_laporan',
        'linkdaftarhadir_laporan',
        'linkdokumentasi_laporan',
        'gambardokumentasi_laporan'
    ];

    protected $casts = [
        'gambardokumentasi_laporan' => 'array',
        'atribut_khusus' => 'array',
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
