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
        Schema::create('izin_inputusulankegiatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usulankegiatan_id')->constrained('izin_usulankegiatans');
            $table->unsignedBigInteger('kirimbalasanusulankegiatan_id')->nullable();
            $table->foreignId('pjunitkerja_id')->nullable();
            $table->foreignId('kopunitkerja_id')->nullable()->constrained('izin_kopunitkerjas')->nullOnDelete();
            $table->string('nama_kegiatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin_inputusulankegiatans');
    }
};
