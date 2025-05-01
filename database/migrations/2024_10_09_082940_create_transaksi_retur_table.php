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
        Schema::create('transaksi_retur', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_penjualan_detail_id')->references('id')->on('transaksi_penjualan_detail')->constrained('transaksi_penjualan_detail', 'id');
            $table->foreignId('user_id')->references('id')->on('users')->constrained('users', 'id');
            
            $table->date('tgl_transaksi');
            $table->integer('jml_barang');
            $table->string('keterangan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_retur');
    }
};
