<?php

use App\Izin\Http\Controllers\Admin\CetakLaporanKegiatansController;
use App\Izin\Http\Controllers\Admin\CetakUsulanKegiatansController;
use App\Izin\Http\Controllers\Admin\DetailLaporanKegiatansController;
use App\Izin\Http\Controllers\Admin\DetailUsulanKegiatansController;
use App\Izin\Http\Controllers\Admin\KirimLaporanKegiatansController;
use App\Izin\Http\Controllers\Admin\KirimUsulanKegiatansController;
use App\Izin\Http\Controllers\Admin\LaporanKegiatansController;
use App\Izin\Http\Controllers\Admin\PelaksanaanKegiatansController;
use App\Izin\Http\Controllers\Admin\UsulanKegiatansController;
use App\Izin\Http\Controllers\IdentitasSuratsController;
use App\Izin\Http\Controllers\ProfileController;
use App\Izin\Http\Controllers\Superadmin\BalasanLaporanKegiatansController;
use App\Izin\Http\Controllers\Superadmin\BalasanUsulanKegiatansController;
use App\Izin\Http\Controllers\Superadmin\CetakBalasanUsulanKegiatansController;
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
        Route::get('/admin/usulankegiatan/create', [UsulanKegiatansController::class, 'create'])->name('admin.usulankegiatan.create');

        // Hapus Pengajuan Usulan Kegiatan 
        //Route::delete('/admin/usulankegiatan', [UsulanKegiatansController::class, 'destroy'])->name('admin.usulankegiatan.destroy');

        Route::get('/admin/usulankegiatan/{id}/kirim', [KirimUsulanKegiatansController::class, 'create'])->name('admin.usulankegiatan.kirim');
        Route::post('/admin/usulankegiatan/{id}/kirim', [KirimUsulanKegiatansController::class, 'store'])->name('admin.usulankegiatan.kirim');

        Route::get('/admin/laporankegiatan/{id}/kirim', [KirimLaporanKegiatansController::class, 'create'])->name('admin.laporankegiatan.kirim');
        Route::post('/admin/laporankegiatan/{id}/kirim', [KirimLaporanKegiatansController::class, 'store'])->name('admin.laporankegiatan.kirim');

        Route::get('/admin/usulankegiatan/{id}/downloadBalasan', [BalasanUsulanKegiatansController::class, 'downloadBalasan'])->name('admin.usulankegiatan.downloadBalasan');

        //Route::post('/admin/usulankegiatan/{id}/kirim', [IdentitasSuratsController::class, 'store'])->name('admin.usulankegiatan.kirim');

        // STEP 1 — Simpan draft
        Route::post('/admin/usulankegiatan/store-awal', [UsulanKegiatansController::class, 'storeAwal'])->name('admin.usulankegiatan.storeAwal');

        // STEP 2 — Form lengkapi usulan
        Route::get('/admin/usulankegiatan/{id}/edit', [UsulanKegiatansController::class, 'edit'])->name('admin.usulankegiatan.edit');

        // STEP 2 — Simpan lengkap
        Route::put('/admin/usulankegiatan/{id}', [UsulanKegiatansController::class, 'update'])->name('admin.usulankegiatan.update');

        // Hapus draft (opsional)
        Route::delete('/admin/usulankegiatan/{id}', [UsulanKegiatansController::class, 'destroy'])->name('admin.usulankegiatan.destroy');

        Route::post('/admin/usulankegiatan/{id}/cetak', [CetakUsulanKegiatansController::class, 'store'])->name('admin.usulankegiatan.cetak');

        // Submit Pengajuan Usulan Kegiatan
        //Route::post('/admin/usulankegiatan', [UsulanKegiatansController::class, 'store'])->name('admin.usulankegiatan.store');
        //Route::post('/admin/usulankegiatan/identitassurat', [IdentitasSuratsController::class, 'store'])->name('admin.identitassurat.store');
        //Route::post('/admin/usulankegiatan/detailusulankegiatan', [DetailUsulanKegiatansController::class, 'store'])->name('admin.detailusulankegiatan.store');

         // Form & upload tanda tangan pejabat kegiatan
        Route::get('/admin/usulankegiatan/upload-ttd', [UsulanKegiatansController::class, 'createTTD'])->name('admin.usulankegiatan.createTTD');
        Route::post('/admin/usulankegiatan/upload-ttd', [UsulanKegiatansController::class, 'uploadTTD'])->name('admin.usulankegiatan.uploadTTD');

        // Download Surat Usulan Kegiatan dan KAK
        Route::get('/admin/usulankegiatan/{id}/download', [UsulanKegiatansController::class, 'download'])->name('admin.usulankegiatan.download');

        // Submit Pelaksanann Kegiatan
        Route::get('/admin/pelaksanaankegiatan/{id}/create', [PelaksanaanKegiatansController::class, 'create'])->name('admin.pelaksanaankegiatan.create');
        Route::post('/admin/pelaksanaankegiatan/{id}', [PelaksanaanKegiatansController::class, 'store'])->name('admin.pelaksanaankegiatan.store');

        // Lihat Bukti Pelaksanaan Kegiatan
        Route::get('/admin/pelaksanaankegiatan/{id}', [PelaksanaanKegiatansController::class, 'show'])->name('admin.pelaksanaankegiatan.show');

        // STEP 1 — Simpan draft
        //Route::post('/admin/laporankegiatan/{id}', [LaporanKegiatansController::class, 'store'])->name('admin.laporankegiatan.store');

        // STEP 2 — Form lengkapi usulan
        Route::get('/admin/laporankegiatan/{id}/edit', [LaporanKegiatansController::class, 'edit'])->name('admin.laporankegiatan.edit');

        // STEP 2 — Simpan lengkap
        Route::put('/admin/laporankegiatan/{id}', [LaporanKegiatansController::class, 'update'])->name('admin.laporankegiatan.update');

        // Buat Pelaporan Hasil Kegiatan Pada Form Ajukan Laporan Hasil Kegiatan
        Route::get('/admin/laporankegiatan/{id}', [LaporanKegiatansController::class, 'create'])->name('admin.laporankegiatan.create');

        // Submit Pelaporan Hasil Kegiatan
        Route::post('/admin/laporankegiatan/{id}', [LaporanKegiatansController::class, 'store'])->name('admin.laporankegiatan.store');
        //Route::post('/admin/laporankegiatan/identitassurat/{id}', [IdentitasSuratsController::class, 'store'])->name('admin.identitassurat.store');
        //Route::post('/admin/laporankegiatan/detaillaporankegiatan/{id}', [DetailLaporanKegiatansController::class, 'store'])->name('admin.detaillaporankegiatan.store');

        Route::post('/admin/laporankegiatan/{id}/cetak', [CetakLaporanKegiatansController::class, 'store'])->name('admin.laporankegiatan.cetak');

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

        Route::get('/superadmin/balasanusulankegiatan/{id}/downloadBalasan', [BalasanUsulanKegiatansController::class, 'downloadBalasan'])->name('superadmin.usulankegiatan.downloadBalasan');

        Route::post('/superadmin/balasanusulankegiatan/{id}/cetak', [CetakBalasanUsulanKegiatansController::class, 'store'])->name('superadmin.balasanusulankegiatan.cetak');

        Route::get('/superadmin/balasanusulankegiatan/{id}/kirim', [BalasanUsulanKegiatansController::class, 'create'])->name('superadmin.balasanusulankegiatan.kirim');  
        Route::post('/superadmin/balasanusulankegiatan/{id}/kirim', [BalasanUsulanKegiatansController::class, 'store'])->name('superadmin.balasanusulankegiatan.kirim');
        //Route::post('/superadmin/balasanusulankegiatan/{id}/kirim', [IdentitasSuratsController::class, 'store'])->name('superadmin.balasanusulankegiatan.kirim');

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
