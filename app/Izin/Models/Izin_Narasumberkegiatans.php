<?php

namespace App\Izin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin_Narasumberkegiatans extends Model
{
    use HasFactory;

    protected $table = 'izin_narasumberkegiatans';

    protected $fillable = [
        'inputusulankegiatan_id',
        'nama_narasumber',
        'jabatan_narasumber'
    ];
}
