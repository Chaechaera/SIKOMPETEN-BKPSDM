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
        Schema::create('izin_sertifikats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporankegiatan_id')->nullable()->constrained('izin_laporankegiatans')->nullOnDelete();
            $table->foreignId('inputusulankegiatan_id')->nullable()->constrained('izin_inputusulankegiatans')->nullOnDelete();
            $table->string('templatesertifikat_kegiatan')->nullable();
            $table->json('fieldstemplatesertifikat_kegiatan')->nullable();
            $table->string('nomorsertifikat_kegiatan')->nullable();
            $table->date('tanggalkeluarsertifikat_kegiatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin_sertifikats');
    }
};
