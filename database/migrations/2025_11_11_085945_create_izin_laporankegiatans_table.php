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
        Schema::create('izin_laporankegiatans', function (Blueprint $table) {
            $table->id();
            $table->string('lokasi_kegiatan');
            $table->date('tanggalmulai_kegiatan');
            $table->date('tanggalselesai_kegiatan');
            $table->time('waktumulai_kegiatan');
            $table->time('waktuselesai_kegiatan');
            $table->enum('statuslaporan_kegiatan', ['completed', 'pending', 'need_review', 'revisi'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin_laporankegiatans');
    }
};
