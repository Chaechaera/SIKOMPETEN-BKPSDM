<?php

namespace App\Izin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin_Pelaksanaankegiatans extends Model
{
    use HasFactory;

    protected $table = 'izin_pelaksanaankegiatans';

    protected $fillable = [
        'usulankegiatan_id',
        'buktipelaksanaan_kegiatan',
    ];

    // Untuk mengubah kolom JSON jadi array saat diakses
    protected $casts = [
        'buktipelaksanaan_kegiatan' => 'array',
    ];

    // RELATIONS
    public function usulankegiatans()
    {
        return $this->belongsTo(Izin_Usulankegiatans::class, 'identitassurat_id');
    }
}
