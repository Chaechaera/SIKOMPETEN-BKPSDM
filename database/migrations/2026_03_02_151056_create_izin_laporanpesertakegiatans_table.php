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
        Schema::create('izin_laporanpesertakegiatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesertakegiatan_id')->constrained('izin_pesertakegiatans');
            $table->foreignId('sertifikat_id')->nullable()->constrained('izin_sertifikats');
            $table->enum('statuslaporan_pesertakegiatan', ['pending', 'approved', 'rejected', 'revisi'])->nullable();
            $table->text('catatanlaporan_pesertakegiatan')->nullable();
            $table->text('uraianpeserta_kegiatan')->nullable();
            $table->text('tujuanpeserta_kegiatan')->nullable();
            $table->text('rangkumanpeserta_kegiatan')->nullable();
            $table->text('kesimpulanpeserta_kegiatan')->nullable();
            $table->text('hambatanpeserta_kegiatan')->nullable();
            $table->text('solusipeserta_kegiatan')->nullable();
            $table->text('dokumentasipeserta_kegiatan')->nullable();
            $table->timestamp('uploaded_at')->nullable();   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin_laporanpesertakegiatans');
    }
};
