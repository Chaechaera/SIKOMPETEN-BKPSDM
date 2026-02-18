<?php

namespace App\Izin\Models;

use App\Izin\Models\Izin_Laporankegiatans;
use App\Izin\Models\Izin_Pelaksanaankegiatans;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin_Inputlaporankegiatans extends Model
{
    use HasFactory;

    protected $table = 'izin_inputlaporankegiatans';

    protected $fillable = [
        'inputusulankegiatan_id',
        'laporankegiatan_id',
        'kirimbalasanlaporankegiatan_id'
    ];

    /* ========== RELATIONS ========== */

    public function laporankegiatans()
    {
        return $this->belongsTo(Izin_Laporankegiatans::class, 'laporankegiatan_id');
    }

    public function inputusulankegiatans()
    {
        return $this->belongsTo(Izin_Inputusulankegiatans::class, 'inputusulankegiatan_id');
    }

    public function kirimlaporankegiatans()
    {
        return $this->hasOne(Izin_Kirimlaporankegiatans::class, 'inputlaporankegiatan_id');
    }

    public function pelaksanaanKegiatan()
    {
        return $this->belongsTo(Izin_Pelaksanaankegiatans::class, 'pelaksanaankegiatan_id');
    }
}
