<?php

namespace App\Izin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin_Kirimbalasanlaporankegiatans extends Model
{
    use HasFactory;

    protected $table = 'izin_kirimbalasanlaporankegiatans';

    protected $fillable = [
        'inputlaporankegiatan_id',
        'identitassurat_id',
        'balasanlaporankegiatan_id'
    ];
}
