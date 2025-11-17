<?php

namespace App\Izin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin_Usulankegiatans extends Model
{
    use HasFactory;

    protected $table = 'izin_usulankegiatans';

    protected $fillable = [
        'identitassurat_id',
        'subunitkerja_id',
        'nama_kegiatan',
        'lokasi_kegiatan',
        'carapelatihan_id',
        'tanggalpelaksanaan_kegiatan',
        'statususulan_kegiatan',
        'dibuat_oleh'
    ];

    // RELATION
    public function subunitkerjas()
    {
        return $this->belongsTo(Izin_RefSubunitkerjas::class, 'subunitkerja_id');
    }

    public function identitassurats()
    {
        return $this->belongsTo(Izin_Identitassurats::class, 'identitassurat_id');
    }

    public function dibuatoleh()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function detailusulankegiatans()
    {
        return $this->hasOne(Izin_Detailusulankegiatans::class, 'usulankegiatan_id');
    }

    public function pelaksanaankegiatans()
    {
        return $this->hasOne(Izin_Pelaksanaankegiatans::class, 'usulankegiatan_id');
    }

    public function laporankegiatans()
    {
        return $this->hasOne(Izin_Laporankegiatans::class, 'usulankegiatan_id');
    }

    public function carapelatihans()
    {
        return $this->belongsTo(Izin_RefCarapelatihans::class, 'carapelatihan_id');
    }
}
