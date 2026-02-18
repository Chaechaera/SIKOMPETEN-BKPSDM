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
            $table->foreignId('inputusulankegiatan_id')->nullable()->constrained('izin_inputusulankegiatans')->nullOnDelete();
            $table->foreignId('inputlaporankegiatan_id')->nullable()->constrained('izin_inputlaporankegiatans')->nullOnDelete();
            $table->foreignId('sertifikat_id')->nullable()->constrained('izin_sertifikats')->nullOnDelete();
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
