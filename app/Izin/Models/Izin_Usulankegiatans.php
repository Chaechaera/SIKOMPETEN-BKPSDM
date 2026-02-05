<?php

namespace App\Izin\Models;

use App\Izin\Models\Izin_Inputusulankegiatans;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin_Usulankegiatans extends Model
{
    use HasFactory;

    protected $table = 'izin_usulankegiatans';

    protected $fillable = [
        'subunitkerja_id',
        'unitkerja_id',
        'lokasi_kegiatan',
        'carapelatihan_id',
        'tanggalmulai_kegiatan',
        'tanggalselesai_kegiatan',
        'waktumulai_kegiatan',
        'waktuselesai_kegiatan',
        'statususulan_kegiatan',
        'dibuat_oleh',
        //'detailusulankegiatan_id'
    ];

    // RELATION
    public function subunitkerjas()
    {
        return $this->belongsTo(Izin_RefSubunitkerjas::class, 'subunitkerja_id');
    }

    /**public function identitassurats()
    {
        return $this->belongsTo(Izin_Identitassurats::class, 'identitassurat_id');
    }**/

    public function dibuatoleh()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    // 1 Usulan -> 1 Input Usulan
    public function inputusulankegiatans()
    {
        return $this->hasOne(Izin_Inputusulankegiatans::class, 'usulankegiatan_id');
    }

    /*public function inputlaporankegiatans()
{
    return $this->hasOne(
        Izin_Inputlaporankegiatans::class,
        'usulankegiatan_id'
    );
}*/

    public function inputlaporankegiatans()
    {
        return $this->hasOne(
            Izin_Inputlaporankegiatans::class,
            'inputusulankegiatan_id',
            'id'
        );
    }

    public function cetakusulankegiatans()
    {
        return $this->hasOne(Izin_Cetakusulankegiatans::class, 'inputusulankegiatan_id');
    }

    public function detailusulankegiatans()
    {
        return $this->hasOne(Izin_Detailusulankegiatans::class, 'usulankegiatan_id');
    }

    public function pelaksanaankegiatans()
    {
        return $this->hasOne(Izin_Pelaksanaankegiatans::class, 'usulankegiatan_id');
    }

    /*public function laporankegiatans()
    {
        return $this->hasOne(Izin_Laporankegiatans::class, 'usulankegiatan_id');
    }*/

    public function carapelatihans()
    {
        return $this->belongsTo(Izin_RefCarapelatihans::class, 'carapelatihan_id');
    }

    public function balasanusulankegiatans()
    {
        return $this->hasOne(Izin_Kirimbalasanusulankegiatans::class, 'inputusulankegiatan_id');
    }

    public function verifikasiusulankegiatans()
    {
        return $this->hasMany(Izin_Verifikasiusulankegiatans::class, 'usulankegiatan_id');
    }

    public function verifikasiusulankegiatanterakhir()
    {
        return $this->hasOne(Izin_Verifikasiusulankegiatans::class, 'usulankegiatan_id')->latestOfMany('tanggalverifikasi_inputusulankegiatan');
    }

    /* ======================= STATUS UI (VIRTUAL) ======================= */
    /*public function getStatusLaporanUiAttribute()
{
    return $this->inputlaporankegiatans?->laporankegiatans?->status_laporan_ui;
}

public function getStatusLaporanUiClassAttribute()
{
    return $this->inputlaporankegiatans?->laporankegiatans?->status_laporan_ui_class;
}*/

    public function getStatusUiAttribute()
    {
        // 🔥 PRIORITAS TERTINGGI: LAPORAN COMPLETED
        if (
            $this->inputlaporankegiatans
            && $this->inputlaporankegiatans->laporankegiatans
        ) {
            return $this->inputlaporankegiatans->laporankegiatans->status_laporan_ui;
        }

        // ===================== PRIORITAS TERTINGGI =====================
        // JIKA SUDAH ADA LAPORAN → STATUS LAPORAN
        /*if (
        $this->inputlaporankegiatans &&
        $this->inputlaporankegiatans->laporankegiatans
    ) {
        return 'laporan_' . $this
            ->inputlaporankegiatans
            ->laporankegiatans
            ->status_laporan_ui;
    }*/

        // 4. Ditolak verifikasi
        if (
            $this->verifikasiusulankegiatanterakhir
            && $this->verifikasiusulankegiatanterakhir->status_verifikasiusulankegiatan === 'rejected'
        ) {
            return 'rejected';
        }

        // ✅ 5. SUDAH ADA PELAKSANAAN (HARUS DI ATAS)
        if ($this->pelaksanaankegiatans) {
            return 'in_progress';
        }

        // 6. Diterima tapi belum pelaksanaan
        if (
            $this->verifikasiusulankegiatanterakhir
            && $this->verifikasiusulankegiatanterakhir->status_verifikasiusulankegiatan === 'accepted'
        ) {
            return 'accepted';
        }

        // 1. Draft (belum cetak)
        if ($this->statususulan_kegiatan === 'draft' && !$this->cetakusulankegiatans) {
            return 'draft';
        }

        // 2. Sudah dicetak tapi belum dikirim
        if ($this->statususulan_kegiatan === 'pending') {
            return 'pending';
        }

        // 3. Sudah dikirim (menunggu review)
        if ($this->statususulan_kegiatan === 'need_review') {
            return 'need_review';
        }
        return 'unknown';
    }

    public function getStatusUiClassAttribute()
    {
        return match ($this->status_ui) {
            'draft' => 'text-gray-500',
            'pending' => 'text-yellow-600',
            'need_review' => 'text-orange-600',
            'rejected' => 'text-red-600',
            'accepted' => 'text-green-600',
            'in_progress' => 'text-blue-600',
            //'completed' => 'text-purple-600',
            //'finish' => 'text-emerald-700',
            default => 'text-gray-400',
        };
    }


    public function canEdit()
    {
        return in_array($this->status_ui, ['draft', 'rejected']);
    }

    public function canCetak()
    {
        return in_array($this->status_ui, ['draft', 'rejected'])
            && !$this->cetakusulankegiatans;
    }

    public function canKirim()
    {
        return $this->status_ui === 'pending';
    }

    public function canUploadPelaksanaan()
    {
        return $this->status_ui === 'accepted';
    }

    public function canUploadLaporan()
    {
        return $this->status_ui === 'in_progress';
    }

    public function getSudahCetakAttribute()
    {
        return $this->balasanusulankegiatans
            && $this->balasanusulankegiatans->tanggalcetak_balasanusulankegiatan;
    }

    public function getSudahKirimAttribute()
    {
        return $this->balasanusulankegiatans
            && $this->balasanusulankegiatans->tanggalkirim_balasanusulankegiatan;
    }

    public function getBolehCetakAttribute()
    {
        return $this->status_ui === 'accepted'
            && !$this->sudah_cetak;
    }

    public function getBolehKirimAttribute()
    {
        return $this->status_ui === 'accepted'
            && $this->sudah_cetak
            && !$this->sudah_kirim;
    }

    public function isLaporan(): bool
    {
        return $this->inputlaporankegiatans
            && $this->inputlaporankegiatans->laporankegiatans;
    }

    public function isPendingUsulan(): bool
    {
        return $this->status_ui === 'pending' && !$this->isLaporan();
    }

    public function isPendingLaporan(): bool
    {
        return $this->status_ui === 'pending' && $this->isLaporan();
    }

    public function isReview(): bool
    {
        return $this->status_ui === 'need_review';
    }

    public function isReviewUsulan(): bool
    {
        return $this->isReview()
        && !$this->inputlaporankegiatans;
    }

    public function isReviewLaporan(): bool
    {
        return $this->isReview()
        && $this->inputlaporankegiatans
        && $this->inputlaporankegiatans->laporankegiatans;
    }
}
