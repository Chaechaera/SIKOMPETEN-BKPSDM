<?php

use App\Izin\Http\Controllers\Admin\DetailLaporanKegiatansController;
use App\Izin\Http\Controllers\Admin\DetailUsulanKegiatansController;
use App\Izin\Http\Controllers\Admin\LaporanKegiatansController;
use App\Izin\Http\Controllers\Admin\PelaksanaanKegiatansController;
use App\Izin\Http\Controllers\Admin\UsulanKegiatansController;
use App\Izin\Http\Controllers\IdentitasSuratsController;
use App\Izin\Http\Controllers\ProfileController;
use App\Izin\Http\Controllers\Superadmin\BalasanLaporanKegiatansController;
use App\Izin\Http\Controllers\Superadmin\ReviewLaporanKegiatansController;
use App\Izin\Http\Controllers\Superadmin\ReviewUsulanKegiatansController;
use App\Izin\Http\Controllers\User\SertifikatsController;
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
    Route::middleware(['role:user'])->group(function () {

        // Download Sertifikat Kegiatan
        Route::get('/user/sertifikat/download', [SertifikatsController::class, 'download'])->name('user.sertifikat.download');
    });

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

        // Buat Pelaporan Hasil Kegiatan Pada Form Ajukan Laporan Hasil Kegiatan
        Route::get('/admin/laporankegiatan/{id}', [LaporanKegiatansController::class, 'create'])->name('admin.laporankegiatan.create');

        // Submit Pelaporan Hasil Kegiatan
        Route::post('/admin/laporankegiatan/{id}', [LaporanKegiatansController::class, 'store'])->name('admin.laporankegiatan.store');
        Route::post('/admin/laporankegiatan/identitassurat/{id}', [IdentitasSuratsController::class, 'store'])->name('admin.identitassurat.store');
        Route::post('/admin/laporankegiatan/detaillaporankegiatan/{id}', [DetailLaporanKegiatansController::class, 'store'])->name('admin.detaillaporankegiatan.store');

        // Download Surat dan Laporan Hasil Kegiatan
        Route::get('/admin/laporankegiatan/{id}/download', [LaporanKegiatansController::class, 'download'])->name('admin.laporankegiatan.download');

        // Download Surat dan Laporan Hasil Kegiatan
        Route::get('/admin/balasanlaporankegiatan/{id}/download', [BalasanLaporanKegiatansController::class, 'download'])->name('admin.balasanlaporankegiatan.download');

        // Download Sertifikat Kegiatan
        Route::get('/admin/sertifikat/{id}/downloadZIP', [SertifikatsController::class, 'downloadZIP'])->name('admin.sertifikat.download');
    });

    // Bagian Superadmin
    Route::middleware(['role:superadmin'])->group(function () {

        // List semua usulan yang menunggu review
        Route::get('/superadmin/usulankegiatan/listusulankegiatanpending', [ReviewUsulanKegiatansController::class, 'pendingList'])->name('superadmin.usulankegiatan.pending');

        // Download Surat Usulan Kegiatan dan KAK
        Route::get('/superadmin/usulankegiatan/{id}/download', [UsulanKegiatansController::class, 'download'])->name('superadmin.usulankegiatan.download');

        // Form review satu usulan kegiatan
        Route::get('/superadmin/usulankegiatan/{id}/review', [ReviewUsulanKegiatansController::class, 'reviewForm'])->name('superadmin.usulankegiatan.review');

        // Submit hasil review usulan kegiatan (approve/reject)
        Route::post('/superadmin/usulankegiatan/{id}/review', [ReviewUsulanKegiatansController::class, 'reviewUpload'])->name('superadmin.usulankegiatan.reviewUpload');

        // Lihat Bukti Pelaksanaan Kegiatan
        Route::get('/superadmin/pelaksanaankegiatan/{id}', [PelaksanaanKegiatansController::class, 'show'])->name('superadmin.pelaksanaankegiatan.show');

        // Download Surat dan Laporan Hasil Kegiatan
        Route::get('/superadmin/laporankegiatan/{id}/download', [LaporanKegiatansController::class, 'download'])->name('superadmin.laporankegiatan.download');

        // Form review satu laporan kegiatan
        Route::get('/superadmin/laporankegiatan/{id}/review', [ReviewLaporanKegiatansController::class, 'reviewForm'])->name('superadmin.laporankegiatan.review');

        // Submit hasil review laporan kegiatan (approve/reject)
        Route::post('/superadmin/laporankegiatan/{id}/review', [ReviewLaporanKegiatansController::class, 'reviewUpload'])->name('superadmin.laporankegiatan.reviewUpload');

        // Buat Pengajuan Balasan Laporan Kegiatan Pada Form Ajukan Balasan Laporan Kegiatan
        Route::get('/superadmin/balasanlaporankegiatan/{id}', [BalasanLaporanKegiatansController::class, 'create'])->name('superadmin.balasanlaporankegiatan.create');

        // Submit Pengajuan Usulan Kegiatan
        Route::post('/superadmin/balasanlaporankegiatan/{id}', [BalasanLaporanKegiatansController::class, 'store'])->name('superadmin.balasanlaporankegiatan.store');
        Route::post('/superadmin/balasanlaporankegiatan/{id}/identitassurat', [IdentitasSuratsController::class, 'store'])->name('superadmin.identitassurat.store');
    });
});


require __DIR__.'/auth.php';
