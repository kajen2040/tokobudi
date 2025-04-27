<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;
use App\Models\BarangDetail;
use App\Models\Jenis;
use App\Models\Satuan;

class BarangSeeder extends Seeder
{
    public function run()
    {
        $barang = [
            [
                'nama' => 'Beras Premium',
                'foto' => 'beras.jpg',
                'stok' => 0,
                'status' => 1,
                'detail' => [
                    'jenis_id' => 3,
                    'satuan_id' => 2,
                    'harga_beli' => 12000,
                    'harga_jual' => 15000,
                    'barcode' => '899999900001'
                ]
            ],
            [
                'nama' => 'Minyak Goreng',
                'foto' => 'minyak.jpg',
                'stok' => 0,
                'status' => 1,
                'detail' => [
                    'jenis_id' => 3,
                    'satuan_id' => 4,
                    'harga_beli' => 25000,
                    'harga_jual' => 30000,
                    'barcode' => '899999900002'
                ]
            ],
            [
                'nama' => 'Gula Pasir',
                'foto' => 'gula.jpg',
                'stok' => 0,
                'status' => 1,
                'detail' => [
                    'jenis_id' => 3,
                    'satuan_id' => 2,
                    'harga_beli' => 15000,
                    'harga_jual' => 18000,
                    'barcode' => '899999900003'
                ]
            ],
            [
                'nama' => 'Kopi Instan',
                'foto' => 'kopi.jpg',
                'stok' => 0,
                'status' => 1,
                'detail' => [
                    'jenis_id' => 2,
                    'satuan_id' => 19,
                    'harga_beli' => 2000,
                    'harga_jual' => 2500,
                    'barcode' => '899999900004'
                ]
            ],
            [
                'nama' => 'Teh Celup',
                'foto' => 'teh.jpg',
                'stok' => 0,
                'status' => 1,
                'detail' => [
                    'jenis_id' => 2,
                    'satuan_id' => 9,
                    'harga_beli' => 15000,
                    'harga_jual' => 18000,
                    'barcode' => '899999900005'
                ]
            ],
            [
                'nama' => 'Sabun Mandi',
                'foto' => 'sabun.jpg',
                'stok' => 0,
                'status' => 1,
                'detail' => [
                    'jenis_id' => 8,
                    'satuan_id' => 1,
                    'harga_beli' => 5000,
                    'harga_jual' => 6000,
                    'barcode' => '899999900006'
                ]
            ],
            [
                'nama' => 'Shampoo',
                'foto' => 'shampoo.jpg',
                'stok' => 0,
                'status' => 1,
                'detail' => [
                    'jenis_id' => 8,
                    'satuan_id' => 16,
                    'harga_beli' => 20000,
                    'harga_jual' => 25000,
                    'barcode' => '899999900007'
                ]
            ],
            [
                'nama' => 'Pasta Gigi',
                'foto' => 'pasta_gigi.jpg',
                'stok' => 0,
                'status' => 1,
                'detail' => [
                    'jenis_id' => 8,
                    'satuan_id' => 1,
                    'harga_beli' => 10000,
                    'harga_jual' => 12000,
                    'barcode' => '899999900008'
                ]
            ],
            [
                'nama' => 'Detergen',
                'foto' => 'detergen.jpg',
                'stok' => 0,
                'status' => 1,
                'detail' => [
                    'jenis_id' => 9,
                    'satuan_id' => 2,
                    'harga_beli' => 15000,
                    'harga_jual' => 18000,
                    'barcode' => '899999900009'
                ]
            ],
            [
                'nama' => 'Pewangi Pakaian',
                'foto' => 'pewangi.jpg',
                'stok' => 0,
                'status' => 1,
                'detail' => [
                    'jenis_id' => 9,
                    'satuan_id' => 4,
                    'harga_beli' => 20000,
                    'harga_jual' => 25000,
                    'barcode' => '899999900010'
                ]
            ],
            [
                'nama' => 'Buku Tulis',
                'foto' => 'buku.jpg',
                'stok' => 0,
                'status' => 1,
                'detail' => [
                    'jenis_id' => 6,
                    'satuan_id' => 1,
                    'harga_beli' => 3000,
                    'harga_jual' => 4000,
                    'barcode' => '899999900011'
                ]
            ],
            [
                'nama' => 'Pulpen',
                'foto' => 'pulpen.jpg',
                'stok' => 0,
                'status' => 1,
                'detail' => [
                    'jenis_id' => 6,
                    'satuan_id' => 1,
                    'harga_beli' => 2000,
                    'harga_jual' => 3000,
                    'barcode' => '899999900012'
                ]
            ],
            [
                'nama' => 'Pensil',
                'foto' => 'pensil.jpg',
                'stok' => 0,
                'status' => 1,
                'detail' => [
                    'jenis_id' => 6,
                    'satuan_id' => 1,
                    'harga_beli' => 1500,
                    'harga_jual' => 2000,
                    'barcode' => '899999900013'
                ]
            ],
            [
                'nama' => 'Penghapus',
                'foto' => 'penghapus.jpg',
                'stok' => 0,
                'status' => 1,
                'detail' => [
                    'jenis_id' => 6,
                    'satuan_id' => 1,
                    'harga_beli' => 1000,
                    'harga_jual' => 1500,
                    'barcode' => '899999900014'
                ]
            ],
            [
                'nama' => 'Penggaris',
                'foto' => 'penggaris.jpg',
                'stok' => 0,
                'status' => 1,
                'detail' => [
                    'jenis_id' => 6,
                    'satuan_id' => 1,
                    'harga_beli' => 5000,
                    'harga_jual' => 6000,
                    'barcode' => '899999900015'
                ]
            ],
            [
                'nama' => 'Kertas HVS',
                'foto' => 'kertas.jpg',
                'stok' => 0,
                'status' => 1,
                'detail' => [
                    'jenis_id' => 17,
                    'satuan_id' => 12,
                    'harga_beli' => 30000,
                    'harga_jual' => 35000,
                    'barcode' => '899999900016'
                ]
            ],
            [
                'nama' => 'Tinta Printer',
                'foto' => 'tinta.jpg',
                'stok' => 0,
                'status' => 1,
                'detail' => [
                    'jenis_id' => 17,
                    'satuan_id' => 1,
                    'harga_beli' => 50000,
                    'harga_jual' => 60000,
                    'barcode' => '899999900017'
                ]
            ],
            [
                'nama' => 'Stapler',
                'foto' => 'stapler.jpg',
                'stok' => 0,
                'status' => 1,
                'detail' => [
                    'jenis_id' => 17,
                    'satuan_id' => 1,
                    'harga_beli' => 15000,
                    'harga_jual' => 20000,
                    'barcode' => '899999900018'
                ]
            ],
            [
                'nama' => 'Isi Stapler',
                'foto' => 'isi_stapler.jpg',
                'stok' => 0,
                'status' => 1,
                'detail' => [
                    'jenis_id' => 17,
                    'satuan_id' => 1,
                    'harga_beli' => 5000,
                    'harga_jual' => 7000,
                    'barcode' => '899999900019'
                ]
            ],
            [
                'nama' => 'Map Plastik',
                'foto' => 'map.jpg',
                'stok' => 0,
                'status' => 1,
                'detail' => [
                    'jenis_id' => 17,
                    'satuan_id' => 1,
                    'harga_beli' => 2000,
                    'harga_jual' => 3000,
                    'barcode' => '899999900020'
                ]
            ]
        ];

        foreach ($barang as $item) {
            $detail = $item['detail'];
            unset($item['detail']);
            
            $barang = Barang::create($item);
            $detail['barang_id'] = $barang->id;
            BarangDetail::create($detail);
        }
    }
} 