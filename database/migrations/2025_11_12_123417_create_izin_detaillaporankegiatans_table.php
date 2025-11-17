<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('izin_detaillaporankegiatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporankegiatan_id')->constrained('izin_laporankegiatans');
            $table->text('rincian_laporan')->nullable();
            $table->text('rundown_laporan')->nullable();
            $table->text('peserta_laporan')->nullable();
            $table->text('undangan_laporan')->nullable();
            $table->text('materi_laporan')->nullable();
            $table->text('daftarhadir_laporan')->nullable();
            $table->text('dokumentasi_laporan')->nullable();
            $table->text('gambardokumentasi_laporan')->nullable();
            $table->text('outputkegiatan_laporan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin_detaillaporankegiatans');
    }
};
