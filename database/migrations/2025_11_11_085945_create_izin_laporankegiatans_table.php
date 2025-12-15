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
        Schema::create('izin_laporankegiatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usulankegiatan_id')->constrained('izin_usulankegiatans');
            $table->foreignId('identitassurat_id')->constrained('izin_identitassurats');
            $table->foreignId('carapelatihan_id')->constrained('ref_carapelatihans');
            $table->json('atribut_khusus')->nullable();
            $table->time('waktupelaksanaan_laporan');
            $table->text('latarbelakang_laporan')->nullable();
            $table->text('dasarhukum_laporan')->nullable();
            $table->text('maksud_laporan')->nullable();
            $table->text('tujuan_laporan')->nullable();
            $table->text('ruanglingkup_laporan')->nullable();
            $table->foreignId('metodepelatihan_id')->constrained('ref_metodepelatihans');
            $table->text('narasumber_laporan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin_laporankegiatans');
    }
};
