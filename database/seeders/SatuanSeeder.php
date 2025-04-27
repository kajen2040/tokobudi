<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Satuan;

class SatuanSeeder extends Seeder
{
    public function run()
    {
        $satuan = [
            ['satuan' => 'Pcs'],
            ['satuan' => 'Kg'],
            ['satuan' => 'Gram'],
            ['satuan' => 'Liter'],
            ['satuan' => 'Ml'],
            ['satuan' => 'Box'],
            ['satuan' => 'Dus'],
            ['satuan' => 'Pak'],
            ['satuan' => 'Lusin'],
            ['satuan' => 'Kodi'],
            ['satuan' => 'Gross'],
            ['satuan' => 'Rim'],
            ['satuan' => 'Meter'],
            ['satuan' => 'Cm'],
            ['satuan' => 'Mm'],
            ['satuan' => 'Botol'],
            ['satuan' => 'Kaleng'],
            ['satuan' => 'Bungkus'],
            ['satuan' => 'Sachet'],
            ['satuan' => 'Set']
        ];

        foreach ($satuan as $unit) {
            Satuan::create($unit);
        }
    }
} 