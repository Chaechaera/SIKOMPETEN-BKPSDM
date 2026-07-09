<?php

namespace App\Izin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin_Kirimbalasanusulankegiatans extends Model
{
    use HasFactory;

    protected $table = 'izin_kirimbalasanusulankegiatans';

    protected $fillable = [
        'inputusulankegiatan_id',
        'identitassurat_id',
        'nipadmin_kirimbalasanusulankegiatan',
        'filekirim_balasanusulankegiatan',
        'tanggalkirim_balasanusulankegiatan',
        'nipadmin_cetakbalasanusulankegiatan',
        'tanggalcetak_balasanusulankegiatan',
        'filepdfgenerate_path',
    ];

    public function inputusulankegiatans()
    {
        return $this->belongsTo(Izin_Inputusulankegiatans::class, 'inputusulankegiatan_id');
    }

    public function identitassurats()
    {
        return $this->belongsTo(Izin_Identitassurats::class, 'identitassurat_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'nipadmin_kirimbalasanusulankegiatan', 'nip');
    }
}
