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
        Schema::create('izin_kirimlaporankegiatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inputlaporankegiatan_id')->constrained('izin_inputlaporankegiatans')->cascadeOnDelete();
            $table->foreignId('identitassurat_id')->constrained('izin_identitassurats');
            $table->string('filekirim_inputlaporankegiatan')->nullable();
            $table->date('tanggalkirim_inputlaporankegiatan')->nullable();
            $table->string('nipadmin_inputlaporankegiatan')->nullable();
            $table->enum('statuslaporan_kegiatan', ['completed', 'pending', 'need_review', 'revisi'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin_kirimlaporankegiatans');
    }
};
