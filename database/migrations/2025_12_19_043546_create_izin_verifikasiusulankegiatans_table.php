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
        Schema::create('izin_verifikasiusulankegiatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usulankegiatan_id')->constrained('izin_usulankegiatans');
            $table->date('tanggalverifikasi_inputusulankegiatan')->nullable();
            $table->string('nipadmin_verifikasiusulankegiatan')->nullable();
            $table->text('catatan_verifikasiusulankegiatan')->nullable();
            $table->enum('status_verifikasiusulankegiatan', ['accepted', 'rejected']);
            
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
        Schema::dropIfExists('izin_verifikasiusulankegiatans');
    }
};
