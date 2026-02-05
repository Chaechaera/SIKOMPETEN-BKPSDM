<?php

namespace App\Izin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin_Kirimlaporankegiatans extends Model
{
    use HasFactory;

    protected $table = 'izin_kirimlaporankegiatans';

    protected $fillable = [
        'inputlaporankegiatan_id',
        'identitassurat_id',
        'filekirim_inputlaporankegiatan',
        'tanggalkirim_inputlaporankegiatan',
        'nipadmin_inputlaporankegiatan',
        'statuslaporan_kegiatan'
    ];

    public function identitassurats()
    {
        return $this->belongsTo(Izin_Identitassurats::class, 'identitassurat_id');
    }
}
