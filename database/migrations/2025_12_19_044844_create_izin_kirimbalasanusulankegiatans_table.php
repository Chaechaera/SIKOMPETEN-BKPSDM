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
        Schema::create('izin_kirimbalasanusulankegiatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inputusulankegiatan_id')->constrained('izin_inputusulankegiatans')->cascadeOnDelete();;
            $table->foreignId('identitassurat_id')->nullable()->constrained('izin_identitassurats');
            $table->string('nipadmin_kirimbalasanusulankegiatan')->nullable();
            $table->string('filekirim_balasanusulankegiatan')->nullable();
            $table->date('tanggalkirim_balasanusulankegiatan')->nullable();
            $table->string('nipadmin_cetakbalasanusulankegiatan')->nullable();
            $table->date('tanggalcetak_balasanusulankegiatan')->nullable();            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin_kirimbalasanusulankegiatans');
    }
};
