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

Route::middleware(['auth', 'verified', 'role:super admin|admin|reseller'])->group(function () {
    // Route::get('/tes', [PageController::class, 'tes'])->name('tes');
});

Route::middleware(['auth', 'verified', 'role:super admin|admin'])->group(function () {
    
    Route::get('/', [PageController::class, 'dashboard'])->name('dashboard');
 
    Route::prefix('barang')
        ->name('barang.')
        ->group(function () {
            Route::get('/', [BarangController::class, 'index'])
                ->name('index');

            Route::post('/', [BarangController::class, 'store'])
                ->name('store');

            Route::put('/{id}', [BarangController::class, 'update'])
                ->name('update');
                
            Route::delete('/{id}', [BarangController::class, 'destroy'])
                ->name('destroy');

            Route::get('jenis', [JenisController::class, 'index'])
                ->name('jenis');

            Route::post('jenis', [JenisController::class, 'store'])
                ->name('jenis.store');

            Route::put('jenis/{id}', [JenisController::class, 'update'])
                ->name('jenis.update');
                
            Route::delete('jenis/{id}', [JenisController::class, 'destroy'])
                ->name('jenis.destroy');

            Route::get('satuan', [SatuanController::class, 'index'])
                ->name('satuan');

            Route::post('satuan', [SatuanController::class, 'store'])
                ->name('satuan.store');

            Route::put('satuan/{id}', [SatuanController::class, 'update'])
                ->name('satuan.update');
                
            Route::delete('satuan/{id}', [SatuanController::class, 'destroy'])
                ->name('satuan.destroy');

            Route::get('diskon', [DiskonController::class, 'index'])
                ->name('diskon');

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
            Route::get('/gudang', [TransaksiGudangController::class, 'index'])
                ->name('gudang');

            Route::post('/gudang', [TransaksiGudangController::class, 'store'])
                ->name('gudang.store');

            Route::put('/gudang/{id}', [TransaksiGudangController::class, 'update'])
                ->name('gudang.update');

            Route::delete('/gudang/{id}', [TransaksiGudangController::class, 'destroy'])
                ->name('gudang.destroy');

            Route::get('/penjualan', [TransaksiPenjualanController::class, 'index'])
                ->name('penjualan');

            Route::get('/penjualan/tambah', [TransaksiPenjualanController::class, 'tambah'])
                ->name('penjualan.tambah');

            Route::get('/retur', [TransaksiReturController::class, 'index'])
                ->name('retur');
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

Route::get('theme-switcher/{activeTheme}', [ThemeController::class, 'switch'])->name('theme-switcher');
Route::get('layout-switcher/{activeLayout}', [LayoutController::class, 'switch'])->name('layout-switcher');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
