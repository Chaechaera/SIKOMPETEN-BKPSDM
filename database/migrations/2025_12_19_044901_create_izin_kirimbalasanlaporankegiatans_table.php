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
        Schema::create('izin_kirimbalasanlaporankegiatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inputlaporankegiatan_id');
            $table->foreign('inputlaporankegiatan_id','inputlaporankegiatan_i')->references('id')->on('izin_inputlaporankegiatans')->cascadeOnDelete();
            $table->foreignId('identitassurat_id')->nullable()->constrained('izin_identitassurats');
            $table->string('nipadmin_kirimbalasanlaporankegiatan')->nullable();
            $table->string('filekirim_balasanlaporankegiatan')->nullable();
            $table->date('tanggalkirim_balasanlaporankegiatan')->nullable();
            $table->string('nipadmin_cetakbalasanlaporankegiatan')->nullable();
            $table->date('tanggalcetak_balasanlaporankegiatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin_kirimbalasanlaporankegiatans');
    }
};
