<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
    {
        Schema::table('izin_usulankegiatans', function (Blueprint $table) {
            $table->timestamp('admin_archived_at')
                ->nullable()
                ->after('updated_at');

            $table->timestamp('superadmin_archived_at')
                ->nullable()
                ->after('admin_archived_at');
        });
    }

    public function down(): void
    {
        Schema::table('izin_usulankegiatans', function (Blueprint $table) {
            $table->dropColumn([
                'admin_archived_at',
                'superadmin_archived_at'
            ]);
        });
    }
};