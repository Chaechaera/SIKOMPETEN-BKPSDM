<?php

namespace App\Izin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin_Verifikasiusulankegiatans extends Model
{
    use HasFactory;

    protected $table = 'izin_verifikasiusulankegiatans';

    protected $fillable = [
        'usulankegiatan_id',
        'tanggalverifikasi_inputusulankegiatan',
        'nipadmin_verifikasiusulankegiatan',
        'catatan_verifikasiusulankegiatan',
        'status_verifikasiusulankegiatan',
        'is_read',
        'read_at'
    ];

    public function usulankegiatans()
    {
        return $this->belongsTo(Izin_Usulankegiatans::class, 'usulankegiatan_id');
    }
}
