<?php

namespace App\Izin\Http\Controllers\Auth;

use App\Izin\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Izin\Models\Izin_Laporankegiatans;

class SuperadminController extends Controller
{
    public function index()
{
    // TOTAL
    $total = Izin_Laporankegiatans::count();

    // DISETUJUI
    $disetujui = Izin_Laporankegiatans::get()
        ->filter(fn($item) =>
            in_array($item->status_laporan_ui, ['accepted', 'finish'])
        )->count();

    // MENUNGGU (FIX sesuai kebutuhan kamu)
    $menunggu = Izin_Laporankegiatans::get()
        ->filter(fn($item) =>
            $item->status_laporan_ui === 'need_review'
        )->count();

    //DATA TERBARU
    $laporans = Izin_Laporankegiatans::with([
        'inputlaporankegiatans.inputusulankegiatans.usulankegiatans.subunitkerjas'
    ])
    ->latest()
    ->take(5)
    ->get();

    return view('pages.dashboard.superadmin', compact(
        'total',
        'disetujui',
        'menunggu',
        'laporans'
    ));
}

}
