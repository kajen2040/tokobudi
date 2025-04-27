<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\JenisBarangSeeder;
use Database\Seeders\SatuanSeeder;
use Database\Seeders\BarangSeeder;
use Database\Seeders\PelangganSeeder;
use Database\Seeders\SuplierSeeder;
use Database\Seeders\DiskonSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            RolesAndPermissionsSeeder::class,
            JenisBarangSeeder::class,
            SatuanSeeder::class,
            BarangSeeder::class,
            PelangganSeeder::class,
            SuplierSeeder::class,
            DiskonSeeder::class,
        ]);
    }
}
