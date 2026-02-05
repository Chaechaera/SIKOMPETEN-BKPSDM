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
            //$table->foreign('nipadmin_cetakusulankegiatan')->references('nip')->on('users')->onDelete('set null');
            $table->foreignId('pjunitkerja_id')->nullable();
            $table->foreignId('ttdunitkerja_id')->nullable();
            $table->foreignId('stempelunitkerja_id')->nullable();
            $table->enum('statususulan_kegiatan', ['draft', 'pending', 'accepted', 'rejected', 'in_progress', 'completed', 'finish'])->nullable();
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
