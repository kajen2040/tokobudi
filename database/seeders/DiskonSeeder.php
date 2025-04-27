<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Diskon;

class DiskonSeeder extends Seeder
{
    public function run()
    {
        $diskon = [
            [
                'nama' => 'Diskon Hari Belanja Nasional',
                'persen' => '10',
                'status' => 1
            ],
            [
                'nama' => 'Diskon Hari Raya',
                'persen' => '5',
                'status' => 1
            ],
            [
                'nama' => 'Diskon Tahun Baru',
                'persen' => '15',
                'status' => 0
            ]
        ];

        foreach ($diskon as $item) {
            Diskon::create($item);
        }
    }
} 