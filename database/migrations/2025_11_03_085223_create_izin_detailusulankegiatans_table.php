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
        Schema::create('izin_detailusulankegiatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usulankegiatan_id')->constrained('izin_usulankegiatans')->cascadeOnDelete();
            $table->longText('latarbelakang_kegiatan')->nullable();
            $table->longText('dasarhukum_kegiatan')->nullable();
            $table->longText('uraian_kegiatan')->nullable();
            $table->longText('maksud_kegiatan')->nullable();
            $table->longText('tujuan_kegiatan')->nullable();
            $table->longText('hasillangsung_kegiatan')->nullable();
            $table->longText('hasilmenengah_kegiatan')->nullable();
            $table->longText('hasilpanjang_kegiatan')->nullable();
            $table->text('narasumber_kegiatan')->nullable();
            $table->longText('sasaranpeserta_kegiatan')->nullable();
            $table->decimal('alokasianggaran_kegiatan', 15, 2)->nullable();
            $table->string('jadwalpelaksanaan_kegiatan')->nullable();
            $table->foreignId('metodepelatihan_id')->constrained('ref_metodepelatihans');
            $table->longText('detailhasil_kegiatan')->nullable();
            $table->text('penyelenggara_kegiatan')->nullable();
            $table->text('penutup_kegiatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin_detailusulankegiatans');
    }
};
