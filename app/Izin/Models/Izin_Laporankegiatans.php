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
        'statuslaporan_kegiatan',
        'is_archived',
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

    public function getIdentitassuratsAttribute()
{
    return $this->cetaklaporankegiatans?->identitassurats;
}

    public function balasanlaporankegiatans()
{
    return $this->hasOne(
        Izin_Kirimbalasanlaporankegiatans::class,
        'inputlaporankegiatan_id',
        'id'
    );
}

    public function verifikasilaporankegiatans()
    {
        return $this->hasMany(Izin_Verifikasilaporankegiatans::class, 'laporankegiatan_id');
    }

    public function verifikasilaporankegiatanterakhir()
{
    return $this->hasOne(Izin_Verifikasilaporankegiatans::class, 'laporankegiatan_id')
    ->latestOfMany('created_at');
}

    /* ======================= ASSESSOR STATUS UI LAPORAN KEGIATAN ======================= */

    public function getStatusLaporanUiAttribute()
{
    // 1. FINISH PALING PRIORITAS
    if (
        $this->sertifikats &&
        $this->balasanlaporankegiatans?->tanggalkirim_balasanlaporankegiatan
    ) {
        return 'finish';
    }

    // 2. ACCEPTED (HARUS ADA INI)
    if (
    $this->verifikasilaporankegiatanterakhir &&
    $this->verifikasilaporankegiatanterakhir->status_verifikasilaporankegiatan === 'accepted' &&
    $this->statuslaporan_kegiatan === 'need_review'
) {
    return 'accepted';
}

    // 3. REJECTED
    if (
        $this->verifikasilaporankegiatanterakhir &&
        $this->verifikasilaporankegiatanterakhir->status_verifikasilaporankegiatan === 'rejected'
        && $this->statuslaporan_kegiatan === 'rejected'
    ) {
        return 'rejected';
    }

    // 4. FLOW STATUS UTAMA (INI YANG PALING AMAN)
    if ($this->statuslaporan_kegiatan === 'pending') {
        return 'pending';
    }

    if ($this->statuslaporan_kegiatan === 'need_review') {
        return 'need_review';
    }

    if ($this->statuslaporan_kegiatan === 'draft') {
        return 'draft';
    }

    return 'unknown';
}
    /* ======================= ASSESSOR ATRIBUT STATUS UI LAPORAN KEGIATAN ======================= */

    public function getStatusLaporanUiClassAttribute()
    {
        return match ($this->status_laporan_ui) {
            'draft' => 'px-3 py-1 text-xs rounded-full bg-purple-100 text-gray-500 font-medium',
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
        return in_array($this->status_laporan_ui, ['draft', 'rejected']);
    }

    public function canCetakLaporan()
    {
        return in_array($this->status_laporan_ui, ['draft', 'rejected']) && !$this->cetaklaporankegiatans;
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
    return $this->status_laporan_ui === 'draft'
        && $this->sudah_cetakLaporan
        && !$this->sudah_kirimLaporan;
}

public function getBolehKirimBalasanAttribute()
{
    return $this->status_laporan_ui === 'pending'
        && !$this->balasanlaporankegiatans?->tanggalkirim_balasanlaporankegiatan;
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
