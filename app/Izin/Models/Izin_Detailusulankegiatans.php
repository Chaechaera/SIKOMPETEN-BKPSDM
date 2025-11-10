<?php

namespace App\Izin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin_Detailusulankegiatans extends Model
{
    use HasFactory;

    protected $table = 'izin_detailusulankegiatans';

    protected $fillable = [
        'usulankegiatan_id',
        'latarbelakang_kegiatan',
        'dasarhukum_kegiatan',
        'uraian_kegiatan',
        'maksud_kegiatan',
        'tujuan_kegiatan',
        'hasil_kegiatan',
        'narasumber_kegiatan',
        'peserta_kegiatan',
        'alokasianggaran_kegiatan',
        'jadwalpelaksanaan_kegiatan',
        'metodepelatihan_id',
    ];

    // RELATIONS
    public function usulankegiatans()
    {
        return $this->belongsTo(Izin_Usulankegiatans::class, 'identitassurat_id');
    }

    public function metodepelatihans() 
    {
        return $this->belongsTo(Izin_RefMetodepelatihans::class, 'metodepelatihan_id');
    }
}
