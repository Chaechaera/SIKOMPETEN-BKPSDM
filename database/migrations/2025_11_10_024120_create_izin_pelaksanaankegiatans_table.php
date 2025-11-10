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
        Schema::create('izin_pelaksanaankegiatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usulankegiatan_id')->constrained('izin_usulankegiatans');
            $table->text('buktipelaksanaan_kegiatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin_pelaksanaankegiatans');
    }
};
