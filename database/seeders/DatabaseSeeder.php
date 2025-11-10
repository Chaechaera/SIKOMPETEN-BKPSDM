<?php

namespace Database\Seeders;

use App\Izin\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        \Spatie\Permission\Models\Permission::firstOrCreate(['name' => 'view superadmin dashboard', 'guard_name' => 'web']);
        \Spatie\Permission\Models\Permission::firstOrCreate(['name' => 'view admin dashboard', 'guard_name' => 'web']);

    }
}
