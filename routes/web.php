<?php

use App\Izin\Http\Controllers\Admin\CetakLaporanKegiatansController;
use App\Izin\Http\Controllers\Admin\CetakUsulanKegiatansController;
use App\Izin\Http\Controllers\Admin\KirimLaporanKegiatansController;
use App\Izin\Http\Controllers\Admin\KirimUsulanKegiatansController;
use App\Izin\Http\Controllers\Admin\KopUnitKerjasController;
use App\Izin\Http\Controllers\Admin\LaporanKegiatansController;
use App\Izin\Http\Controllers\Admin\PelaksanaanKegiatansController;
use App\Izin\Http\Controllers\Admin\UsulanKegiatansController;
use App\Izin\Http\Controllers\Auth\UserController;
use App\Izin\Http\Controllers\ProfileController;
use App\Izin\Http\Controllers\Superadmin\BalasanLaporanKegiatansController;
use App\Izin\Http\Controllers\Superadmin\BalasanUsulanKegiatansController;
use App\Izin\Http\Controllers\Superadmin\CetakBalasanLaporanKegiatansController;
use App\Izin\Http\Controllers\Superadmin\CetakBalasanUsulanKegiatansController;
use App\Izin\Http\Controllers\Superadmin\ReviewLaporanKegiatansController;
use App\Izin\Http\Controllers\Superadmin\ReviewUsulanKegiatansController;
use App\Izin\Http\Controllers\Superadmin\UserManagementController;
use App\Izin\Http\Controllers\Superadmin\ValidasiLaporanPesertaKegiatansController;
use App\Izin\Http\Controllers\User\LaporanPesertaKegiatansController;
use App\Izin\Http\Controllers\User\SertifikatsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// User Management
Route::middleware(['superadmin'])->group(function () {
    Route::resource('/users', UserManagementController::class);
    Route::patch('/users/{user}/verify-email', [UserManagementController::class, 'verifyEmail'])->name('dashboard.users.verify-email');
    Route::patch('/users/{user}/deactivate', [UserManagementController::class, 'deactivate'])->name('dashboard.users.deactivate');
    Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->name('dashboard.users.update-role');
});

