<?php

namespace App\Izin\Models;

use App\Izin\Models\Izin_Inputlaporankegiatans;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin_Laporankegiatans extends Model
{
    use HasFactory;

    protected $table = 'izin_laporankegiatans';

    protected $fillable = [
        'lokasi_kegiatan',
        'tanggalmulai_kegiatan',
        'tanggalselesai_kegiatan',
        'waktumulai_kegiatan',
        'waktuselesai_kegiatan',
        'statuslaporan_kegiatan'
    ];

    // RELATIONS
    /*public function usulankegiatans()
    {
        return $this->belongsTo(Izin_Usulankegiatans::class, 'usulankegiatan_id');
    }*/

    public function inputlaporankegiatans()
    {
        return $this->hasOne(Izin_Inputlaporankegiatans::class, 'laporankegiatan_id', 'id');
    }

    public function metodepelatihans() 
    {
        return $this->belongsTo(Izin_RefMetodepelatihans::class, 'metodepelatihan_id');
    }

    public function detaillaporankegiatans()
    {
        return $this->hasOne(Izin_Detaillaporankegiatans::class, 'laporankegiatan_id')->withDefault();
    }

    public function cetaklaporankegiatans()
    {
        return $this->hasOne(Izin_Cetaklaporankegiatans::class, 'inputlaporankegiatan_id');
    }

    /*public function balasanlaporankegiatans()
    {
        return $this->hasOne(Izin_Kirimbalasanusulankegiatans::class, 'inputusulankegiatan_id');
    }

    public function verifikasilaporankegiatans()
    {
        return $this->hasMany(Izin_Verifikasiusulankegiatans::class, 'usulankegiatan_id');
    }

    public function verifikasilaporankegiatanterakhir()
    {
        return $this->hasOne(Izin_Verifikasiusulankegiatans::class, 'usulankegiatan_id')->latestOfMany('tanggalverifikasi_inputusulankegiatan');
    }

    public function identitassurats()
    {
        return $this->belongsTo(Izin_Identitassurats::class, 'identitassurat_id');
    }*/

    /* ======================= STATUS UI LAPORAN ======================= */
    public function getStatusLaporanUiAttribute()
    {
        // ✅ 5. SUDAH ADA PELAKSANAAN (HARUS DI ATAS)
        /*if ($this->pelaksanaankegiatans) {
            return 'in_progress';
        }*/

        // 6. Diterima tapi belum pelaksanaan
        if (
            $this->verifikasilaporankegiatanterakhir
            && $this->verifikasilaporankegiatanterakhir->status_verifikasilaporankegiatan === 'accepted'
        ) {
            return 'accepted';
        }

        // 1. Completed (belum cetak)
        if ($this->statuslaporan_kegiatan === 'completed' && !$this->cetaklaporankegiatans) {
            return 'completed';
        }

        // 2. Sudah dicetak tapi belum dikirim
        if ($this->statuslaporan_kegiatan === 'pending') {
            return 'pending';
        }

        // 3. Sudah dikirim (menunggu review)
        if ($this->statuslaporan_kegiatan === 'need_review') {
            return 'need_review';
        }
        return 'unknown';    
    }

    public function getStatusLaporanUiClassAttribute()
    {
        return match ($this->status_laporan_ui) {
            'completed' => 'text-purple-600',
            'pending'     => 'text-yellow-600',
            'need_review' => 'text-blue-600',
            'revisi'      => 'text-red-600',
            'rejected' => 'text-red-600',
            'accepted' => 'text-green-600',
            'finish' => 'text-emerald-700',
            default       => 'text-gray-400',
        };
    }

    /* ======================= AKSI LAPORAN ======================= */
    public function canEditLaporan()
    {
        return in_array($this->status_laporan_ui, ['completed', 'rejected']);
    }

    public function canCetakLaporan()
    {
        return in_array($this->status_laporan_ui, ['completed', 'rejected'])
            && !$this->cetaklaporankegiatans;
    }

    public function canKirimLaporan()
    {
        return $this->status_laporan_ui === 'pending';
    }

    /*public function canEditLaporan(): bool
    {
        return $this->statuslaporan_kegiatan === 'accepted';
    }

    public function canCetakLaporan(): bool
    {
        return $this->statuslaporan_kegiatan === 'completed';
    }

    public function canKirimLaporan(): bool
    {
        return $this->statuslaporan_kegiatan === 'pending';
    }

    public function canUpdateLaporan(): bool
    {
        return in_array($this->statuslaporan_kegiatan, ['completed']);
    }*/

    public function getSudahCetakLaporanAttribute()
    {
        return $this->balasanlaporankegiatans
            && $this->balasanlaporankegiatans->tanggalcetak_balasanlaporankegiatan;
    }

    public function getSudahKirimLaporanAttribute()
    {
        return $this->balasanlaporankegiatans
            && $this->balasanlaporankegiatans->tanggalkirim_balasanlaporankegiatan;
    }

    public function getBolehCetakLaporanAttribute()
    {
        return $this->status_laporan_ui === 'accepted'
            && !$this->sudah_cetakLaporan;
    }

    public function getBolehKirimLaporanAttribute()
    {
        return $this->status_laporan_ui === 'accepted'
            && $this->sudah_cetakLaporan
            && !$this->sudah_kirimLaporan;
    }
}
