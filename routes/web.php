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

        // Informasi Admin - front End
        Route::get('/admin/informasi', function () {
        return view('pages.informasi.admin');
        })->name('admin.informasi');

        // Rekapitulasi Admin - Front End
        Route::get('/admin/rekapitulasi', function () {
        return view('pages.rekapitulasi.admin');
        })->name('admin.rekapitulasi');

        // Pengaturan Dasar - Front End
        Route::get('/admin/pengaturan', function () {
        return view('pages.pengaturan.admin');
        })->name('admin.pengaturan');

        // Detail Pengaturan Dasar - Front End
        Route::get('/admin/pengaturan/detail', function () {
        return view('pages.pengaturan.admin-detail');
        })->name('admin.pengaturan.detail');

        // Sertifikat Admin - Front End
        Route::get('/admin/sertifikat', function () {
        return view('pages.sertifikat.admin');
        })->name('admin.sertifikat');

        // Izin Pengembangan - Front End
        Route::get('/pengajuan/izinpengembangan', function () {
        return view('pages.izinpengembangan.pengajuan');
        })->name('pengajuan.izinpengembangan');

        // Step 1 - Input Data - Front End
        Route::get('/izinpengembangan/input-data', function () {
        return view('pages.izinpengembangan.input-data');
        })->name('izinpengembangan.input-data');

        // Step 2 - Cetak Usulan - Front End
        Route::get('/izinpengembangan/cetak-usulan', function () {
        return view('pages.izinpengembangan.cetak-usulan');
        })->name('izinpengembangan.cetak-usulan');

        // Step 3 - Kirim Usulan - Front End
        Route::get('/izinpengembangan/kirim-usulan', function () {
        return view('pages.izinpengembangan.kirim-usulan');
        })->name('izinpengembangan.kirim-usulan');

        // Step 4 - Input Laporan - Front End
        Route::get('/izinpengembangan/input-laporan', function () {
        return view('pages.izinpengembangan.input-laporan');
        })->name('izinpengembangan.input-laporan');

        // Step 5 - Cetak Laporan - Front End
        Route::get('/izinpengembangan/cetak-laporan', function () {
        return view('pages.izinpengembangan.cetak-laporan');
        })->name('izinpengembangan.cetak-laporan');

        // Step 6 - Kirim Laporan - Front End
        Route::get('/izinpengembangan/kirim-laporan', function () {
        return view('pages.izinpengembangan.kirim-laporan');
        })->name('izinpengembangan.kirim-laporan');

        // Step 7 - Unggah Peserta - Front End
        Route::get('/izinpengembangan/unggah-peserta', function () {
        return view('pages.izinpengembangan.unggah-peserta');
        })->name('izinpengembangan.unggah-peserta');

        // Step 8 - Unggah Template - Front End
        Route::get('/izinpengembangan/unggah-template', function () {
        return view('pages.izinpengembangan.unggah-template');
        })->name('izinpengembangan.unggah-template');

        // Step 9 - Download Sertifikat - Front End
        Route::get('/izinpengembangan/download-sertifikat', function () {
        return view('pages.izinpengembangan.download-sertifikat');
        })->name('izinpengembangan.download-sertifikat');

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

        // Informasi SuperAdmin - Front End
        Route::get('/superadmin/informasi', function () {
        return view('pages.informasi.superadmin');
        })->name('superadmin.informasi');

        // Rekapitulasi SuperAdmin - Front End
        Route::get('/superadmin/rekapitulasi', function () {
        return view('pages.rekapitulasi.superadmin');
        })->name('superadmin.rekapitulasi');

        // Sertifikat SuperAdmin - Front End
        Route::get('/superadmin/sertifikat', function () {
        return view('pages.sertifikat.superadmin');
        })->name('superadmin.sertifikat');

        // Tambah Sertifikat SuperAdmin - Front End
        Route::get('/superadmin/sertifikat/tambah', function () {
        return view('pages.sertifikat.superadmin');
        })->name('superadmin.sertifikat.tambah');

        // Daftar Usulan Masuk - Front End
        Route::get('/usulan-masuk', function () {
        return view('pages.usulankegiatan.daftar-usulan-masuk');
        })->name('usulankegiatan.daftar-masuk');

        // Detail Laporan Masuk - Front End
        Route::get('/detail-usulan', function () {
        return view('pages.usulankegiatan.detail-usulan-masuk');
        })->name('detail-usulan');

        // Daftar Laporan Masuk - Front End
        Route::get('/laporan-masuk', function () {
        return view('pages.daftar-laporan-masuk');
        })->name('laporan-masuk');

        // Detail Laporan Masuk - Front End
        Route::get('/detail-laporan', function () {
        return view('pages.detail-laporan-masuk');
        })->name('detail-laporan');

        // Surat Balasan Usulan - Front End
        Route::get('/balasan-usulan', function () {
        return view('pages.surat-balasan-usulan');
        })->name('balasan-usulan');

        // List semua usulan yang menunggu review
        Route::get('/superadmin/usulankegiatan/listusulankegiatanpending', [ReviewUsulanKegiatansController::class, 'pendingList'])->name('superadmin.usulankegiatan.pending');

        // Download Surat Usulan Kegiatan dan KAK
        Route::get('/superadmin/usulankegiatan/{id}/download', [UsulanKegiatansController::class, 'download'])->name('superadmin.usulankegiatan.download');

        // Form review satu usulan kegiatan
        Route::get('/superadmin/usulankegiatan/{id}/review', [ReviewUsulanKegiatansController::class, 'reviewForm'])->name('superadmin.usulankegiatan.review');

        // Submit hasil review (approve/reject)
        Route::post('/superadmin/usulankegiatan/{id}/review', [ReviewUsulanKegiatansController::class, 'reviewUpload'])->name('superadmin.usulankegiatan.reviewUpload');

        // Lihat Bukti Pelaksanaan Kegiatan
        Route::get('/superadmin/pelaksanaankegiatan/{id}', [PelaksanaanKegiatansController::class, 'show'])->name('superadmin.pelaksanaankegiatan.show');

        // Pengaturan Dasar - Front End
        Route::get('/superadmin/pengaturan', function () {
        return view('pages.pengaturan.superadmin');
        })->name('superadmin.pengaturan');

        // Detail Pengaturan Dasar - Front End
        Route::get('/superadmin/pengaturan/detail', function () {
        return view('pages.pengaturan.superadmin-detail');
        })->name('superadmin.pengaturan.detail');

    });
});


require __DIR__.'/auth.php';
