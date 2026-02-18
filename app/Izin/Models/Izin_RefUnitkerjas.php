<?php

namespace App\Izin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin_RefUnitkerjas extends Model
{
    use HasFactory;

    protected $table = 'ref_unitkerjas';

    protected $fillable = [
        'id', 
        'kode_unitkerja', 
        'unitkerja'
    ];

    /* ========== RELATIONS ========== */
    
    public function subunitkerjas()
    {
        return $this->hasMany(Izin_RefSubunitkerjas::class, 'unitkerja_id');
    }
}
