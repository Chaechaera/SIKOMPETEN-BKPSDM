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
        'tanggalcetak_balasanusulankegiatan'
    ];
}
