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
        Schema::create('transaksi_penjualan_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaksi_penjualan_id');
            $table->unsignedBigInteger('barang_id');
            $table->unsignedBigInteger('diskon_id')->nullable();
            $table->integer('jml_barang');
            $table->integer('harga_satuan');
            $table->integer('subtotal');
            $table->timestamps();
            
            $table->foreign('transaksi_penjualan_id')->references('id')->on('transaksi_penjualan')->onDelete('cascade');
            $table->foreign('barang_id')->references('id')->on('barang');
            $table->foreign('diskon_id')->references('id')->on('diskon')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_penjualan_detail');
    }
};
