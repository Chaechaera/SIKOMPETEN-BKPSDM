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
        Schema::create('izin_kopunitkerjas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unitkerja_id')->constrained('ref_unitkerjas')->cascadeOnDelete();
            $table->foreignId('subunitkerja_id')->nullable()->constrained('ref_subunitkerjas')->nullOnDelete();
            $table->string('nama_opd');
            $table->text('lokasi_opd')->nullable();
            $table->string('telepon_opd', 30)->nullable();
            $table->string('faxmile_opd', 30)->nullable();
            $table->string('website_opd')->nullable();
            $table->string('email_opd')->nullable();
            $table->string('kodepos_opd', 10)->nullable();
            $table->string('gambarkop_opd')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin_kopunitkerjas');
    }
};
