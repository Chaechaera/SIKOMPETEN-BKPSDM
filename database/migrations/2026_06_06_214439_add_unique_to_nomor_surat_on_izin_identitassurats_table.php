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
        Schema::table('izin_identitassurats', function (Blueprint $table) {
            $table->unique('nomor_surat');
        });
    }

    public function down(): void
    {
        Schema::table('izin_identitassurats', function (Blueprint $table) {
            $table->dropUnique(['nomor_surat']);
        });
    }
};
