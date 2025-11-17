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
        Schema::create('izin_pesertakegiatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('detaillaporankegiatan_id')->constrained('izin_detaillaporankegiatans');
            $table->string('nama_peserta');
            $table->string('nip_peserta');
            $table->string('jabatan_peserta');
            $table->foreignId('subunitkerja_id_peserta')->constrained('ref_subunitkerjas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin_pesertakegiatans');
    }
};
