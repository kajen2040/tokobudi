<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pelanggan;

class PelangganSeeder extends Seeder
{
    public function run()
    {
        $pelanggan = [
            [
                'nama' => 'Umum',
                'alamat' => 'Jl. Merdeka',
                'no_hp' => '081234567890'
            ],
            [
                'nama' => 'Budi Santoso',
                'alamat' => 'Jl. Sudirman No. 25, Bandung',
                'no_hp' => '081234567891'
            ],
            [
                'nama' => 'Dedi Kurniawan',
                'alamat' => 'Jl. Gatot Subroto No. 15, Surabaya',
                'no_hp' => '081234567892'
            ],
            [
                'nama' => 'Rina Fitriani',
                'alamat' => 'Jl. Diponegoro No. 30, Yogyakarta',
                'no_hp' => '081234567893'
            ],
            [
                'nama' => 'Agus Setiawan',
                'alamat' => 'Jl. Ahmad Yani No. 45, Semarang',
                'no_hp' => '081234567894'
            ],
            [
                'nama' => 'Siti Rahayu',
                'alamat' => 'Jl. Pahlawan No. 20, Medan',
                'no_hp' => '081234567895'
            ],
            [
                'nama' => 'Joko Susilo',
                'alamat' => 'Jl. Veteran No. 35, Makassar',
                'no_hp' => '081234567896'
            ],
            [
                'nama' => 'Linda Permata',
                'alamat' => 'Jl. Asia Afrika No. 50, Bandung',
                'no_hp' => '081234567897'
            ],
            [
                'nama' => 'Rudi Hartono',
                'alamat' => 'Jl. Pemuda No. 12, Surabaya',
                'no_hp' => '081234567898'
            ],
            [
                'nama' => 'Dewi Kusuma',
                'alamat' => 'Jl. Kartini No. 8, Jakarta',
                'no_hp' => '081234567899'
            ],
            [
                'nama' => 'Ahmad Faisal',
                'alamat' => 'Jl. Dipati Ukur No. 22, Bandung',
                'no_hp' => '081234567900'
            ],
            [
                'nama' => 'Maya Putri',
                'alamat' => 'Jl. Veteran No. 18, Yogyakarta',
                'no_hp' => '081234567901'
            ],
            [
                'nama' => 'Hendra Pratama',
                'alamat' => 'Jl. Gajah Mada No. 33, Semarang',
                'no_hp' => '081234567902'
            ],
            [
                'nama' => 'Ratna Sari',
                'alamat' => 'Jl. Thamrin No. 28, Jakarta',
                'no_hp' => '081234567903'
            ],
            [
                'nama' => 'Bambang Wijaya',
                'alamat' => 'Jl. Merdeka No. 15, Surabaya',
                'no_hp' => '081234567904'
            ],
            [
                'nama' => 'Siti Aminah',
                'alamat' => 'Jl. Sudirman No. 40, Bandung',
                'no_hp' => '081234567905'
            ],
            [
                'nama' => 'Doni Kurniawan',
                'alamat' => 'Jl. Gatot Subroto No. 25, Jakarta',
                'no_hp' => '081234567906'
            ],
            [
                'nama' => 'Rina Wulandari',
                'alamat' => 'Jl. Diponegoro No. 35, Yogyakarta',
                'no_hp' => '081234567907'
            ],
            [
                'nama' => 'Ahmad Rizki',
                'alamat' => 'Jl. Ahmad Yani No. 50, Semarang',
                'no_hp' => '081234567908'
            ],
            [
                'nama' => 'Dewi Anggraini',
                'alamat' => 'Jl. Pahlawan No. 30, Medan',
                'no_hp' => '081234567909'
            ]
        ];

        foreach ($pelanggan as $customer) {
            Pelanggan::create($customer);
        }
    }
} 