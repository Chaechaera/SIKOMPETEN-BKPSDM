<?php

namespace Database\Seeders;

use App\Izin\Models\User;
use App\Izin\Models\Izin_RefUnitkerjas;
use App\Izin\Models\Izin_RefSubunitkerjas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ===== REFERENCE DATA =====
        
        // Unit Kerja
        $bkpsdm = Izin_RefUnitkerjas::firstOrCreate(
            ['kode_unitkerja' => 'BKPSDM'],
            ['unitkerja' => 'Badan Kepegawaian Pendidikan dan Pengembangan SDM']
        );

        $pendidikan = Izin_RefUnitkerjas::firstOrCreate(
            ['kode_unitkerja' => 'DISDIK'],
            ['unitkerja' => 'Dinas Pendidikan']
        );

        $kesehatan = Izin_RefUnitkerjas::firstOrCreate(
            ['kode_unitkerja' => 'DINKES'],
            ['unitkerja' => 'Dinas Kesehatan']
        );

        // Sub Unit Kerja
        $subBKPSDM = Izin_RefSubunitkerjas::firstOrCreate(
            ['sub_unitkerja' => 'Pusat BKPSDM'],
            [
                'unitkerja_id' => $bkpsdm->id,
                'singkatan' => 'BKPSDM'
            ]
        );

        $subPendidikan = Izin_RefSubunitkerjas::firstOrCreate(
            ['sub_unitkerja' => 'Bagian Pengembangan SDM - Dinas Pendidikan'],
            [
                'unitkerja_id' => $pendidikan->id,
                'singkatan' => 'DISDIK'
            ]
        );

        $subKesehatan = Izin_RefSubunitkerjas::firstOrCreate(
            ['sub_unitkerja' => 'Bagian Pengembangan SDM - Dinas Kesehatan'],
            [
                'unitkerja_id' => $kesehatan->id,
                'singkatan' => 'DINKES'
            ]
        );

        // ===== TEST USERS UNTUK DEVELOPMENT =====
        // Gunakan credentials ini untuk testing multiple roles sekaligus (buka di browser tab berbeda)
        
        // 1. SUPERADMIN / BKPSDM
        User::firstOrCreate(
            ['email' => 'superadmin@bkpsdm.local'],
            [
                'nip' => '1985010120000001',
                'nama' => 'Admin BKPSDM',
                'password' => Hash::make('password123'),
                'role' => 'superadmin',
                'status' => 'aktif',
                'email_verified_at' => now(),
                'subunitkerja_id' => $subBKPSDM->id,
            ]
        );

        // 2. ADMIN OPD (Dinas Pendidikan)
        User::firstOrCreate(
            ['email' => 'admin.pendidikan@opd.local'],
            [
                'nip' => '1985010120000002',
                'nama' => 'Admin Dinas Pendidikan',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'status' => 'aktif',
                'email_verified_at' => now(),
                'subunitkerja_id' => $subPendidikan->id,
            ]
        );

        // 3. ADMIN OPD (Dinas Kesehatan)
        User::firstOrCreate(
            ['email' => 'admin.kesehatan@opd.local'],
            [
                'nip' => '1985010120000003',
                'nama' => 'Admin Dinas Kesehatan',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'status' => 'aktif',
                'email_verified_at' => now(),
                'subunitkerja_id' => $subKesehatan->id,
            ]
        );

        // 4. USER PESERTA
        User::firstOrCreate(
            ['email' => 'peserta@example.local'],
            [
                'nip' => '1985010120000004',
                'nama' => 'Peserta Pelatihan',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'status' => 'aktif',
                'email_verified_at' => now(),
            ]
        );

        // Setup permissions
        \Spatie\Permission\Models\Permission::firstOrCreate(['name' => 'view superadmin dashboard', 'guard_name' => 'web']);
        \Spatie\Permission\Models\Permission::firstOrCreate(['name' => 'view admin dashboard', 'guard_name' => 'web']);
    }
}
