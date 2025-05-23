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
        Schema::create('transaksi_gudang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('suplier_id')->references('id')->on('suplier')->constrained('suplier', 'id');
            $table->foreignId('barang_id')->references('id')->on('barang')->constrained('barang', 'id');
            $table->foreignId('user_id')->references('id')->on('users')->constrained('users', 'id');
            
            $table->date('tgl_transaksi');
            $table->integer('jml_barang');
            $table->decimal('harga_beli', 12, 2);
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjahit_transaksi');
    }
};
