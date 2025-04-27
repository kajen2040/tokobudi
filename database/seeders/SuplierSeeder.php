<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Suplier;

class SuplierSeeder extends Seeder
{
    public function run()
    {
        $suplier = [
            [
                'nama' => 'PT Sumber Makmur',
                'alamat' => 'Jl. Industri No. 10, Jakarta',
                'no_hp' => '02112345678'
            ],
            [
                'nama' => 'CV Jaya Abadi',
                'alamat' => 'Jl. Raya Bandung No. 25, Bandung',
                'no_hp' => '02212345678'
            ],
            [
                'nama' => 'UD Sejahtera',
                'alamat' => 'Jl. Raya Surabaya No. 15, Surabaya',
                'no_hp' => '03112345678'
            ],
            [
                'nama' => 'PT Barokah Jaya',
                'alamat' => 'Jl. Magelang No. 30, Yogyakarta',
                'no_hp' => '027412345678'
            ],
            [
                'nama' => 'CV Sentosa',
                'alamat' => 'Jl. Pemuda No. 45, Semarang',
                'no_hp' => '02412345678'
            ],
            [
                'nama' => 'PT Makmur Sejahtera',
                'alamat' => 'Jl. Medan No. 20, Medan',
                'no_hp' => '06112345678'
            ],
            [
                'nama' => 'UD Lancar Jaya',
                'alamat' => 'Jl. Makassar No. 35, Makassar',
                'no_hp' => '041112345678'
            ],
            [
                'nama' => 'PT Indah Permai',
                'alamat' => 'Jl. Asia Afrika No. 50, Bandung',
                'no_hp' => '02212345679'
            ],
            [
                'nama' => 'CV Berkah Abadi',
                'alamat' => 'Jl. Veteran No. 12, Surabaya',
                'no_hp' => '03112345679'
            ],
            [
                'nama' => 'PT Sinar Jaya',
                'alamat' => 'Jl. Thamrin No. 8, Jakarta',
                'no_hp' => '02112345679'
            ],
            [
                'nama' => 'UD Maju Jaya',
                'alamat' => 'Jl. Dipati Ukur No. 22, Bandung',
                'no_hp' => '02212345680'
            ],
            [
                'nama' => 'PT Sejahtera Makmur',
                'alamat' => 'Jl. Veteran No. 18, Yogyakarta',
                'no_hp' => '027412345679'
            ],
            [
                'nama' => 'CV Lancar Jaya',
                'alamat' => 'Jl. Gajah Mada No. 33, Semarang',
                'no_hp' => '02412345679'
            ],
            [
                'nama' => 'PT Barokah Makmur',
                'alamat' => 'Jl. Sudirman No. 28, Jakarta',
                'no_hp' => '02112345680'
            ],
            [
                'nama' => 'UD Sumber Rejeki',
                'alamat' => 'Jl. Merdeka No. 15, Surabaya',
                'no_hp' => '03112345680'
            ],
            [
                'nama' => 'PT Jaya Abadi',
                'alamat' => 'Jl. Asia Afrika No. 40, Bandung',
                'no_hp' => '02212345681'
            ],
            [
                'nama' => 'CV Makmur Sejahtera',
                'alamat' => 'Jl. Gatot Subroto No. 25, Jakarta',
                'no_hp' => '02112345681'
            ],
            [
                'nama' => 'PT Sentosa Jaya',
                'alamat' => 'Jl. Diponegoro No. 35, Yogyakarta',
                'no_hp' => '027412345680'
            ],
            [
                'nama' => 'UD Berkah Jaya',
                'alamat' => 'Jl. Ahmad Yani No. 50, Semarang',
                'no_hp' => '02412345680'
            ],
            [
                'nama' => 'PT Lancar Makmur',
                'alamat' => 'Jl. Pahlawan No. 30, Medan',
                'no_hp' => '06112345679'
            ]
        ];

        foreach ($suplier as $supplier) {
            Suplier::create($supplier);
        }
    }
} 