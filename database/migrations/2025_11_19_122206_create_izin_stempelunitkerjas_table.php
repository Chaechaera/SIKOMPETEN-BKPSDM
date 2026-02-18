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
        Schema::create('izin_stempelunitkerjas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unitkerja_id')->constrained('ref_unitkerjas')->cascadeOnDelete();
            $table->foreignId('subunitkerja_id')->nullable()->constrained('ref_subunitkerjas')->nullOnDelete();
            $table->string('gambarstempel_opd')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin_stempelunitkerjas');
    }
};
