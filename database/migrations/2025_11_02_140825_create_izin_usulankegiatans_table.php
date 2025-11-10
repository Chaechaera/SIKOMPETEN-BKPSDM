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
            $table->foreignId('identitassurat_id')->constrained('izin_identitassurats');
            $table->foreignId('subunitkerja_id')->constrained('ref_subunitkerjas');
            $table->string('nama_kegiatan');
            $table->string('lokasi_kegiatan');
            $table->foreignId('carapelatihan_id')->constrained('ref_carapelatihans');
            $table->date('tanggalpelaksanaan_kegiatan');
            $table->enum('statususulan_kegiatan', ['draft', 'pending', 'accepted', 'rejected', 'in_progress', 'completed', 'finish'])->default('draft');
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
