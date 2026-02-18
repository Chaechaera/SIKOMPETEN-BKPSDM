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
        Schema::create('izin_cetakusulankegiatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inputusulankegiatan_id')->constrained('izin_inputusulankegiatans');
            $table->string('nipadmin_cetakusulankegiatan')->nullable();
            $table->foreignId('pjunitkerja_id')->nullable();
            $table->foreignId('ttdunitkerja_id')->nullable()->constrained('izin_ttdunitkerjas')->nullOnDelete();
            $table->foreignId('stempelunitkerja_id')->nullable()->constrained('izin_stempelunitkerjas')->nullOnDelete();
            $table->enum('statususulan_kegiatan', ['draft', 'pending', 'need_review', 'revisi'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin_cetakusulankegiatans');
    }
};
