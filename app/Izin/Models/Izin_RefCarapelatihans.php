<?php

namespace App\Izin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin_RefCarapelatihans extends Model
{
    use HasFactory;

    protected $table = 'ref_carapelatihans';

    protected $fillable = [
        'id', 
        'cara_pelatihan', 
        'jumlah_jp', 
        'pengertian', 
        'pemberlakuan'
    ];
}
