<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\LayoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuplierController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\SatuanController;

Route::middleware(['auth', 'verified', 'role:super admin|admin|reseller'])->group(function () {
    // Route::get('/tes', [PageController::class, 'tes'])->name('tes');
});

Route::middleware(['auth', 'verified', 'role:super admin|admin'])->group(function () {
    
    Route::get('/', [PageController::class, 'dashboardOverview1'])->name('dashboard');
 
    Route::prefix('barang')
        ->name('barang.')
        ->group(function () {
            Route::get('/', [BarangController::class, 'index'])
                ->name('index');

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

            Route::get('diskon', [BarangController::class, 'diskon'])
                ->name('diskon');
        }
    );

    Route::prefix('suplier')
        ->name('suplier.')
        ->group(function () {
            Route::get('/', [SuplierController::class, 'index'])
                ->name('index');
        }
    );

    Route::prefix('pelanggan')
        ->name('pelanggan.')
        ->group(function () {
            Route::get('/', [PelangganController::class, 'index'])
                ->name('index');
        }
    );

    Route::prefix('transaksi')
        ->name('transaksi.')
        ->group(function () {
            Route::get('/', [BarangController::class, 'penjualan'])
                ->name('penjualan');
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
