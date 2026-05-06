<?php

namespace App\Izin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin_Pelaksanaankegiatans extends Model
{
    use HasFactory;

    protected $table = 'izin_pelaksanaankegiatans';

    protected $fillable = [
        'inputusulankegiatan_id',
        'buktipelaksanaan_kegiatan',
        'catatan_pelaksanaan',
        'hambatan_pelaksanaan',
        'solusi_hambatan_pelaksanaan',
    ];

    protected $casts = [
        'buktipelaksanaan_kegiatan' => 'array',
    ];

    /* ========== RELATIONS ========== */

    public function inputusulankegiatans()
    {
        return $this->belongsTo(Izin_Inputusulankegiatans::class, 'inputusulankegiatan_id');
    }
}
