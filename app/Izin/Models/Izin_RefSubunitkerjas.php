<?php

namespace App\Izin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin_RefSubunitkerjas extends Model
{
    use HasFactory;

    protected $table = 'ref_subunitkerjas';

    protected $fillable = [
        'id', 
        'unitkerja_id', 
        'sub_unitkerja', 
        'singkatan'
    ];

    // RELATION
    public function unitkerjas()
    {
        return $this->belongsTo(Izin_RefUnitkerjas::class, 'unitkerja_id');
    }

    public function usulankegiatans()
    {
        return $this->hasMany(Izin_Usulankegiatans::class, 'subunitkerja_id');
    }
}
