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
        'totalcapaianjp_kegiatan'
    ]; 

    // RELATION
    public function identitassurats()
    {
        return $this->belongsTo(Izin_Identitassurats::class, 'identitassurat_id');
    }

    public function usulankegiatans()
    {
        return $this->belongsTo(Izin_Usulankegiatans::class, 'usulankegiatan_id');
    }

    public function laporankegiatans()
    {
        return $this->belongsTo(Izin_Laporankegiatans::class, 'laporankegiatan_id');
    }

    public function sertifikats()
    {
        return $this->belongsTo(Izin_Sertifikats::class, 'sertifikat_id');
    }
}
