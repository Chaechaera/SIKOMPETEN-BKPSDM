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
        Schema::create('izin_usulankegiatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subunitkerja_id')->constrained('ref_subunitkerjas');
            $table->foreignId('unitkerja_id')->constrained('ref_unitkerjas');
            $table->string('lokasi_kegiatan')->nullable();
            $table->foreignId('carapelatihan_id')->nullable()->constrained('ref_carapelatihans');
            $table->date('tanggalmulai_kegiatan')->nullable();
            $table->date('tanggalselesai_kegiatan')->nullable();
            $table->time('waktumulai_kegiatan')->nullable();
            $table->time('waktuselesai_kegiatan')->nullable();
            $table->enum('statususulan_kegiatan', ['draft', 'pending', 'need_review', 'revisi'])->nullable();
            $table->unsignedInteger('dibuat_oleh')->nullable();
            $table->foreign('dibuat_oleh')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin_usulankegiatans');
    }
};
