<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transaksi_penjualan', function (Blueprint $table) {
            // Hapus kolom yang tidak diperlukan lagi
            $table->dropForeign(['barang_id']);
            $table->dropForeign(['diskon_id']);
            $table->dropColumn(['barang_id', 'diskon_id', 'jml_barang']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi_penjualan', function (Blueprint $table) {
            // Kembalikan kolom yang dihapus
            $table->unsignedBigInteger('barang_id')->nullable();
            $table->unsignedBigInteger('diskon_id')->nullable();
            $table->integer('jml_barang')->default(0);
            
            $table->foreign('barang_id')->references('id')->on('barang');
            $table->foreign('diskon_id')->references('id')->on('diskon');
        });
    }
};
