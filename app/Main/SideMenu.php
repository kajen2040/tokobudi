<?php

namespace App\Main;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class SideMenu
{
    /**
     * List of side menu items.
     */
    public static function menu(): array
    {
        // if (Auth::check() && Auth::user()->hasRole('reseller')) {
        //     return [
        //         'pemetaan' => [
        //             'icon' => 'file-text',
        //             'route_name' => 'login',
        //             'title' => 'Barang'
        //         ],
        //     ];
        // } else if (Auth::check() && Auth::user()->hasRole(['super admin | admin'])) {
            return [
                'dashboard' => [
                    'icon' => 'home',
                    'route_name' => 'dashboard',
                    'title' => 'Dashboard'
                ],
                'transaksi' => [
                    'icon' => 'ShoppingCart',
                    'title' => 'Transaksi',
                    'sub_menu' => [
                        'gudang' => [
                            'icon' => 'activity',
                            'route_name' => 'login',
                            'title' => 'Gudang'
                        ],
                        'penjualan' => [
                            'icon' => 'activity',
                            'route_name' => 'transaksi.penjualan',
                            'title' => 'Penjualan'
                        ],
                        'retur' => [
                            'icon' => 'activity',
                            'route_name' => 'login',
                            'title' => 'Retur'
                        ]
                    ]
                ],
                'data' => [
                    'icon' => 'edit',
                    'title' => 'Data',
                    'sub_menu' => [
                        'jenis' => [
                            'icon' => 'activity',
                            'route_name' => 'barang.jenis',
                            'title' => 'Jenis Barang'
                        ],
                        'satuan' => [
                            'icon' => 'activity',
                            'route_name' => 'barang.satuan',
                            'title' => 'Satuan Barang'
                        ],
                        'barang' => [
                            'icon' => 'activity',
                            'route_name' => 'barang.index',
                            'title' => 'Barang'
                        ],
                        'diskon' => [
                            'icon' => 'activity',
                            'route_name' => 'barang.diskon',
                            'title' => 'Diskon'
                        ],
                        'suplier' => [
                            'icon' => 'activity',
                            'route_name' => 'suplier.index',
                            'title' => 'Suplier'
                        ],
                        'pelanggan' => [
                            'icon' => 'activity',
                            'route_name' => 'pelanggan.index',
                            'title' => 'Pelanggan'
                        ]
                    ]
                ],
                'laporan' => [
                    'icon' => 'file-text',
                    'route_name' => 'login',
                    'title' => 'Laporan'
                ],
                'users' => [
                    'icon' => 'users',
                    'route_name' => 'login',
                    'title' => 'Users'
                ],
            ];
        // } else {
        //     return [
        //         'data' => [
        //             'icon' => 'edit',
        //             'title' => 'Input Data',
        //             'sub_menu' => [
        //                 'crud-form' => [
        //                     'icon' => 'activity',
        //                     'route_name' => 'login',
        //                     'title' => 'Pembeli'
        //                 ]
        //             ]
        //         ],
        //     ];
        // }
    }
}
