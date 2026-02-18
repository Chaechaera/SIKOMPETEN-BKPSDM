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
            $table->enum('jeniskop_laporankegiatan', ['kop_gambar', 'kop_text'])->nullable();
            $table->json('atribut_khusus')->nullable();
            $table->text('rincian_laporan')->nullable();
            $table->text('rundown_laporan')->nullable();
            $table->text('penutup_laporan')->nullable();
            $table->text('peserta_laporan')->nullable();
            $table->text('linkundangan_laporan')->nullable();
            $table->text('linkmateri_laporan')->nullable();
            $table->text('linkdaftarhadir_laporan')->nullable();
            $table->text('linkdokumentasi_laporan')->nullable();
            $table->text('gambardokumentasi_laporan')->nullable();
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
