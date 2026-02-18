<?php

namespace App\Izin\Models;

use App\Izin\Models\Izin_Pelaksanaankegiatans;
use App\Izin\Models\Izin_Usulankegiatans;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin_Inputusulankegiatans extends Model
{
    use HasFactory;

    protected $table = 'izin_inputusulankegiatans';

    protected $fillable = [
        'usulankegiatan_id',
        'pjunitkerja_id',
        'kopunitkerja_id',
        'nama_kegiatan'
    ];

    /* ========== RELATIONS ========== */

    public function usulankegiatans()
    {
        return $this->belongsTo(Izin_Usulankegiatans::class, 'usulankegiatan_id');
    }

    public function kopunitkerjas()
    {
        return $this->belongsTo(Izin_Kopunitkerjas::class, 'kopunitkerja_id');
    }

    public function narasumberKegiatan()
    {
        return $this->hasMany(Izin_Narasumberkegiatans::class, 'inputusulankegiatan_id');
    }

    public function cetakUsulanKegiatan()
    {
        return $this->hasOne(Izin_Cetakusulankegiatans::class, 'inputusulankegiatan_id');
    }

    public function kirimusulankegiatans()
    {
        return $this->hasOne(Izin_Kirimusulankegiatans::class, 'inputusulankegiatan_id');
    }

    public function pelaksanaankegiatans()
    {
        return $this->hasOne(Izin_Pelaksanaankegiatans::class, 'inputusulankegiatan_id');
    }
}
