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

        // Arsip
        'admin_archived_at',
        'superadmin_archived_at',
    ];

    /* ========== RELATIONS ========== */

    public function subunitkerjas()
    {
        return $this->belongsTo(Izin_RefSubunitkerjas::class, 'subunitkerja_id');
    }

    public function dibuatoleh()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function inputusulankegiatans()
    {
        return $this->hasOne(Izin_Inputusulankegiatans::class, 'usulankegiatan_id');
    }

    public function inputlaporankegiatans()
    {
        return $this->hasOne(Izin_Inputlaporankegiatans::class, 'inputusulankegiatan_id', 'id');
    }

    public function cetakusulankegiatans()
    {
        return $this->hasOne(Izin_Cetakusulankegiatans::class, 'inputusulankegiatan_id');
    }

    public function detailusulankegiatans()
    {
        return $this->hasOne(Izin_Detailusulankegiatans::class, 'usulankegiatan_id');
    }

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

    /* ======================= ASSESSOR STATUS UI USULAN KEGIATAN ======================= */

    public function getStatusUiAttribute()
    {
        // Jika laporan kegiatan "Completed" maka beralih ke status laporan kegiatan
        if ($this->inputlaporankegiatans && $this->inputlaporankegiatans->laporankegiatans) {
            return $this->inputlaporankegiatans->laporankegiatans->status_laporan_ui;
        }

        // Jika verifikasi usulan kegiatan "Rejected"
        if ($this->verifikasiusulankegiatanterakhir && $this->verifikasiusulankegiatanterakhir->status_verifikasiusulankegiatan === 'rejected') {
            return 'rejected';
        }

        // Jika sudah upload bukti pelaksanaan kegiatan
        if ($this->inputusulankegiatans?->pelaksanaankegiatans) {
            return 'in_progress';
        }

        // Jika verifikasi usulan kegiatan "Accepted" dan belum upload bukti pelaksanaan kegiatan
        if ($this->verifikasiusulankegiatanterakhir && $this->verifikasiusulankegiatanterakhir->status_verifikasiusulankegiatan === 'accepted') {
            return 'accepted';
        }

        // Jika status usulan kegiatan "Draft" dan belum cetak usulan kegiatan
        if ($this->statususulan_kegiatan === 'draft' && !$this->cetakusulankegiatans) {
            return 'draft';
        }

        // Jika sudah cetak tapi belum kirim usulan kegiatan
        if ($this->statususulan_kegiatan === 'pending') {
            return 'pending';
        }

        // Jika sudah mengirim usulan kegiatan
        if ($this->statususulan_kegiatan === 'need_review') {
            return 'need_review';
        }

        // Jika tidak memenuhi semua ketentuan
        return 'unknown';
    }

    /* ======================= ASSESSOR ATRIBUT STATUS UI USULAN KEGIATAN ======================= */

    public function getStatusUiClassAttribute()
    {
        return match ($this->status_ui) {
            'draft' => 'px-3 py-1 text-xs rounded-full bg-purple-100 text-gray-500 font-medium',
            'pending' => 'px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-600 font-medium',
            'need_review' => 'px-3 py-1 text-xs rounded-full bg-orange-100 text-orange-600 font-medium',
            'revisi'      => 'px-3 py-1 text-xs rounded-full bg-red-100 text-red-600 font-medium',
            'rejected' => 'px-3 py-1 text-xs rounded-full bg-red-100 text-red-600 font-medium',
            'accepted' => 'px-3 py-1 text-xs rounded-full bg-green-100 text-green-600 font-medium',
            'in_progress' => 'px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-600 font-medium',
            default => 'px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-400 font-medium',
        };
    }

    /* ======================= ASSESSOR HELPER STATUS USULAN KEGIATAN ======================= */

    public function canEdit()
    {
        return in_array($this->status_ui, ['draft', 'rejected']);
    }

    public function canCetak()
    {
        return in_array($this->status_ui, ['draft', 'rejected']) && !$this->cetakusulankegiatans;
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
        return $this->balasanusulankegiatans && $this->balasanusulankegiatans->tanggalcetak_balasanusulankegiatan;
    }

    public function getSudahKirimAttribute()
    {
        return $this->balasanusulankegiatans && $this->balasanusulankegiatans->tanggalkirim_balasanusulankegiatan;
    }

    public function getBolehCetakAttribute()
    {
        return $this->status_ui === 'accepted' && !$this->sudah_cetak;
    }

    public function getBolehKirimAttribute()
    {
        return $this->status_ui === 'accepted' && $this->sudah_cetak && !$this->sudah_kirim;
    }

    /*public function isLaporan(): bool
    {
        return $this->inputlaporankegiatans() && $this->inputlaporankegiatans->laporankegiatans;
    }*/

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
        return $this->isReview() && !$this->inputlaporankegiatans;
    }

    public function isReviewLaporan(): bool
    {
        return $this->isReview() && $this->inputlaporankegiatans && $this->inputlaporankegiatans->laporankegiatans;
    }

    /* ======================= ASSESSOR ATRIBUT UNTUK KOP SURAT ======================= */

    public function getKopViewAttribute()
    {
        $kopsurat = $this->inputusulankegiatans?->kopunitkerjas;
        $jeniskopsurat = $this->detailusulankegiatans?->jeniskop_usulankegiatan;

        if (!$kopsurat || !$jeniskopsurat) return null;

        if ($jeniskopsurat === 'kop_gambar') {
            return [
                'type' => 'gambar',
                'value' => $kopsurat->kop_gambar
            ];
        }

        return [
            'type' => 'text',
            'value' => $kopsurat->kop_text
        ];
    }
}
