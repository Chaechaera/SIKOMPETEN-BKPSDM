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
        'hasillangsung_kegiatan',
        'hasilmenengah_kegiatan',
        'hasilpanjang_kegiatan',
        'narasumber_kegiatan',
        'sasaranpeserta_kegiatan',
        'alokasianggaran_kegiatan',
        'jadwalpelaksanaan_kegiatan',
        'metodepelatihan_id',
        'detailhasil_kegiatan',
        'penyelenggara_kegiatan',
        'penutup_kegiatan'
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
}
