<?php

namespace App\Izin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

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

    // 🔗 RELASI

    public function inputlaporankegiatans()
    {
        return $this->belongsTo(Izin_Inputlaporankegiatans::class, 'inputlaporankegiatan_id');
    }

    public function identitassurats()
    {
        return $this->belongsTo(Izin_Identitassurats::class, 'identitassurat_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'nipadmin_kirimbalasanlaporankegiatan', 'nip');
    }
}