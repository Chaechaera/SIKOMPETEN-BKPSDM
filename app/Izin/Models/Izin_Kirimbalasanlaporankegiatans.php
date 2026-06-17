<?php

namespace App\Izin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin_Kirimbalasanlaporankegiatans extends Model
{
    use HasFactory;

    protected $table = 'izin_kirimbalasanlaporankegiatans';

    protected $fillable = [
        'inputlaporankegiatan_id',
        'identitassurat_id',
        'nipadmin_kirimbalasanlaporankegiatan',
        'filekirim_balasanlaporankegiatan',
        'tanggalkirim_balasanlaporankegiatan',
        'nipadmin_cetakbalasanlaporankegiatan',
        'tanggalcetak_balasanlaporankegiatan'
    ];

    public function identitassurats()
    {
        return $this->belongsTo(Izin_Identitassurats::class, 'identitassurat_id');
    }
}
