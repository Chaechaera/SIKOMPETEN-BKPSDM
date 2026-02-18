<?php

namespace App\Izin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin_RefMetodepelatihans extends Model
{
    use HasFactory;

    protected $table = 'ref_metodepelatihans';

    protected $fillable = [
        'id', 
        'kode_metodepelatihan', 
        'metode_pelatihan'
    ];
}
