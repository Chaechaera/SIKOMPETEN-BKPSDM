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
            $table->string('filelaporan_pesertakegiatan')->nullable();
            $table->enum('statuslaporan_pesertakegiatan', ['pending', 'approved', 'rejected', 'revisi'])->nullable();
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
