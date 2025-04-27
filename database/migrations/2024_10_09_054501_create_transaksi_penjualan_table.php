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
        Schema::create('transaksi_penjualan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->references('id')->on('pelanggan')->constrained('pelanggan', 'id');
            $table->foreignId('barang_id')->references('id')->on('barang')->constrained('barang', 'id');
            $table->foreignId('diskon_id')->nullable()->references('id')->on('diskon')->constrained('diskon', 'id');
            $table->foreignId('user_id')->references('id')->on('users')->constrained('users', 'id');
            
            $table->date('tgl_transaksi');
            $table->integer('jml_barang');
            $table->integer('total');
            $table->string('keterangan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reseller_transaksi');
    }
};
