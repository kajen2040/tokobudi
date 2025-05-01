<?php

use App\Models\TransaksiGudang;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DiskonController;
use App\Http\Controllers\LayoutController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuplierController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\TransaksiReturController;
use App\Http\Controllers\TransaksiGudangController;
use App\Http\Controllers\TransaksiPenjualanController;
use App\Http\Controllers\LaporanController;

// Routes accessible by both kasir and admin
Route::middleware(['auth', 'verified', 'role:kasir|admin'])->group(function () {
    Route::get('/', [PageController::class, 'dashboard'])->name('dashboard');
 
    Route::prefix('barang')
        ->name('barang.')
        ->group(function () {
            Route::get('/', [BarangController::class, 'index'])
                ->name('index');

            Route::get('jenis', [JenisController::class, 'index'])
                ->name('jenis');

            Route::get('satuan', [SatuanController::class, 'index'])
                ->name('satuan');

            Route::get('diskon', [DiskonController::class, 'index'])
                ->name('diskon');
        }
    );

    Route::prefix('transaksi')
        ->name('transaksi.')
        ->group(function () {
            Route::get('/gudang', [TransaksiGudangController::class, 'index'])
                ->name('gudang');

            Route::get('/penjualan', [TransaksiPenjualanController::class, 'index'])
                ->name('penjualan');

            Route::get('/penjualan/tambah', [TransaksiPenjualanController::class, 'tambah'])
                ->name('penjualan.tambah');
            
            Route::post('/penjualan', [TransaksiPenjualanController::class, 'store'])
                ->name('penjualan.store');
                
            Route::get('/penjualan/{id}', [TransaksiPenjualanController::class, 'show'])
                ->name('penjualan.show');
                
            Route::get('/penjualan/{id}/edit', [TransaksiPenjualanController::class, 'edit'])
                ->name('penjualan.edit');
                
            Route::get('/penjualan/{id}/cetak', [TransaksiPenjualanController::class, 'cetak'])
                ->name('penjualan.cetak');

            Route::get('/retur', [TransaksiReturController::class, 'index'])
                ->name('retur');
        }
    );
});

// Routes accessible only by admin
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::prefix('barang')
        ->name('barang.')
        ->group(function () {
            Route::post('/', [BarangController::class, 'store'])
                ->name('store');

            Route::put('/{id}', [BarangController::class, 'update'])
                ->name('update');
                
            Route::delete('/{id}', [BarangController::class, 'destroy'])
                ->name('destroy');

            Route::post('jenis', [JenisController::class, 'store'])
                ->name('jenis.store');

            Route::put('jenis/{id}', [JenisController::class, 'update'])
                ->name('jenis.update');
                
            Route::delete('jenis/{id}', [JenisController::class, 'destroy'])
                ->name('jenis.destroy');

            Route::post('satuan', [SatuanController::class, 'store'])
                ->name('satuan.store');

            Route::put('satuan/{id}', [SatuanController::class, 'update'])
                ->name('satuan.update');
                
            Route::delete('satuan/{id}', [SatuanController::class, 'destroy'])
                ->name('satuan.destroy');

            Route::post('diskon', [DiskonController::class, 'store'])
                ->name('diskon.store');

            Route::put('diskon/{id}', [DiskonController::class, 'update'])
                ->name('diskon.update');
                
            Route::delete('diskon/{id}', [DiskonController::class, 'destroy'])
                ->name('diskon.destroy');
        }
    );

    Route::prefix('suplier')
        ->name('suplier.')
        ->group(function () {
            Route::get('/', [SuplierController::class, 'index'])
                ->name('index');

            Route::post('/', [SuplierController::class, 'store'])
                ->name('store');

            Route::put('/{id}', [SuplierController::class, 'update'])
                ->name('update');
                
            Route::delete('/{id}', [SuplierController::class, 'destroy'])
                ->name('destroy');
        }
    );

    Route::prefix('pelanggan')
        ->name('pelanggan.')
        ->group(function () {
            Route::get('/', [PelangganController::class, 'index'])
                ->name('index');

            Route::post('/', [PelangganController::class, 'store'])
                ->name('store');

            Route::put('/{id}', [PelangganController::class, 'update'])
                ->name('update');
                
            Route::delete('/{id}', [PelangganController::class, 'destroy'])
                ->name('destroy');
        }
    );

    Route::prefix('transaksi')
        ->name('transaksi.')
        ->group(function () {
            Route::post('/gudang', [TransaksiGudangController::class, 'store'])
                ->name('gudang.store');

            Route::put('/gudang/{id}', [TransaksiGudangController::class, 'update'])
                ->name('gudang.update');

            Route::delete('/gudang/{id}', [TransaksiGudangController::class, 'destroy'])
                ->name('gudang.destroy');
                
            Route::put('/penjualan/{id}', [TransaksiPenjualanController::class, 'update'])
                ->name('penjualan.update');

            Route::delete('/penjualan/{id}', [TransaksiPenjualanController::class, 'destroy'])
                ->name('penjualan.destroy');

            Route::post('/retur', [TransaksiReturController::class, 'store'])
                ->name('retur.store');

            Route::put('/retur/{id}', [TransaksiReturController::class, 'update'])
                ->name('retur.update');

            Route::delete('/retur/{id}', [TransaksiReturController::class, 'destroy'])
                ->name('retur.destroy');
        }
    );

    Route::prefix('users')
        ->name('users.')
        ->group(function () {
            Route::get('/', [UserController::class, 'index'])
                ->name('index');

            Route::post('/', [UserController::class, 'store'])
                ->name('store');

            Route::put('/{user}', [UserController::class, 'update'])
                ->name('update');

            Route::delete('/{user}', [UserController::class, 'destroy'])
                ->name('destroy');
        }
    );

    Route::prefix('laporan')
        ->name('laporan.')
        ->group(function () {
            Route::get('/', [LaporanController::class, 'index'])
                ->name('index');
        }
    );
});

// Theme and layout switchers
Route::get('theme-switcher/{activeTheme}', [ThemeController::class, 'switch'])->name('theme-switcher');
Route::get('layout-switcher/{activeLayout}', [LayoutController::class, 'switch'])->name('layout-switcher');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
