<?php

namespace App\Izin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin_Laporanpesertakegiatans extends Model
{
    use HasFactory;

    protected $table = 'izin_laporanpesertakegiatans';

    protected $fillable = [
        'pesertakegiatan_id',
        'sertifikat_id',
        'filelaporan_pesertakegiatan',
        'statuslaporan_pesertakegiatan',
        'uploaded_at',
    ];

    /* ========== RELATIONS ========== */

    public function pesertakegiatans()
    {
        return $this->belongsTo(Izin_Pesertakegiatans::class, 'pesertakegiatan_id');
    }

    public function sertifikats()
    {
        return $this->belongsTo(Izin_Sertifikats::class, 'sertifikat_id');
    }

    public function users()
{
    return $this->belongsTo(User::class, 'user_id');
}

}
