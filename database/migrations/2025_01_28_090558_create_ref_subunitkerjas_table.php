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
        // Pastikan hanya dibuat kalau belum ada
        if (!Schema::hasTable('ref_subunitkerjas')) {
            Schema::create('ref_subunitkerjas', function (Blueprint $table) {
                $table->id();
                $table->foreignId('unitkerja_id')->constrained('ref_unitkerjas');
                $table->string('sub_unitkerja');
                $table->string('singkatan')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ref_subunitkerjas');
    }
};
