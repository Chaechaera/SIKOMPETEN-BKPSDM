<?php

use App\Izin\Http\Controllers\Admin\CetakLaporanKegiatansController;
use App\Izin\Http\Controllers\Admin\CetakUsulanKegiatansController;
use App\Izin\Http\Controllers\Admin\KirimLaporanKegiatansController;
use App\Izin\Http\Controllers\Admin\KirimUsulanKegiatansController;
use App\Izin\Http\Controllers\Admin\KopUnitKerjasController;
use App\Izin\Http\Controllers\Admin\LaporanKegiatansController;
use App\Izin\Http\Controllers\Admin\PelaksanaanKegiatansController;
use App\Izin\Http\Controllers\Admin\UsulanKegiatansController;
use App\Izin\Http\Controllers\ProfileController;
use App\Izin\Http\Controllers\Superadmin\BalasanLaporanKegiatansController;
use App\Izin\Http\Controllers\Superadmin\BalasanUsulanKegiatansController;
use App\Izin\Http\Controllers\Superadmin\CetakBalasanLaporanKegiatansController;
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

    // Bagian User
    Route::middleware(['role:user'])->group(function () {

        // Download Sertifikat Kegiatan
        Route::get('/user/sertifikat/download', [SertifikatsController::class, 'download'])->name('user.sertifikat.download');
    });

    // Bagian Admin
    Route::middleware(['role:admin'])->group(function () {

        // Upload Kop, Stempel, dan TTD OPD
        Route::get('/admin/kopunitkerja/upload-kop-ttd', [KopUnitKerjasController::class, 'create'])->name('admin.kopunitkerja.create');
        Route::post('/admin/kopunitkerja/upload-kop-ttd', [KopUnitKerjasController::class, 'store'])->name('admin.kopunitkerja.store');
        Route::get('/admin/kopunitkerja/upload-kop-ttd/edit', [KopUnitKerjasController::class, 'edit'])->name('admin.kopunitkerja.edit');
        Route::put('/admin/kopunitkerja/upload-kop-ttd/update', [KopUnitKerjasController::class, 'update'])->name('admin.kopunitkerja.update');
        Route::delete('/admin/kopunitkerja/upload-kop-ttd/delete', [KopUnitKerjasController::class, 'destroy'])->name('admin.kopunitkerja.destroy');

        // List Pengajuan Usulan Kegiatan yang Dibuat
        Route::get('/admin/usulankegiatan/listusulankegiatan', [UsulanKegiatansController::class, 'index'])->name('admin.usulankegiatan.index');

        // Buat Pengajuan Usulan Kegiatan
        Route::get('/admin/usulankegiatan/create', [UsulanKegiatansController::class, 'create'])->name('admin.usulankegiatan.create');
        Route::post('/admin/usulankegiatan/store-awal', [UsulanKegiatansController::class, 'storeAwal'])->name('admin.usulankegiatan.storeAwal');

        // Lengkapi Pengajuan Usulan Kegiatan 
        Route::get('/admin/usulankegiatan/{id}/edit', [UsulanKegiatansController::class, 'edit'])->name('admin.usulankegiatan.edit');
        Route::put('/admin/usulankegiatan/{id}', [UsulanKegiatansController::class, 'update'])->name('admin.usulankegiatan.update');

        // Hapus Pengajuan Usulan Kegiatan 
        Route::delete('/admin/usulankegiatan/{id}', [UsulanKegiatansController::class, 'destroy'])->name('admin.usulankegiatan.destroy');

        // Download Surat Pengajuan dan KAK Usulan Kegiatan
        Route::get('/admin/usulankegiatan/{id}/download', [UsulanKegiatansController::class, 'download'])->name('admin.usulankegiatan.download');

        // Cetak Surat Pengajuan dan KAK Usulan Kegiatan
        Route::post('/admin/usulankegiatan/{id}/cetak', [CetakUsulanKegiatansController::class, 'store'])->name('admin.usulankegiatan.cetak');

        // Kirim Surat Pengajuan dan KAK Usulan Kegiatan
        Route::get('/admin/usulankegiatan/{id}/kirim', [KirimUsulanKegiatansController::class, 'create'])->name('admin.usulankegiatan.kirim');
        Route::post('/admin/usulankegiatan/{id}/kirim', [KirimUsulanKegiatansController::class, 'store'])->name('admin.usulankegiatan.kirim');

        // Upload Bukti Pelaksanaan Kegiatan
        Route::get('/admin/pelaksanaankegiatan/{id}/create', [PelaksanaanKegiatansController::class, 'create'])->name('admin.pelaksanaankegiatan.create');
        Route::post('/admin/pelaksanaankegiatan/{id}', [PelaksanaanKegiatansController::class, 'store'])->name('admin.pelaksanaankegiatan.store');

        // Lihat Bukti Pelaksanaan Kegiatan
        Route::get('/admin/pelaksanaankegiatan/{id}', [PelaksanaanKegiatansController::class, 'show'])->name('admin.pelaksanaankegiatan.show');

        // Buat Laporan Hasil Kegiatan
        Route::get('/admin/laporankegiatan/{id}', [LaporanKegiatansController::class, 'create'])->name('admin.laporankegiatan.create');
        Route::post('/admin/laporankegiatan/{id}', [LaporanKegiatansController::class, 'store'])->name('admin.laporankegiatan.store');

        // Lengkapi Laporan Hasil Kegiatan
        Route::get('/admin/laporankegiatan/{id}/edit', [LaporanKegiatansController::class, 'edit'])->name('admin.laporankegiatan.edit');
        Route::put('/admin/laporankegiatan/{id}', [LaporanKegiatansController::class, 'update'])->name('admin.laporankegiatan.update');

        // Download Surat Permohonan dan Laporan Hasil Kegiatan
        Route::get('/admin/laporankegiatan/{id}/download', [LaporanKegiatansController::class, 'download'])->name('admin.laporankegiatan.download');

        // Cetak Surat Permohonan dan Laporan Hasil Kegiatan
        Route::post('/admin/laporankegiatan/{id}/cetak', [CetakLaporanKegiatansController::class, 'store'])->name('admin.laporankegiatan.cetak');

        // Kirim Surat Permohonan dan Laporan Hasil Kegiatan
        Route::get('/admin/laporankegiatan/{id}/kirim', [KirimLaporanKegiatansController::class, 'create'])->name('admin.laporankegiatan.kirim');
        Route::post('/admin/laporankegiatan/{id}/kirim', [KirimLaporanKegiatansController::class, 'store'])->name('admin.laporankegiatan.kirim');

        // Download Surat Balasan Pengajuan Usulan Kegiatan dari Superadmin
        Route::get('/admin/usulankegiatan/{id}/downloadBalasan', [BalasanUsulanKegiatansController::class, 'downloadBalasan'])->name('admin.usulankegiatan.downloadBalasan');

        // Download Surat Balasan Laporan Hasil Kegiatan dari Superadmin
        Route::get('/admin/balasanlaporankegiatan/{id}/download', [BalasanLaporanKegiatansController::class, 'download'])->name('admin.balasanlaporankegiatan.download');

        // Download Sertifikat Kegiatan dalam ZIP
        Route::get('/admin/sertifikat/{id}/downloadZIP', [SertifikatsController::class, 'downloadZIP'])->name('admin.sertifikat.download');
    });

    // Bagian Superadmin
    Route::middleware(['role:superadmin'])->group(function () {

        // List Pengajuan Usulan Kegiatan yang Perlu Direview
        Route::get('/superadmin/usulankegiatan/listusulankegiatanpending', [ReviewUsulanKegiatansController::class, 'pendingList'])->name('superadmin.usulankegiatan.pending');

        // Download Surat Pengajuan dan KAK Usulan Kegiatan
        Route::get('/superadmin/usulankegiatan/{id}/download', [UsulanKegiatansController::class, 'download'])->name('superadmin.usulankegiatan.download');

        // Buat Review untuk Usulan Kegiatan yang Diajukan Admin
        Route::get('/superadmin/usulankegiatan/{id}/review', [ReviewUsulanKegiatansController::class, 'reviewForm'])->name('superadmin.usulankegiatan.review');
        Route::post('/superadmin/usulankegiatan/{id}/review', [ReviewUsulanKegiatansController::class, 'reviewUpload'])->name('superadmin.usulankegiatan.reviewUpload');

        // Download Surat Balasan Pengajuan Usulan Kegiatan
        Route::get('/superadmin/balasanusulankegiatan/{id}/downloadBalasan', [BalasanUsulanKegiatansController::class, 'downloadBalasan'])->name('superadmin.usulankegiatan.downloadBalasan');

        // Cetak Surat Balasan Pengajuan Usulan Kegiatan
        Route::post('/superadmin/balasanusulankegiatan/{id}/cetak', [CetakBalasanUsulanKegiatansController::class, 'store'])->name('superadmin.balasanusulankegiatan.cetak');

        // Kirim Surat Balasan Pengajuan Usulan Kegiatan
        Route::get('/superadmin/balasanusulankegiatan/{id}/kirim', [BalasanUsulanKegiatansController::class, 'create'])->name('superadmin.balasanusulankegiatan.kirim');
        Route::post('/superadmin/balasanusulankegiatan/{id}/kirim', [BalasanUsulanKegiatansController::class, 'store'])->name('superadmin.balasanusulankegiatan.kirim');
    
        // Lihat Bukti Pelaksanaan Kegiatan
        Route::get('/superadmin/pelaksanaankegiatan/{id}', [PelaksanaanKegiatansController::class, 'show'])->name('superadmin.pelaksanaankegiatan.show');

        // Download Surat Permohonan dan Laporan Hasil Kegiatan
        Route::get('/superadmin/laporankegiatan/{id}/download', [LaporanKegiatansController::class, 'download'])->name('superadmin.laporankegiatan.download');

        // Buat Review untuk Laporan Hasil Kegiatan yang Diajukan Admin
        Route::get('/superadmin/laporankegiatan/{id}/review', [ReviewLaporanKegiatansController::class, 'reviewForm'])->name('superadmin.laporankegiatan.review');
        Route::post('/superadmin/laporankegiatan/{id}/review', [ReviewLaporanKegiatansController::class, 'reviewUpload'])->name('superadmin.laporankegiatan.reviewUpload');

        // Buat Pengajuan Balasan Laporan Hasil Kegiatan yang diajukan Admin
        Route::get('/superadmin/balasanlaporankegiatan/{id}', [BalasanLaporanKegiatansController::class, 'create'])->name('superadmin.balasanlaporankegiatan.create');
        Route::post('/superadmin/balasanlaporankegiatan/{id}', [BalasanLaporanKegiatansController::class, 'store'])->name('superadmin.balasanlaporankegiatan.store');

        // Download Surat Balasan Laporan Hasil Kegiatan
        Route::get('/superadmin/balasanlaporankegiatan/{id}/download', [BalasanLaporanKegiatansController::class, 'download'])->name('superadmin.balasanlaporankegiatan.download');

        // Cetak Surat Balasan Laporan Hasil Kegiatan
        Route::post('/superadmin/balasanlaporankegiatan/{id}/cetak', [CetakBalasanLaporanKegiatansController::class, 'store'])->name('superadmin.balasanlaporankegiatan.cetak');

        // Kirim Surat Balasan Laporan Hasil Kegiatan
        Route::get('/superadmin/balasanlaporankegiatan/{id}/kirim', [BalasanLaporanKegiatansController::class, 'kirim'])->name('superadmin.balasanlaporankegiatan.kirim');
        Route::post('/superadmin/balasanlaporankegiatan/{id}/kirim', [BalasanLaporanKegiatansController::class, 'storeFinal'])->name('superadmin.balasanlaporankegiatan.kirim');
    });
});


require __DIR__ . '/auth.php';
