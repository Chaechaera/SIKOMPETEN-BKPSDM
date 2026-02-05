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
        Schema::create('izin_cetaklaporankegiatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inputlaporankegiatan_id');
            $table->string('nipadmin_cetaklaporankegiatan')->nullable();
            //$table->foreign('nipadmin_cetaklaporankegiatan')->references('nip')->on('users')->onDelete('set null');
            $table->foreignId('pjunitkerja_id')->nullable();
            $table->foreignId('ttdunitkerja_id')->nullable();
            $table->foreignId('stempelunitkerja_id')->nullable();
            $table->enum('statuslaporan_kegiatan', ['draft', 'pending', 'accepted', 'rejected', 'in_progress', 'completed', 'finish'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin_cetaklaporankegiatans');
    }
};
