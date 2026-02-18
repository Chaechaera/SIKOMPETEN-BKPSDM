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
        Schema::create('izin_kirimusulankegiatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inputusulankegiatan_id')->constrained('izin_inputusulankegiatans')->cascadeOnDelete();
            $table->foreignId('identitassurat_id')->constrained('izin_identitassurats');
            $table->string('filekirim_inputusulankegiatan')->nullable();
            $table->date('tanggalkirim_inputusulankegiatan')->nullable();
            $table->string('nipadmin_inputusulankegiatan')->nullable();
            $table->enum('statususulan_kegiatan', ['draft', 'pending', 'need_review', 'revisi'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin_kirimusulankegiatans');
    }
};
