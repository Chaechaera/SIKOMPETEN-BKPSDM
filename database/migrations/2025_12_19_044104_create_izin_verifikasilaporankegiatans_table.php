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
        Schema::create('izin_verifikasilaporankegiatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporankegiatan_id')->constrained('izin_laporankegiatans');
            $table->date('tanggalverifikasi_inputlaporankegiatan')->nullable();
            $table->string('nipadmin_verifikasilaporankegiatan')->nullable();
            $table->text('catatan_verifikasilaporankegiatan')->nullable();
            $table->enum('status_verifikasilaporankegiatan', ['accepted', 'rejected']);
            
            // 🔥 AUTO-HILANG SYSTEM
            $table->boolean('is_read')->default(false);   // sudah dibaca atau belum
            $table->timestamp('read_at')->nullable();     // kapan dibaca

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin_verifikasilaporankegiatans');
    }
};
