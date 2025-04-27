<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jenis;

class JenisBarangSeeder extends Seeder
{
    public function run()
    {
        $jenisBarang = [
            ['jenis' => 'Makanan Ringan'],
            ['jenis' => 'Minuman'],
            ['jenis' => 'Bahan Pokok'],
            ['jenis' => 'Perlengkapan Rumah Tangga'],
            ['jenis' => 'Kosmetik'],
            ['jenis' => 'Alat Tulis'],
            ['jenis' => 'Peralatan Dapur'],
            ['jenis' => 'Peralatan Mandi'],
            ['jenis' => 'Peralatan Kebersihan'],
            ['jenis' => 'Obat-obatan'],
            ['jenis' => 'Peralatan Elektronik'],
            ['jenis' => 'Pakaian'],
            ['jenis' => 'Aksesoris'],
            ['jenis' => 'Mainan'],
            ['jenis' => 'Buku'],
            ['jenis' => 'Peralatan Olahraga'],
            ['jenis' => 'Peralatan Kantor'],
            ['jenis' => 'Peralatan Sekolah'],
            ['jenis' => 'Peralatan Pertukangan'],
            ['jenis' => 'Peralatan Berkebun']
        ];

        foreach ($jenisBarang as $jenis) {
            Jenis::create($jenis);
        }
    }
} 