<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'admin']);
        $kasir = Role::create(['name' => 'kasir']);

        $arma = User::create([
            'name' => 'Arma',
            'email' => 'arma@test.com',
            'password' => bcrypt('12345678'),
        ]);
        
        $arma->assignRole('admin');

        $budi = User::create([
            'name' => 'Budi',
            'email' => 'budi@test.com',
            'password' => bcrypt('12345678'),
        ]);
        
        $budi->assignRole('kasir');
    }
}
