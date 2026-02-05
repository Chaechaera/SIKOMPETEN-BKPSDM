<?php

namespace App\Izin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin_Cetaklaporankegiatans extends Model
{
    use HasFactory;

    protected $table = 'izin_cetaklaporankegiatans';

    protected $fillable = [
        'inputlaporankegiatan_id',
        'nipadmin_cetaklaporankegiatan',
        'pjunitkerja_id',
        'ttdunitkerja_id',
        'stempelunitkerja_id',
        'statuslaporan_kegiatan'
    ];

    public function inputlaporankegiatans()
    {
        return $this->belongsTo(Izin_Inputlaporankegiatans::class, 'inputlaporankegiatan_id');
    }
}
