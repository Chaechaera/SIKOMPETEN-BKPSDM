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

    /* ========== RELATIONS ========== */

    public function inputlaporankegiatans()
    {
        return $this->hasOne(Izin_Inputlaporankegiatans::class, 'laporankegiatan_id');
    }

    public function metodepelatihans()
    {
        return $this->belongsTo(Izin_RefMetodepelatihans::class, 'metodepelatihan_id');
    }

    public function detaillaporankegiatans()
{
    return $this->hasOne(Izin_Detaillaporankegiatans::class, 'laporankegiatan_id');
}

    public function sertifikats()
    {
        return $this->hasOne(Izin_Sertifikats::class, 'laporankegiatan_id');
    }

    public function cetaklaporankegiatans()
    {
        return $this->hasOne(Izin_Cetaklaporankegiatans::class, 'inputlaporankegiatan_id');
    }

    public function balasanlaporankegiatans()
    {
        return $this->hasOne(Izin_Kirimbalasanlaporankegiatans::class, 'inputlaporankegiatan_id');
    }

    public function verifikasilaporankegiatans()
    {
        return $this->hasMany(Izin_Verifikasilaporankegiatans::class, 'laporankegiatan_id');
    }

    public function verifikasilaporankegiatanterakhir()
{
    return $this->hasOne(Izin_Verifikasilaporankegiatans::class, 'laporankegiatan_id')
        ->orderByDesc('id');
}

    /* ======================= ASSESSOR STATUS UI LAPORAN KEGIATAN ======================= */

    public function getStatusLaporanUiAttribute()
    {
        $verif = $this->verifikasilaporankegiatanterakhir;

    // 🔥 kalau tidak ada verifikasi
    if (!$verif) {
        return $this->statuslaporan_kegiatan; 
        // jadi 'completed' tetap 'completed'
    }

        // Jika telah sampai tahap sertifikat dan balasan laporan kegiatan telah dibuat 
        if ($this->sertifikats && $this->balasanlaporankegiatans?->tanggalkirim_balasanlaporankegiatan) {
            return 'finish';
        }

         // Jika verifikasi laporan kegiatan "Rejected"
        if ($this->verifikasilaporankegiatanterakhir && $this->verifikasilaporankegiatanterakhir->status_verifikasilaporankegiatan === 'rejected') {
            return 'rejected';
        }

        // Jika verifikasi laporan kegiatan "Accepted"
        if ($this->verifikasilaporankegiatanterakhir && $this->verifikasilaporankegiatanterakhir->status_verifikasilaporankegiatan === 'accepted') {
            return 'accepted';
        }

        // Jika sudah mengirim laporan kegiatan
        if ($this->statuslaporan_kegiatan === 'need_review') {
            return 'need_review';
        }

        // Jika sudah cetak tapi belum kirim laporan kegiatan
        if ($this->statuslaporan_kegiatan === 'pending') {
            return 'pending';
        }

        // Jika status laporan kegiatan "Completed" dan belum cetak laporan kegiatan
        if ($this->statuslaporan_kegiatan === 'completed' && !$this->cetaklaporankegiatans) {
            return 'completed';
        }

        // Jika tidak memenuhi semua ketentuan
        return 'unknown';
    }

    /* ======================= ASSESSOR ATRIBUT STATUS UI LAPORAN KEGIATAN ======================= */

    public function getStatusLaporanUiClassAttribute()
    {
        return match ($this->status_laporan_ui) {
            'completed' => 'px-3 py-1 text-xs rounded-full bg-purple-100 text-gray-500 font-medium',
            'pending'     => 'px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-600 font-medium',
            'need_review' => 'px-3 py-1 text-xs rounded-full bg-orange-100 text-orange-600 font-medium',
            'revisi'      => 'px-3 py-1 text-xs rounded-full bg-red-100 text-red-600 font-medium',
            'rejected' => 'px-3 py-1 text-xs rounded-full bg-red-100 text-red-600 font-medium',
            'accepted' => 'px-3 py-1 text-xs rounded-full bg-green-100 text-green-600 font-medium',
            'finish' => 'px-3 py-1 text-xs rounded-full bg-emerald-100 text-emerald-600 font-medium',
            default       => 'px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-400 font-medium',
        };
    }

    /* ======================= ASSESSOR HELPER STATUS LAPORAN KEGIATAN ======================= */

    public function canEditLaporan()
    {
        return in_array($this->status_laporan_ui, ['completed', 'rejected']);
    }

    public function canCetakLaporan()
    {
        return in_array($this->status_laporan_ui, ['completed', 'rejected']) && !$this->cetaklaporankegiatans;
    }

    public function canKirimLaporan()
    {
        return $this->status_laporan_ui === 'pending';
    }

    public function getSudahCetakLaporanAttribute()
    {
        return $this->balasanlaporankegiatans && $this->balasanlaporankegiatans->tanggalcetak_balasanlaporankegiatan;
    }

    public function getSudahKirimLaporanAttribute()
    {
        return $this->balasanlaporankegiatans && $this->balasanlaporankegiatans->tanggalkirim_balasanlaporankegiatan;
    }

    public function getBolehCetakLaporanAttribute()
    {
        return $this->status_laporan_ui === 'accepted' && !$this->sudah_cetakLaporan;
    }

    public function getBolehKirimLaporanAttribute()
{
    return $this->status_laporan_ui === 'completed'
        && $this->sudah_cetakLaporan
        && !$this->sudah_kirimLaporan;
}

public function getBolehKirimBalasanAttribute()
{
    return $this->balasanlaporankegiatans
        && $this->balasanlaporankegiatans->tanggalcetak_balasanlaporankegiatan
        && !$this->balasanlaporankegiatans->tanggalkirim_balasanlaporankegiatan;
}
    /* ======================= ASSESSOR ATRIBUT UNTUK KOP SURAT ======================= */

    public function getKopViewAttribute()
    {
        $kopsurat = $this->inputlaporankegiatans->inputusulankegiatans?->kopunitkerjas;
        $jeniskopsurat = $this->detaillaporankegiatans?->jeniskop_usulankegiatan;

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
    public function getInputUsulanAttribute()
{
    return $this->inputlaporankegiatans?->inputusulankegiatans;
}
}
