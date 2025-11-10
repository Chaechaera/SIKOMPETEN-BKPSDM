<?php

use App\Izin\Http\Controllers\Admin\DetailUsulanKegiatansController;
use App\Izin\Http\Controllers\Admin\PelaksanaanKegiatansController;
use App\Izin\Http\Controllers\Admin\UsulanKegiatansController;
use App\Izin\Http\Controllers\IdentitasSuratsController;
use App\Izin\Http\Controllers\ProfileController;
use App\Izin\Http\Controllers\Superadmin\ReviewUsulanKegiatansController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Pengaturan Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Bagian Admin
    Route::middleware(['role:admin'])->group(function () {

        // List semua usulan kegiatan
        Route::get('/admin/usulankegiatan/listusulankegiatan', [UsulanKegiatansController::class, 'index'])->name('admin.usulankegiatan.index');
        
        // Buat Pengajuan Usulan Kegiatan Pada Form Ajukan Usulan Kegiatan
        Route::get('/admin/usulankegiatan', [UsulanKegiatansController::class, 'create'])->name('admin.usulankegiatan.create');

        // Submit Pengajuan Usulan Kegiatan
        Route::post('/admin/usulankegiatan', [UsulanKegiatansController::class, 'store'])->name('admin.usulankegiatan.store');
        Route::post('/admin/usulankegiatan/identitassurat', [IdentitasSuratsController::class, 'store'])->name('admin.identitassurat.store');
        Route::post('/admin/usulankegiatan/detailusulankegiatan', [DetailUsulanKegiatansController::class, 'store'])->name('admin.detailusulankegiatan.store');

        // Hapus Pengajuan Usulan Kegiatan 
        Route::delete('/admin/usulankegiatan', [UsulanKegiatansController::class, 'destroy'])->name('admin.usulankegiatan.destroy');

         // Form & upload tanda tangan pejabat kegiatan
        Route::get('/admin/usulankegiatan/upload-ttd', [UsulanKegiatansController::class, 'createTTD'])->name('admin.usulankegiatan.createTTD');
        Route::post('/admin/usulankegiatan/upload-ttd', [UsulanKegiatansController::class, 'uploadTTD'])->name('admin.usulankegiatan.uploadTTD');

        // Download Surat Usulan Kegiatan dan KAK
        Route::get('/admin/usulankegiatan/{id}/download', [UsulanKegiatansController::class, 'download'])->name('admin.usulankegiatan.download');

        // Submit Pelaksanann Kegiatan
        Route::get('/admin/pelaksanaankegiatan/{id}', [PelaksanaanKegiatansController::class, 'create'])->name('admin.pelaksanaankegiatan.create');
        Route::post('/admin/pelaksanaankegiatan/{id}', [PelaksanaanKegiatansController::class, 'store'])->name('admin.pelaksanaankegiatan.store');
    });

    // Bagian Superadmin
    Route::middleware(['role:superadmin'])->group(function () {

        // List semua usulan yang menunggu review
        Route::get('/superadmin/usulankegiatan/listusulankegiatanpending', [ReviewUsulanKegiatansController::class, 'pendingList'])->name('superadmin.usulankegiatan.pending');

        // Download Surat Usulan Kegiatan dan KAK
        Route::get('/superadmin/usulankegiatan/{id}/download', [UsulanKegiatansController::class, 'download'])->name('superadmin.usulankegiatan.download');

        // Form review satu usulan kegiatan
        Route::get('/superadmin/usulankegiatan/{id}/review', [ReviewUsulanKegiatansController::class, 'reviewForm'])->name('superadmin.usulankegiatan.review');

        // Submit hasil review (approve/reject)
        Route::post('/superadmin/usulankegiatan/{id}/review', [ReviewUsulanKegiatansController::class, 'reviewUpload'])->name('superadmin.usulankegiatan.reviewUpload');
    });
});


require __DIR__.'/auth.php';
