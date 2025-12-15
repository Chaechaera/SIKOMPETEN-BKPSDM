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
        Schema::create('izin_balasanlaporankegiatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('identitassurat_id')->constrained('izin_identitassurats');
            $table->foreignId('laporankegiatan_id')->constrained('izin_laporankegiatans');
            $table->foreignId('usulankegiatan_id')->constrained('izin_usulankegiatans');
            $table->foreignId('sertifikat_id')->constrained('izin_sertifikats');
            $table->integer('totalcapaianjp_kegiatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin_balasanlaporankegiatans');
    }
};