Route::middleware('auth')->group(function () {

    // Pengaturan Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Bagian User
    Route::middleware(['role:user'])->group(function () {

        // Download Sertifikat Kegiatan
        Route::get('/user/sertifikat', [SertifikatsController::class, 'listSertif'])->name('user.sertifikat');
        Route::get('/user/sertifikat/download/{sertifikat}/{peserta}', [SertifikatsController::class, 'download'])->name('user.sertifikat.download');

        // Informasi Mengenai Pengembangan Kompetensi ASN
        Route::get('/user/aboutus', function () {return view('pages.about_us');})->name('user.aboutus');

        // Melihat Rekapitulasi Kegiatan
        Route::get('/user/rekapitulasi', [UsulanKegiatansController::class, 'rekap'])->name('user.rekapitulasi');

        // Pelaporan Peserta Kegiatan
        Route::get('/user/laporanpeserta/{sertifikat_id}', [LaporanPesertaKegiatansController::class, 'create'])->name('user.laporanpeserta.create');
        Route::post('/user/laporanpeserta/{sertifikat_id}', [LaporanPesertaKegiatansController::class, 'store'])->name('user.laporanpeserta.store');
    });

    // Bagian Admin
    Route::middleware(['role:admin'])->group(function () {

        // Informasi Mengenai Pengembangan Kompetensi ASN
        Route::get('/admin/informasi', function () {return view('pages.informasi_pk_asn');})->name('admin.informasi');

        // Melihat Rekapitulasi Kegiatan
        Route::get('/admin/rekapitulasi', [UsulanKegiatansController::class, 'rekap'])->name('admin.rekapitulasi');

        // Sertifikat Admin
        Route::get('/admin/sertifikat', [SertifikatsController::class, 'index'])->name('admin.sertifikat');

        // Upload Kop, Stempel, dan TTD OPD
        Route::get('/admin/kopunitkerja/upload-kop-ttd', [KopUnitKerjasController::class, 'create'])->name('admin.kopunitkerja.create');
        Route::post('/admin/kopunitkerja/upload-kop-ttd', [KopUnitKerjasController::class, 'store'])->name('admin.kopunitkerja.store');
        Route::get('/admin/kopunitkerja/upload-kop-ttd/edit/{id}', [KopUnitKerjasController::class, 'edit'])->name('admin.kopunitkerja.edit');
        Route::put('/admin/kopunitkerja/upload-kop-ttd/update/{id}', [KopUnitKerjasController::class, 'update'])->name('admin.kopunitkerja.update');

        // List Pengajuan Usulan Kegiatan yang Dibuat
        Route::get('/admin/usulankegiatan/listusulankegiatan', [UsulanKegiatansController::class, 'index'])->name('admin.usulankegiatan.index');

        // Arsip Usulan Kegiatan
        Route::get('/admin/usulankegiatan/arsip', [UsulanKegiatansController::class, 'archivePage'])->name('admin.usulankegiatan.arsip');
        Route::patch('/admin/usulankegiatan/{id}/archive', [UsulanKegiatansController::class, 'archive'])->name('admin.usulankegiatan.archive');
        Route::patch('/admin/usulankegiatan/{id}/restore', [UsulanKegiatansController::class, 'restore'])->name('admin.usulankegiatan.restore');

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
        Route::post('/admin/usulankegiatan/{id}/preview', [UsulanKegiatansController::class, 'preview'])->name('admin.usulankegiatan.preview');

        // Cetak Surat Pengajuan dan KAK Usulan Kegiatan
        Route::match(['get', 'post'], '/admin/usulankegiatan/{id}/cetak', [CetakUsulanKegiatansController::class, 'store'])->name('admin.usulankegiatan.cetak');

        // Kirim Surat Pengajuan dan KAK Usulan Kegiatan
        Route::get('/admin/usulankegiatan/{id}/kirim', [KirimUsulanKegiatansController::class, 'create'])->name('admin.usulankegiatan.kirim');
        Route::post('/admin/usulankegiatan/{id}/kirim', [KirimUsulanKegiatansController::class, 'store'])->name('admin.usulankegiatan.kirim');

        // Upload Bukti Pelaksanaan Kegiatan
        Route::get('/admin/pelaksanaankegiatan/{id}/create', [PelaksanaanKegiatansController::class, 'create'])->name('admin.pelaksanaankegiatan.create');
        Route::post('/admin/pelaksanaankegiatan/{id}', [PelaksanaanKegiatansController::class, 'store'])->name('admin.pelaksanaankegiatan.store');

        // Lihat Bukti Pelaksanaan Kegiatan
        Route::get('/admin/pelaksanaankegiatan/{id}', [PelaksanaanKegiatansController::class, 'show'])->name('admin.pelaksanaankegiatan.show');

        // List Pengajuan laporan Kegiatan yang Dibuat
        Route::get('/admin/laporankegiatan/listlaporankegiatan', [LaporanKegiatansController::class, 'index'])->name('admin.laporankegiatan.index');

        //Daftar Laporan Kegiatan
        Route::get('/admin/laporankegiatan/daftar_laporankegiatan', [LaporanKegiatansController::class, 'index'])->name('admin.laporankegiatan.index');

        // ARCHIVED
        Route::get('/admin/laporankegiatan/arsip', [LaporanKegiatansController::class, 'archivePage'])->name('admin.laporankegiatan.arsip');
        Route::post('/admin/laporankegiatan/{id}/archive', [LaporanKegiatansController::class, 'archive'])->name('admin.laporankegiatan.archive');
        Route::post('/admin/laporankegiatan/{id}/unarchive', [LaporanKegiatansController::class, 'unarchive'])->name('admin.laporankegiatan.unarchive');

        // Buat Laporan Hasil Kegiatan
        Route::get('/admin/laporankegiatan/{id}', [LaporanKegiatansController::class, 'create'])->name('admin.laporankegiatan.create');
        Route::post('/admin/laporankegiatan/{id}', [LaporanKegiatansController::class, 'store'])->name('admin.laporankegiatan.store');

        // Lengkapi Laporan Hasil Kegiatan
        Route::get('/admin/laporankegiatan/{id}/edit', [LaporanKegiatansController::class, 'edit'])->name('admin.laporankegiatan.edit');
        Route::put('/admin/laporankegiatan/{id}', [LaporanKegiatansController::class, 'update'])->name('admin.laporankegiatan.update');

        // Download Surat Permohonan dan Laporan Hasil Kegiatan
        Route::get('/admin/laporankegiatan/{id}/download', [LaporanKegiatansController::class, 'download'])->name('admin.laporankegiatan.download');

        // HALAMAN CETAK (form + preview + input identitas)
        Route::get('/admin/laporankegiatan/{id}/cetak', [CetakLaporanKegiatansController::class, 'create'])->name('admin.laporankegiatan.cetak.form');

        // PREVIEW (GET/POST bebas)
        Route::post('/admin/laporankegiatan/{id}/preview', [LaporankegiatansController::class, 'preview'])->name('admin.laporankegiatan.preview');

        // CETAK (FINAL SAVE)
        Route::post('/admin/laporankegiatan/{id}/cetak/download', [CetakLaporanKegiatansController::class, 'download'])->name('admin.laporankegiatan.cetak.download');
        Route::get('/admin/laporankegiatan/{id}/cetak', [CetakLaporanKegiatansController::class, 'create'])->name('admin.laporankegiatan.cetak');

        // Routes Check Nomor Surat
        Route::post('/admin/laporankegiatan/check-nomor-surat', [LaporankegiatansController::class, 'checkNomorSurat']);

        // Kirim Surat Permohonan dan Laporan Hasil Kegiatan
        Route::get('/admin/laporankegiatan/{id}/kirim', [KirimLaporanKegiatansController::class, 'create'])->name('admin.laporankegiatan.kirim.form');
        Route::post('/admin/laporankegiatan/{id}/kirim', [KirimLaporanKegiatansController::class, 'store'])->name('admin.laporankegiatan.kirim.store');

        // Delete Laporan Kegiatan
        Route::delete('/admin/laporankegiatan/{id}', [LaporanKegiatansController::class, 'destroy'])->name('admin.laporankegiatan.destroy');

        // Download Surat Balasan Pengajuan Usulan Kegiatan dari Superadmin
        Route::get('/admin/usulankegiatan/{id}/downloadBalasan', [BalasanUsulanKegiatansController::class, 'downloadBalasan'])->name('admin.usulankegiatan.downloadBalasan');

        // Download Surat Balasan Laporan Hasil Kegiatan dari Superadmin
        Route::get('/admin/balasanlaporankegiatan/{id}/download', [BalasanLaporanKegiatansController::class, 'download'])->name('admin.balasanlaporankegiatan.download');

        // Sertifikat Admin
        Route::get('/admin/sertifikat', [SertifikatsController::class, 'index'])->name('admin.sertifikat');

        // Finalisasi semua sertifikat
        Route::post('/admin/sertifikat/{sertifikat}/finalisasi', [SertifikatsController::class, 'finalisasi'])->name('admin.sertifikat.finalisasi');

        // Download ZIP
        Route::get('/admin/sertifikat/{id}/downloadZIP', [SertifikatsController::class, 'downloadZIP'])->name('admin.sertifikat.download');

        // Close Notification
        Route::post('/usulan/notifikasi/{id}/close', [UsulanKegiatansController::class, 'closeNotification'])->name('admin.usulankegiatan.notification.close');
    });



    // Bagian Superadmin
    Route::middleware(['role:superadmin'])->group(function () {

        // Manajemen User
        Route::get('/superadmin/manajemenuser', [UserManagementController::class, 'index'])->name('superadmin.manajemenuser');

        // Validasi Laporan Peserta
        Route::get('/superadmin/laporanpeserta', [ValidasiLaporanPesertaKegiatansController::class, 'index'])->name('superadmin.laporanpeserta.index');
        Route::patch('/superadmin/laporanpeserta/{id}/approve', [ValidasiLaporanPesertaKegiatansController::class, 'approve'])->name('superadmin.laporan.approve');
        Route::patch('/superadmin/laporanpeserta/{id}/reject', [ValidasiLaporanPesertaKegiatansController::class, 'reject'])->name('superadmin.laporan.reject');

        // Informasi Mengenai Pengembangan Kompetensi ASN
        Route::get('/superadmin/informasi', function () {
            return view('pages.informasi_pk_asn');
        })->name('superadmin.informasi');

        // Melihat Rekapitulasi Kegiatan
        Route::get('/superadmin/rekapitulasi', [UsulanKegiatansController::class, 'rekap'])->name('superadmin.rekapitulasi');

        // List Pengajuan Usulan Kegiatan yang Perlu Direview
        Route::get('/superadmin/usulankegiatan/listusulankegiatanpending', [ReviewUsulanKegiatansController::class, 'pendingList'])->name('superadmin.usulankegiatan.pending');

        // Download Surat Pengajuan dan KAK Usulan Kegiatan
        Route::get('/superadmin/usulankegiatan/{id}/download', [UsulanKegiatansController::class, 'download'])->name('superadmin.usulankegiatan.download');
        Route::get('/superadmin/usulankegiatan/{id}/preview-file', [UsulanKegiatansController::class, 'previewFile'])->name('superadmin.usulankegiatan.previewFile');

        // Buat Review untuk Usulan Kegiatan yang Diajukan Admin
        Route::get('/superadmin/usulankegiatan/{id}/review', [ReviewUsulanKegiatansController::class, 'reviewForm'])->name('superadmin.usulankegiatan.review');
        Route::post('/superadmin/usulankegiatan/{id}/review', [ReviewUsulanKegiatansController::class, 'reviewUpload'])->name('superadmin.usulankegiatan.reviewUpload');

        // Download Surat Balasan Pengajuan Usulan Kegiatan
        Route::get('/superadmin/balasanusulankegiatan/{id}/downloadBalasan', [BalasanUsulanKegiatansController::class, 'downloadBalasan'])->name('superadmin.usulankegiatan.downloadBalasan');
        
        // Cetak Surat Balasan Pengajuan Usulan Kegiatan
        Route::get('/superadmin/balasanusulankegiatan/{id}/cetak', [BalasanUsulanKegiatansController::class, 'createCetak'])->name('superadmin.balasanusulankegiatan.cetak');
        Route::post('/superadmin/balasanusulankegiatan/{id}/cetak', [BalasanUsulanKegiatansController::class, 'storeCetak'])->name('superadmin.balasanusulankegiatan.cetak.store');

        // Kirim Surat Balasan Pengajuan Usulan Kegiatan
        Route::get('/superadmin/balasanusulankegiatan/{id}/kirim', [BalasanUsulanKegiatansController::class, 'create'])->name('superadmin.balasanusulankegiatan.kirim');
        Route::post('/superadmin/balasanusulankegiatan/{id}/kirim', [BalasanUsulanKegiatansController::class, 'storeFinal'])->name('superadmin.balasanusulankegiatan.kirim');

        // Preview Balasan Pengajuan Usulan Kegiatan
        Route::post('/superadmin/balasanusulankegiatan/{id}/preview', [CetakBalasanUsulanKegiatansController::class, 'preview'])->name('superadmin.balasanusulankegiatan.preview');

        // Lihat Bukti Pelaksanaan Kegiatan
        Route::get('/superadmin/pelaksanaankegiatan/{id}', [PelaksanaanKegiatansController::class, 'show'])->name('superadmin.pelaksanaankegiatan.show');

        // List Pengajuan Laporan Kegiatan yang Perlu Direview
        Route::get('/superadmin/laporankegiatan/listlaporankegiatanpending', [ReviewLaporanKegiatansController::class, 'pendingList'])->name('superadmin.laporankegiatan.pending');

        // Arsip Usulan Kegiatan
        Route::get('/superadmin/usulankegiatan/arsip', [ReviewUsulanKegiatansController::class, 'archivePage'])->name('superadmin.usulankegiatan.arsip');
        Route::patch('/superadmin/usulankegiatan/{id}/archive', [ReviewUsulanKegiatansController::class, 'archive'])->name('superadmin.usulankegiatan.archive');
        Route::patch('/superadmin/usulankegiatan/{id}/restore', [ReviewUsulanKegiatansController::class, 'restore'])->name('superadmin.usulankegiatan.restore');

        // Download Surat Permohonan dan Laporan Hasil Kegiatan
        Route::get('/superadmin/laporankegiatan/{id}/download', [LaporanKegiatansController::class, 'download'])->name('superadmin.laporankegiatan.download');

        Route::get('/superadmin/dashboard', [ReviewLaporanKegiatansController::class, 'dashboard']);

        // Buat Review untuk Laporan Hasil Kegiatan yang Diajukan Admin
        Route::get('/superadmin/laporankegiatan/{id}/review', [ReviewLaporanKegiatansController::class, 'reviewForm'])->name('superadmin.laporankegiatan.review');
        Route::post('/superadmin/laporankegiatan/{id}/review', [ReviewLaporanKegiatansController::class, 'reviewUpload'])->name('superadmin.laporankegiatan.reviewUpload');

        // Buat Pengajuan Balasan Laporan Hasil Kegiatan yang diajukan Admin
        Route::get('/superadmin/balasanlaporankegiatan/{id}', [BalasanLaporanKegiatansController::class, 'create'])->name('superadmin.balasanlaporankegiatan.create');
        Route::post('/superadmin/balasanlaporankegiatan/{id}', [BalasanLaporanKegiatansController::class, 'store'])->name('superadmin.balasanlaporankegiatan.store');

        // CETAK BALASAN LAPORAN
        Route::get('/superadmin/balasanlaporankegiatan/{id}/cetak', [CetakBalasanLaporanKegiatansController::class, 'preview'])->name('superadmin.balasanlaporankegiatan.cetak');

        // STORE IDENTITAS LAPORAN KEGIATAN
        Route::post('/superadmin/balasanlaporankegiatan/{id}/cetak', [BalasanLaporanKegiatansController::class, 'storeIdentitas'])->name('superadmin.balasanlaporankegiatan.cetak.store');

        // PREVIEW BALASAN LAPORAN
        Route::post('/superadmin/balasanlaporankegiatan/{id}/preview', [BalasanLaporanKegiatansController::class, 'preview'])->name('superadmin.balasanlaporankegiatan.preview');

        // Kirim Surat Balasan Laporan Hasil Kegiatan
        Route::get('/superadmin/balasanlaporankegiatan/{id}/kirim', [BalasanLaporanKegiatansController::class, 'kirim'])->name('superadmin.balasanlaporankegiatan.kirim');
        Route::post('/superadmin/balasanlaporankegiatan/{id}/kirim', [BalasanLaporanKegiatansController::class, 'storeFinal'])->name('superadmin.balasanlaporankegiatan.kirim');

        // Download Surat Balasan Laporan Hasil Kegiatan
        Route::get('/superadmin/balasanlaporankegiatan/{id}/download', [BalasanLaporanKegiatansController::class, 'download'])->name('superadmin.balasanlaporankegiatan.download');

        // Download Surat Balasan Pengajuan Usulan Kegiatan
        Route::get('/superadmin/balasanusulankegiatan/{id}/downloadBalasan', [BalasanUsulanKegiatansController::class, 'downloadBalasan'])->name('superadmin.usulankegiatan.downloadBalasan');

        // Download Laporan Peserta Kegiatan
        Route::get('/superadmin/laporanpesertakegiatan/{id}/download', [LaporanPesertaKegiatansController::class, 'download'])->name('superadmin.laporanpesertakegiatan.download');

        // ARCHIVE LAPORAN
        Route::post('/superadmin/laporankegiatan/{id}/archive', [ReviewLaporanKegiatansController::class, 'archive'])->name('superadmin.laporankegiatan.archive');
        Route::post('/superadmin/laporankegiatan/{id}/unarchive', [ReviewLaporanKegiatansController::class, 'unarchive'])->name('superadmin.laporankegiatan.unarchive');
        Route::get('/superadmin/laporankegiatan/arsip', [ReviewLaporanKegiatansController::class, 'archivePage'])->name('superadmin.laporankegiatan.arsip');
    });
});


require __DIR__ . '/auth.php';
