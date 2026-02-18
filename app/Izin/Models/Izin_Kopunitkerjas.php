<?php

namespace App\Izin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin_Kopunitkerjas extends Model
{
    use HasFactory;

    protected $table = 'izin_kopunitkerjas';

    protected $fillable = [
        'unitkerja_id',
        'subunitkerja_id',
        'nama_opd',
        'lokasi_opd',
        'telepon_opd',
        'faxmile_opd',
        'website_opd',
        'email_opd',
        'kodepos_opd',
        'gambarkop_opd'
    ];

    /* ========== RELATIONS ========== */

    public function unitkerjas()
    {
        return $this->belongsTo(Izin_RefUnitkerjas::class, 'unitkerja_id');
    }

    public function subunitkerjas()
    {
        return $this->belongsTo(Izin_RefSubunitkerjas::class, 'subunitkerja_id');
    }

    /* ========== ASESOR ATRIBUT UNTUK KOP SURAT ========== */
    public function getKopTextAttribute()
    {
        return [
            'nama_opd' => $this->nama_opd,
            'lokasi_opd' => $this->lokasi_opd,
            'telepon_opd' => $this->telepon_opd,
            'faxmile_opd' => $this->faxmile_opd,
            'email_opd' => $this->email_opd,
            'kodepos_opd' => $this->kodepos_opd
        ];
    }

    public function getKopGambarAttribute()
    {
        return $this->gambarkop_opd;
    }
}
