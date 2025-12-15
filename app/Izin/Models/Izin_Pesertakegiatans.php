<?php

namespace App\Izin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin_Pesertakegiatans extends Model
{
    use HasFactory;

    protected $table = 'izin_pesertakegiatans';

    protected $fillable = [
        'detaillaporankegiatan_id', 
        'nama_peserta', 
        'nip_peserta', 
        'jabatan_peserta', 
        'subunitkerja_id_peserta',
        'sertifikat_id',
        'nomorsertifikatpeserta_kegiatan',
    ];

    // RELATION
    public function detaillaporankegiatans()
    {
        return $this->belongsTo(Izin_Detaillaporankegiatans::class, 'detaillaporankegiatan_id');
    }

    public function subunitkerjas()
    {
        return $this->belongsTo(Izin_RefSubunitkerjas::class, 'subunitkerja_id_peserta');
    }

    public function sertifikats()
    {
        return $this->belongsTo(Izin_Sertifikats::class, 'sertifikat_id');
    }
}
