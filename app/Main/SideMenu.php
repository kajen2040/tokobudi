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
        try {
            $menu = [
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
                            'route_name' => 'transaksi.gudang',
                            'title' => 'Gudang'
                        ],
                        'penjualan' => [
                            'icon' => 'activity',
                            'route_name' => 'transaksi.penjualan',
                            'title' => 'Penjualan'
                        ],
                        'retur' => [
                            'icon' => 'activity',
                            'route_name' => 'transaksi.retur',
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
                ]
            ];

            // Check if user is authenticated and has admin role
            if (Auth::check() && Auth::user()->hasRole('admin')) {
                $menu['laporan'] = [
                    'icon' => 'file-text',
                    'route_name' => 'laporan.index',
                    'title' => 'Laporan'
                ];
                $menu['users'] = [
                    'icon' => 'users',
                    'route_name' => 'users.index',
                    'title' => 'Users'
                ];
            }

            return $menu;
        } catch (\Exception $e) {
            // Log the error and return basic menu
            \Log::error('Menu Error: ' . $e->getMessage());
            return [
                'dashboard' => [
                    'icon' => 'home',
                    'route_name' => 'dashboard',
                    'title' => 'Dashboard'
                ]
            ];
        }
    }
}
