<?php

namespace App\Izin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin_Balasanlaporankegiatans extends Model
{
    use HasFactory;

    protected $table = 'izin_balasanlaporankegiatans';

    protected $fillable = [
        'inputusulankegiatan_id',
        'inputlaporankegiatan_id',
        'sertifikat_id',
        'totalcapaianjp_kegiatan',
        'is_archived'
        
    ]; 

    /* ========== RELATIONS ========== */
    
    public function usulankegiatans()
    {
        return $this->belongsTo(Izin_Usulankegiatans::class, 'usulankegiatan_id');
    }

    public function laporankegiatans()
    {
        return $this->belongsTo(Izin_Laporankegiatans::class, 'inputlaporankegiatan_id');
    }

    public function sertifikats()
    {
        return $this->belongsTo(Izin_Sertifikats::class, 'sertifikat_id');
    }

public function balasanlaporankegiatans()
{
    return $this->hasOne(
        Izin_Kirimbalasanlaporankegiatans::class,
        'inputlaporankegiatan_id', // FK di tabel balasan
        'id' // PK di laporan
    );
}

public function inputlaporankegiatans()
{
    return $this->belongsTo(
        Izin_Inputlaporankegiatans::class,
        'inputlaporankegiatan_id'
    );
}
}
