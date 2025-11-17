<?php

namespace App\Izin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin_Laporankegiatans extends Model
{
    use HasFactory;

    protected $table = 'izin_laporankegiatans';

    protected $fillable = [
        'usulankegiatan_id',
        'identitassurat_id',
        'carapelatihan_id',
        'atribut_khusus',
        'waktupelaksanaan_laporan',
        'latarbelakang_laporan',
        'dasarhukum_laporan',
        'maksud_laporan',
        'tujuan_laporan',
        'ruanglingkup_laporan',
        'metodepelatihan_id',
        'narasumber_laporan',
        'penutup_laporan',
    ];

    protected $casts = [
        'atribut_khusus' => 'array',
    ];

    // RELATIONS
    public function usulankegiatans()
    {
        return $this->belongsTo(Izin_Usulankegiatans::class, 'usulankegiatan_id');
    }

    public function metodepelatihans() 
    {
        return $this->belongsTo(Izin_RefMetodepelatihans::class, 'metodepelatihan_id');
    }

    public function detaillaporankegiatans()
    {
        return $this->hasOne(Izin_Detaillaporankegiatans::class, 'laporankegiatan_id');
    }

    public function identitassurats()
    {
        return $this->belongsTo(Izin_Identitassurats::class, 'identitassurat_id');
    }
}
