<?php

namespace App\Izin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin_Ttdunitkerjas extends Model
{
    use HasFactory;

    protected $table = 'izin_ttdunitkerjas';

    protected $fillable = [
        'unitkerja_id',
        'subunitkerja_id',
        'gambarttd_opd'
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
}